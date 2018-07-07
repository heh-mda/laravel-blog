<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Subscription;

class SubsController extends Controller
{
    public function subscribe(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|unique:subscriptions'             
        ]);

        Subscription::add($request->get('email'));

        return redirect()->back()->with('status', 'Проверьте вашу почту');
    }
}
