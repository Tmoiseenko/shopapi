<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Http\Resources\OrderResource;
use App\Http\Resources\OrdersResource;
use App\Order;
use App\OrderItem;
use App\User;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new OrdersResource(Order::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $order = Order::create([
            'email' => auth()->user()->email,
            'phone' => auth()->user()->phone,
        ]);
        $cart = new Cart($request);
        foreach($cart->getItems() as $key => $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $key,
                'quantity' => $item["quantity"],
            ]);
        }
        $cart->clear();
        OrderResource::withoutWrapping();
        return new OrderResource($order);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        OrderResource::withoutWrapping();
        return new OrderResource($order);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        $order->delete();
        return $this->success([], 'Order was deleted');
    }

    public function userOrders(Request $request)
    {

        $order = Order::where('email', $request->user()->email)->get();

        return new OrdersResource($order);
    }
}
