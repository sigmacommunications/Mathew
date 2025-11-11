<?php

namespace App\Http\Controllers\user;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Omnipay\Omnipay;
use App\Models\Payment;

class PaymentController extends Controller
{
    private $gateway;
    public function __construct()
    {
        $this->gateway = Omnipay::create('PayPal_Rest');
        $this->gateway->setClientId(env('PAYPAL_CLIENT_ID'));
        $this->gateway->setSecret(env('PAYPAL_CLIENT_SECRET'));
        $this->gateway->setTestMode(true);
    }

    public function pay(Request $request){
        
        try{
            $response =  $this->gateway->purchase(array(
                'amount'=>$request->amount,
                'currency'=>env('PAYPAL_CURRENCY'),
                'returnUrl'=>url('success'),
                'cancelUrl'=>url('error'),
            ))->send();

           
            if($response->isRedirect()){
                $response->redirect();
            }else{
                $response->getMessage();
            }
        
        }catch(\Throwable $e){
            return $e->getMessage();
        }
    }

    public function success(Request $request)
    {
        if ($request->input('paymentId') && $request->input('PayerID')) {
            $transaction = $this->gateway->completePurchase([
                'payer_id' => $request->input('PayerID'),
                'transactionReference' => $request->input('paymentId'),
            ])->send();
    
            if ($transaction->isSuccessful()) {
                $arr = $transaction->getData();
    
                $payment = new Payment();
                $payment->payment_id = $arr['id'];
                $payment->payer_id = $arr['payer']['payer_info']['payer_id'];
                $payment->payer_email = $arr['payer']['payer_info']['payer_email'];
                $payment->amount = $arr['transactions'][0]['amount']['total'];
                $payment->currency = env('PAYPAL_CURRENCY');
                $payment->payment_status = $arr['status'];
                $payment->save();
    
                // Redirect to success page with transaction id
                return redirect()->route('payment.success', ['transaction_id' => $arr['id']]);
            } else {
                // If transaction not successful, return error message
                return $transaction->getMessage();
            }
        } else {
            // If payment details are missing, return payment declined message
            return 'Payment declined!';
        }
    }

    public function error(){
        return 'User declined the payment!';
    }
}
