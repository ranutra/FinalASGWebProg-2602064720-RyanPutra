<?php

namespace App\Http\Controllers;


use App\Models\Chat as ChatModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function sendMessage(Request $request, $receiver_id)
    {
        $request->validate([
            'message' => 'required'
        ], [
            'message.required' => __('validation.message_required')
        ]);

        ChatModel::create([
            'sender_id' => Auth::user()->id,
            'receiver_id' => $receiver_id,
            'message' => $request->message
        ]);

        return back();
    }
}
