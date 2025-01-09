<?php

namespace App\Http\Controllers;

use App\Models\Avatar as AvatarModel;
use App\Models\AvatarTransaction as AvatarTransactionModel;
use App\Models\Chat as ChatModel;
use App\Models\Friend as FriendModel;
use App\Models\User as UserModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class NavigationController extends Controller
{
    public function homePage()
    {
        if (Auth::check()){
            $user = UserModel::where('id', '!=', Auth::user()->id)
                ->where('visibility', true)
                ->take(6)
                ->get();
        } else{
            $user = UserModel::where('visibility', true)
                ->take(6)
                ->get();
        }

        return view('pages.index')->with('users', $user);
    }

    public function friendPage(Request $request)
    {
        if (!Auth::check()){
            $users = UserModel::
                when($request->gender, function ($query) use ($request) {
                    return $query->where('gender', $request->gender);
                })
                ->when($request->hobbies, function ($query) use ($request) {
                    return $query->where('hobbies', 'LIKE', '%'.$request->hobbies.'%');
                })
                ->when($request->name, function ($query) use ($request) {
                    return $query->where('name', 'LIKE', '%'.$request->name.'%');
                })
                ->where('visibility', true)
                ->get();
        } else{
            $authUserId = Auth::user()->id;
            $excludedUserIds = FriendModel::where('sender_id', $authUserId)
                ->orWhere('receiver_id', $authUserId)
                ->get(['sender_id', 'receiver_id'])
                ->flatMap(function ($friend) {
                    return [$friend->sender_id, $friend->receiver_id];
                })
                ->push($authUserId)
                ->unique()
                ->toArray();

            $users = UserModel::
                whereNotIn('id', $excludedUserIds)
                ->when($request->gender, function ($query) use ($request) {
                    return $query->where('gender', $request->gender);
                })
                ->when($request->hobbies, function ($query) use ($request) {
                    return $query->where('hobbies', 'LIKE', '%'.$request->hobbies.'%');
                })
                ->when($request->name, function ($query) use ($request) {
                    return $query->where('name', 'LIKE', '%'.$request->name.'%');
                })
                ->where('visibility', true)
                ->get();
        }

        return view('pages.friend')->with('users', $users)->with('gender_filter', $request->gender)->with('hobbies_filter', $request->hobbies);
    }

    public function detailPage($user_id)
    {
        $user = UserModel::findOrFail($user_id);

        return view('pages.detail', compact('user'));
    }

    public function registerPage()
    {
        if (session()->has('payment_expires')) {
            if (now()->greaterThan(session('payment_expires'))){
                session()->flush();
            }
        }

        return view('pages.register');
    }

    public function loginPage()
    {
        return view('pages.login');
    }

    public function topupPage()
    {
        return view('pages.top-up');
    }

    public function myProfilePage()
    {
        $ownedAvatarIds = AvatarTransactionModel::where('buyer_id', Auth::user()->id)->pluck('avatar_id');

        $avatars = AvatarModel::whereIn('id', $ownedAvatarIds)->get();

        return view('pages.profile', compact('avatars'));
    }

    public function avatarShopPage()
    {
        $ownedAvatarIds = AvatarTransactionModel::where('buyer_id', Auth::user()->id)->pluck('avatar_id');

        $avatars = AvatarModel::whereNotIn('id', $ownedAvatarIds)->paginate(9);

        return view('pages.avatar-shop', compact('avatars'));
    }

    public function friendRequestPage()
    {
        $authUserId = Auth::user()->id;

        $includedUserIdsPending = FriendModel::where('receiver_id', $authUserId)
            ->where('status', 'Pending')
            ->pluck('sender_id');

        FriendModel::whereIn('sender_id', $includedUserIdsPending)
            ->where('receiver_id', $authUserId)
            ->update([
                'read_receipts' => true
            ]);

        $pendingRequests = UserModel::
            whereIn('id', $includedUserIdsPending)
            ->get();

        $includedUserIdsAccepted = FriendModel::where(function ($query) use ($authUserId) {
                $query->where('sender_id', $authUserId)
                      ->orWhere('receiver_id', $authUserId);
            })
            ->where('status', 'Accepted')
            ->get(['sender_id', 'receiver_id'])
            ->flatMap(function ($friend) {
                return [$friend->sender_id, $friend->receiver_id];
            })
            ->unique()
            ->reject(fn($id) => $id == Auth::user()->id)
            ->toArray();

        $acceptedFriends = UserModel::
            whereIn('id', $includedUserIdsAccepted)
            ->get();

        return view('pages.friend-request', compact('pendingRequests', 'acceptedFriends'));
    }

    public function chatPage($current_chat_id = null)
    {
        $chats = ChatModel::where('sender_id', Auth::user()->id)
            ->orWhere('receiver_id', Auth::user()->id)
            ->get();

        $userIds = $chats->pluck('sender_id')
            ->merge($chats->pluck('receiver_id'))
            ->unique()
            ->reject(fn($id) => $id == Auth::user()->id);

        $users = UserModel::whereIn('id', $userIds)
            ->get();

        if (!$current_chat_id){
            $chats = null;
        } else{
            $chats = ChatModel::whereIn('sender_id', [$current_chat_id, Auth::user()->id])
                ->whereIn('receiver_id', [$current_chat_id, Auth::user()->id])
                ->get();

            if ($chats->isEmpty()){
                $currentUserChat = UserModel::findOrFail($current_chat_id);
                $users->push($currentUserChat);
            } else{
                if ($chats[0]->receiver_id == Auth::user()->id){
                    foreach ($chats as $chat) {
                        $chat->read_receipts = true;
                        $chat->save();
                    }
                }
            }
        }

        return view('pages.chat', compact('chats', 'users', 'current_chat_id'));
    }

    public function notificationPage()
    {
        $authUserId = Auth::user()->id;

        $chatNotification = ChatModel::where('receiver_id', $authUserId)
            ->where('read_receipts', false)
            ->orderBy('created_at', 'desc')
            ->get();

        $includedUserIdsPending = FriendModel::where('receiver_id', $authUserId)
            ->where('status', 'Pending')
            ->where('read_receipts', false)
            ->pluck('sender_id');

        $friendRequestNotification = UserModel::
            whereIn('id', $includedUserIdsPending)
            ->get();

        return view('pages.notification', compact('chatNotification', 'friendRequestNotification'));
    }
}
