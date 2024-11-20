<?php

use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;
use PayPal\Api\Payer;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Amount;

class PayPalController extends Controller
{
    private $apiContext;

    public function __construct()
    {
        $this->apiContext = new ApiContext(
            new OAuthTokenCredential(
                env('PAYPAL_CLIENT_ID'),
                env('PAYPAL_CLIENT_SECRET')
            )
        );

        $this->apiContext->setConfig([
            'mode' => env('PAYPAL_MODE'),
        ]);
    }

    public function createPayment()
    {
        $cart = session('cart');
        $total = array_sum(array_map(function ($item) {
            return $item['price'] * $item['quantity'];
        }, $cart));

        $payer = new Payer();
        $payer->setPaymentMethod("paypal");

        $amount = new Amount();
        $amount->setCurrency("USD")
               ->setTotal($total);

        $transaction = new Transaction();
        $transaction->setAmount($amount)
                    ->setDescription("Purchase from Your Store");

        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl(route('paypal.success'))
                     ->setCancelUrl(route('paypal.cancel'));

        $payment = new Payment();
        $payment->setIntent("sale")
                ->setPayer($payer)
                ->setTransactions([$transaction])
                ->setRedirectUrls($redirectUrls);

        try {
            $payment->create($this->apiContext);
            return redirect($payment->getApprovalLink());
        } catch (\Exception $ex) {
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }

    public function handlePaymentSuccess(Request $request)
    {
        $paymentId = $request->get('paymentId');
        $payerId = $request->get('PayerID');

        if (empty($paymentId) || empty($payerId)) {
            return redirect()->route('cart.show')->with('error', 'Payment failed');
        }

        $payment = Payment::get($paymentId, $this->apiContext);
        $execution = new PaymentExecution();
        $execution->setPayerId($payerId);

        try {
            $payment->execute($execution, $this->apiContext);
            session()->forget('cart');
            return redirect()->route('products.index')->with('success', 'Payment successful!');
        } catch (\Exception $ex) {
            return redirect()->route('cart.show')->with('error', 'Payment failed');
        }
    }

    public function handlePaymentCancel()
    {
        return redirect()->route('cart.show')->with('error', 'Payment cancelled');
    }
}

