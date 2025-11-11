<?php

namespace App\Http\Controllers\user;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Stripe;
use Session;
use Stripe\Customer;
use Stripe\Subscription;
use Auth;
use App\Models\User;
use Omnipay\Omnipay;
use Stevebauman\Location\Facades\Location;
use App\Models\Package;
use App\Models\FileUpload;
use App\Models\Purchase;
use Exception;
use Illuminate\Support\Facades\Session as FacadesSession;

class SubscriptionController extends Controller
{

    public function stripePost(Request $request)
    {

        try {

            // dd(request()->ip());

            // Set your Stripe API key
            Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

            // Get the user's IP address
            $ip = '103.125.71.48';
            // Get the user's country based on IP address
            $location = Location::get($ip);

            // Check if the user's country is allowed to make payments
            $allowedCountries = ['US', 'UK', 'CA', 'AS', 'PK']; // Add more countries as needed
            if (!in_array($location->countryCode, $allowedCountries)) {
                // Country not allowed, handle it (e.g., show an error message)
                Session::flash('error', 'Payment from your country is not allowed.');
                return back();
            }
            // Convert the amount from dollars to cents
            $amountInCents = $request->amount * 100;
            // Create a charge using Stripe API
            Stripe\Charge::create([
                "amount" => $amountInCents, // Amount in cents
                "currency" => "usd",
                "source" => $request->stripeToken,
                "description" => "Test payment from https://virtuexolutions.com."
            ]);


            $package = Package::where('id', $request->package_id)->first();

            $user = Auth::user();
            $user = User::where('id', $user->id)->first();

            $user->payment_status = 1;
            $user->no_of_jokes = $package->no_of_jokes;
            $user->total_jokes = $package->no_of_jokes;
            $user->countryCode = $location->countryCode;
            $user->save();

            // Payment successful, flash success message
            Session::flash('success', 'Payment successful!');
            // return redirect()->route('user_joke');
            return redirect('/video-series');
        } catch (\Stripe\Exception\CardException $e) {
            // Card error occurred, handle it
            Session::flash('error', $e->getError()->message);
        }

        // Redirect back to the previous page
        return back();
    }


    // public function BuyNow(Request $request)
    // {
    //     // return $request()->all();
    //     $request->validate([
    //         'stripeToken' => 'required|string',
    //         'amount' => 'required|numeric|min:1',
    //     ]);

    //     try {
    //         \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

    //         $amountInCents = $request->amount * 100;

    //         $charge = \Stripe\Charge::create([
    //             "amount" => $amountInCents,
    //             "currency" => "usd",
    //             "source" => $request->stripeToken,
    //             "description" => "Test payment from https://virtuexolutions.com.",
    //         ]);

    //         $userId = Auth::id();

    //         $BuyNow = new Purchase();
    //         $BuyNow->user_id = $userId;
    //         $BuyNow->file_id = $request->id;
    //         $BuyNow->category_id = $request->cat_id;
    //         // Optional: store charge ID
    //         // $BuyNow->stripe_charge_id = $charge->id;
    //         $BuyNow->save();

    //         Session::flash('success', 'Transcript Payment Successful!');
    //         // return redirect()->route('renderPDF', ['id' => $request->id]);
    //         return redirect()->back();
    //     } catch (\Stripe\Exception\CardException $e) {
    //         Session::flash('error', $e->getError()->message);
    //         return back();
    //     }
    // }

