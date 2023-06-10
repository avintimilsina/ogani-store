<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PaymentGateway;
use App\Models\Payments;
use Illuminate\Http\Request;
use Jackiedo\Cart\Facades\Cart;

class CheckoutController extends Controller
{
    public function show()
    {
        $shoppingCart = Cart::name('shopping');
        $items = $shoppingCart->getItems();
        $total = $shoppingCart->getTotal();
        $subTotal = $shoppingCart->getSubTotal();
        return view('checkout', [
            'items' => $items,
            'total' => $total,
            'subTotal' => $subTotal,
        ]);
    }

    public function store(Request $request)
    {
        $shoppingCart = Cart::name('shopping');
        $items = $shoppingCart->getItems();
        $total = $shoppingCart->getTotal();
        $data = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'country' => 'required',
            'province' => 'required',
            'zip' => 'required',
            'district' => 'required',
            'address' => 'required',
            'payment_gateway' => 'required',
        ]);
        $address = Address::create([
            'country' => $data['country'],
            'province' => $data['province'],
            'zipcode' => $data['zip'],
            'district' => $data['district'],
            'street_address' => $data['address'],
        ]);
        $paymentGateway = PaymentGateway::where('code', $data['payment_gateway'])->first();

        $payment = Payments::create([
            'payment_gateway_id' => $paymentGateway->id,
            'payment_status' => 'NOT_PAID',
            'price_paid' => 0,
        ]);

        $order = Order::create([
            'tracking_id' => "ORA-" . uniqid(),
            'total' => $total * 100,
            'full_name' => $data['first_name'] . ' ' . $data['last_name'],
            'email' => $data['email'],
            'phone_number' => $data['phone'],
            'billing_id' => $address->id,
            'shipping_id' => $address->id,
            'payment_id' => $payment->id,
        ]);
        foreach ($items as $item) {
            $orderItem = OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->getId(),
                'name' => $item->getTitle(),
                'quantity' => $item->getQuantity(),
                'price' => $item->getPrice() * 100,
            ]);

        }
        $shoppingCart->destroy();

        return redirect()->route('payment.show', ['paymentGateway' => $data['payment_gateway']])->with(['orderId' => $order->tracking_id]);
    }
}