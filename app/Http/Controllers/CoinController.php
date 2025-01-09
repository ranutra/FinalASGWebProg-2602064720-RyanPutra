<?php

namespace App\Http\Controllers;

use App\Models\User as UserModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CoinController extends Controller
{
    public function topup()
    {
        UserModel::where('id', Auth::user()->id)->update([
            'coin' => Auth::user()->coin + 100
        ]);

        return back();
    }
}
