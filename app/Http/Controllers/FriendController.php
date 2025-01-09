<?php

namespace App\Http\Controllers;


use App\Models\Friend as FriendModel;
use App\Models\User as UserModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class FriendController extends Controller
{
    public function addFriend($receiver_id)
    {
        FriendModel::create([
            'sender_id' => Auth::user()->id,
            'receiver_id' => $receiver_id
        ]);

        return back();
    }

    public function acceptFriend($sender_id)
    {
        FriendModel::where('sender_id', $sender_id)
            ->where('receiver_id', Auth::user()->id)
            ->update([
                'status' => 'Accepted'
            ]);

        return back();
    }

    public function rejectFriend($sender_id)
    {
        FriendModel::where('sender_id', $sender_id)
            ->where('receiver_id', Auth::user()->id)
            ->delete();

        return back();
    }
}
