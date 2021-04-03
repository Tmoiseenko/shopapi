<?php

namespace App\Http\Controllers;

use App\Product;
use App\Cart;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Session\SessionManager;
use Illuminate\Support\Facades\Validator;


class CartController extends Controller
{
    use ApiResponser;



    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => ['required', 'numeric'],
            'qty' => ['numeric']
        ]);

        if ($validator->fails()) {
            return $this->error('Incorrect values entered', 401, ['error' => $validator->errors()]);
        }
        $fields = $request->all();
        $product = Product::find($fields['id']);

        if(!$product) {
            abort(404);
        }

        $cart = new Cart($request);
        $cart->add($product, $fields['qty'] ?? 1);

        return $this->success([], 'Product added to cart');

    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => ['required', 'numeric'],
            'qty' => ['required', 'numeric']
        ]);

        if ($validator->fails()) {
            return $this->error('Incorrect values entered', 401, ['error' => $validator->errors()]);
        }

        if($request->id and $request->qty)
        {
            $cart = new Cart($request);
            $cart->update($request->id, $request->qty);
            return $this->success([], 'Cart updated successfully');
        }
    }

    public function remove(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => ['required', 'numeric']
        ]);

        if ($validator->fails()) {
            return $this->error('Incorrect values entered', 401, ['error' => $validator->errors()]);
        }

        if($request->id) {
            $cart = new Cart($request);
            $cart->remove($request->id, $request->qty);
            return $this->success([], 'Product removed successfully');
        }
    }

    public function get(Request $request)
    {
        $cart = new Cart($request);
        $response = [];
        foreach ($cart->getItems() as $key => $item) {
            $response[] = [
                            'type' => 'cart',
                            'id' => (string)$key,
                            'attributes' => [
                                'name' => $item['name'],
                                'quantity' => $item['quantity'],
                                'price' => $item['price'],
                            ]
                        ];
        }
        return $this->success($response);
    }

    public function clear(Request $request)
    {
        $cart = new Cart($request);
        $cart->clear();
        return $this->success([], 'Cart cleared');
    }
}
