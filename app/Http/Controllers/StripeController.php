<?php

namespace App\Http\Controllers;

use Stripe\Stripe;
use Stripe\Charge;
use Illuminate\Http\Request;



class StripeController extends Controller
{
    public function stripe()
    {
        return view('stripe.input');
    }

    public function stripeCharge(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET')); //シークレットキー
        // $stripe_obj = new Stripe();
        // $stripe = $stripe_obj->setApiKey(env('STRIPE_SECRET'));

        $charge = Charge::create(array(
            'amount' => 100,
            'currency' => 'jpy',
            'source' => request()->stripeToken,
        ));
        return view('stripe.complete');
    }
}
