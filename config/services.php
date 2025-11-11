<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'stripe' => [
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'paypal' => [
        'client_id' => env('PAYPAL_CLIENT_ID'),
        'secret' => env('PAYPAL_SECRET'),
        'mode' => env('PAYPAL_MODE', 'sandbox'),
    ],
];


// public function buyNow(Request $request)
// {
//     $request->validate([
//         'amount' => 'required',
//         'id' => 'required',
//         'cat_id' => 'required',
//         'stripeToken' => 'nullable',
//         'payment_method' => 'required'
//     ]);

//     if ($request->payment_method === 'stripe') {
//         try {
//             \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

//             $charge = \Stripe\Charge::create([
//                 'amount' => $request->amount * 100, // Stripe expects amount in cents
//                 'currency' => 'usd',
//                 'description' => 'Study Material Purchase',
//                 'source' => $request->stripeToken,
//                 'metadata' => [
//                     'material_id' => $request->id,
//                     'category_id' => $request->cat_id,
//                     'user_id' => auth()->id(),
//                 ],
//             ]);

//             // Save purchase record
//             Purchase::create([
//                 'user_id' => auth()->id(),
//                 'study_material_id' => $request->id,
//                 'category_id' => $request->cat_id,
//                 'amount' => $request->amount,
//                 'payment_method' => 'stripe',
//                 'payment_status' => 'paid',
//                 'transaction_id' => $charge->id,
//             ]);

//             return redirect()->route('user.purchases')->with('success', 'Payment successful using Stripe.');
//         } catch (\Exception $e) {
//             return back()->with('error', 'Stripe payment failed: ' . $e->getMessage());
//         }
//     } elseif ($request->payment_method === 'paypal') {
//         $gateway = Omnipay::create('PayPal_Rest');
//         $gateway->setClientId(config('services.paypal.client_id'));
//         $gateway->setSecret(config('services.paypal.secret'));
//         $gateway->setTestMode(config('services.paypal.mode') === 'sandbox');

//         try {
//             $response = $gateway->purchase([
//                 'amount' => $request->amount,
//                 'currency' => 'USD',
//                 'returnUrl' => route('paypal.success', [
//                     'id' => $request->id,
//                     'cat_id' => $request->cat_id,
//                     'amount' => $request->amount,
//                 ]),
//                 'cancelUrl' => route('paypal.cancel'),
//             ])->send();

//             if ($response->isRedirect()) {
//                 $response->redirect(); // Redirects user to PayPal payment page
//             } else {
//                 return back()->with('error', $response->getMessage());
//             }
//         } catch (\Exception $e) {
//             return back()->with('error', 'PayPal payment failed: ' . $e->getMessage());
//         }
//     }
// }
