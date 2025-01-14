<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class QrCodeController extends Controller
{
    public function index()
    {
        $refercode = User::createReferCode();

        User::where('id', auth()->id())
            ->update(['affiliate_id' => $refercode]);
        return view('qrcode',compact('refercode'));
    }
}
