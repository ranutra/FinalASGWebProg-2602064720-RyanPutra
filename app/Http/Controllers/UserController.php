<?php

namespace App\Http\Controllers;

use App\Models\User as UserModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function changeVisibility()
    {
        $isValid = false;

        if (Auth::user()->visibility && Auth::user()->coin >= 50){
            $isValid = true;
            $price = 50;
        } else if (!Auth::user()->visibility && Auth::user()->coin >= 5){
            $isValid = true;
            $price = 5;
        }

        if ($isValid){
            UserModel::findOrFail(Auth::user()->id)->update([
                'coin' => Auth::user()->coin - $price,
                'visibility' => !Auth::user()->visibility
            ]);

            return back();
        } else{
            return back()->with('error', __('lang.insufficient_coins'));
        }
    }

    public function changeAvatar(Request $request)
    {
        UserModel::findOrFail(Auth::user()->id)->update([
            'profile_picture' => $request->avatar_imagepath
        ]);

        return back();
    }
}
