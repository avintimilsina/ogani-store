<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{

    public function show($paymentGateway)
    {
        if (!session()->has('orderId')) {
            return redirect()->route('home');
        }

        $order = Order::where('tracking_id', session('orderId'))->first();

        if ($paymentGateway == 'cod') {
            return view('payments.cod');

        }
        if ($paymentGateway == 'khalti') {

            $parameters = [
                'return_url' => route('thankyou'),
                'website_url' => config('app.url'),
                'amount' => $order->total,
                'purchase_order_id' => $order->tracking_id,
                'purchase_order_name' => "ORDER" . $order->tracking_id,
            ];


            $response = Http::
                withHeaders([
                    'Authorization' => 'Key ' . config('khalti.live_secret_key')
                ])->post(config('khalti.base_url') . '/epayment/initiate/', $parameters);


            if ($response->failed()) {
                dd("Payment Failed");
                // return redirect()->back()->with('error', 'Something went wrong. Please try again later.');
            }

            $data = $response->json();

            return redirect($data['payment_url']);
        }
    }
    public function thankyou(Request $request)
    {
        $data = $request->all();

        $order = Order::where('tracking_id', $data['purchase_order_id'])->firstOrFail();

        $pidx = [
            'pidx' => $data['pidx']
        ];

        $response = Http::
            withHeaders([
                'Authorization' => 'Key ' . config('khalti.live_secret_key')
            ])->post(config('khalti.base_url') . '/epayment/lookup/', $pidx);

        if ($response->successful()) {
            $orderPayment = $order->payment()->update([
                'payment_status' => "PAID",
                'price_paid' => $data['amount'],
                'transaction_id' => $data['transaction_id'],
            ]);

            return view('thankyou');
        }
        if ($response->failed()) {
            $orderPayment = $order->payment()->update([
                'payment_status' => "FAILED",
                'price_paid' => $data['amount'],
                'transaction_id' => $data['transaction_id'],
            ]);
        }

        // dd($orderPayment);
    }
}