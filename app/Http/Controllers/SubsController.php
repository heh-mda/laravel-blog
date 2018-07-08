<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Subscription;
use Illuminate\Support\Facades\Mail;
use App\Mail\SubscribeMail;

class SubsController extends Controller
{
    public function subscribe(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|unique:subscriptions'             
        ]);

        $subs = Subscription::add($request->get('email'));
        $subs->generateToken();

        Mail::to($subs)->send(new SubscribeMail($subs));

        return redirect()->back()->with('status', 'Проверьте вашу почту');
    }

    public function verify($token)
    {
        $subs = Subscription::Where('token', $token)->firstOrFail();
        $subs->removeToken();

        return redirect()->back()->with('status', 'Ваша почта подтверждена.');
    }
}
