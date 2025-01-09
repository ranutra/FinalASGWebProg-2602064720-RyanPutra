<?php

namespace App\Http\Controllers;

use App\Models\Avatar as AvatarModel;
use App\Models\AvatarTransaction as AvatarTransactionModel;
use App\Models\User as UserModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AvatarController extends Controller
{
    public function purchaseAvatar($avatar_id)
    {
        $avatar = AvatarModel::findOrFail($avatar_id);
        
        AvatarTransactionModel::create([
            'buyer_id' => Auth::user()->id,
            'avatar_id' => $avatar_id
        ]);

        UserModel::findOrFail(Auth::user()->id)->update([
            'coin' => Auth::user()->coin - $avatar->price
        ]);

        return back();
    }
}