    public function BuyNow(Request $request)
    {
        $request->validate([
            'amount' => 'required',
            'id' => 'required',
            'cat_id' => 'required',
            'stripeToken' => 'nullable',
            'payment_method' => 'required'
        ]);

        if ($request->payment_method === 'stripe') {
            try {
                \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

                $charge = \Stripe\Charge::create([
                    'amount' => $request->amount * 100, // Stripe expects amount in cents
                    'currency' => 'usd',
                    'description' => 'Study Material Purchase',
                    'source' => $request->stripeToken,
                    'metadata' => [
                        'material_id' => $request->id,
                        'category_id' => $request->cat_id,
                        'user_id' => auth()->id(),
                    ],
                ]);

                $userId = Auth::id();
                $BuyNow = new Purchase();
                $BuyNow->user_id = $userId;
                $BuyNow->file_id = $request->id;
                $BuyNow->category_id = $request->cat_id;
                $BuyNow->save();

                Session::flash('success', 'Transcript Payment Successful!');
                return redirect()->back();
            } catch (\Stripe\Exception\CardException $e) {
                Session::flash('error', $e->getError()->message);
                return back();
            }
        } elseif ($request->payment_method === 'paypal') {

            $gateway = Omnipay::create('PayPal_Rest');
            $gateway->setClientId(config('services.paypal.client_id'));
            $gateway->setSecret(config('services.paypal.secret'));
            $gateway->setTestMode(config('services.paypal.mode') === 'sandbox');

            try {
                 $response = $gateway->purchase([
                     'amount' => $request->amount,
                    'currency' => 'USD',
                    'returnUrl' => route('paypal.success', [
                        'id' => $request->id,
                         'cat_id' => $request->cat_id,
                         'amount' => $request->amount,
                    ]),
                'cancelUrl' => route('paypal.cancel'),
                 ])->send();
              
                if ($response->isRedirect()) {
                    $response->redirect(); // Redirects user to PayPal payment page
                } else {
                    return back()->with('error', $response->getMessage());
                }
            } catch (\Exception $e) {
                return back()->with('error', 'PayPal payment failed: ' . $e->getMessage());
            }
        }
    }


    public function orderPost(Request $request)
    {

        $user = auth()->user();
        $token = $request->stripeToken;
        $paymentMethod = $request->paymentMethod;
        $plan = Package::find($request->plan);

        try {
            Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

            if (is_null($user->stripe_id)) {
                $user->createAsStripeCustomer();
            }

            \Stripe\Customer::createSource($user->stripe_id, ['source' => $token]);

            $user->newSubscription($request->plan, $plan->stripe_plan)->create($paymentMethod, ['email' => $user->email]);

            // Save payment status
            $user->payment_status = 1;
            $user->save();

            return back()->with('success', 'Subscription is completed.');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Handle PayPal payment success.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */

    public function paypalSuccess(Request $request)
    {
        $gateway = Omnipay::create('PayPal_Rest');
        $gateway->setClientId(config('services.paypal.client_id'));
        $gateway->setSecret(config('services.paypal.secret'));
        $gateway->setTestMode(config('services.paypal.mode') === 'sandbox');

        if ($request->input('paymentId') && $request->input('PayerID')) {
            $transaction = $gateway->completePurchase([
                'payer_id' => $request->input('PayerID'),
                'transactionReference' => $request->input('paymentId'),
            ]);

            try {
                $response = $transaction->send();

                if ($response->isSuccessful()) {
                    $data = $response->getData();

                    Purchase::create([
                        'user_id' => auth()->id(),
                        'study_material_id' => $request->id,
                        'category_id' => $request->cat_id,
                        'amount' => $request->amount,
                        'payment_method' => 'paypal',
                        'payment_status' => 'paid',
                        'transaction_id' => $data['id'],
                    ]);

					// $userId = Auth::id();
             //   $BuyNow = new Purchase();
              //  $BuyNow->user_id = $userId;
             //   $BuyNow->file_id = $request->id;
             //   $BuyNow->category_id = $request->cat_id;
             //   $BuyNow->save();
					
                    return redirect()->back()->with('success', 'Payment successful using PayPal.');
                } else {
                    return redirect()->back()->with('error', $response->getMessage());
                }
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Payment error: ' . $e->getMessage());
            }
        } else {
            return redirect()->back()->with('error', 'Payment was not successful.');
        }
    }

    public function paypalCancel()
    {
        return redirect()->back()->with('error', 'You have cancelled the PayPal payment.');
    }
}
