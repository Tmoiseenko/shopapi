<?php

namespace App\Http\Controllers;

use App\Product;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Session\SessionManager;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Session\Session;


class CartController extends Controller
{
    use ApiResponser;

    public function getCartId(Request $request)
    {
        if (!isset($_COOKIE['uniqueCartId'])) {
            $uniqueCartId = Str::replaceFirst(
                    'Bearer ', '', $request->header('Authorization')
                ) ?? uniqid();
            setcookie('uniqueCartId', $uniqueCartId);
        } else {
            $uniqueCartId = $_COOKIE['uniqueCartId'];
        }
        return $uniqueCartId;
    }

    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => ['required', 'numeric'],
            'qty' => ['required', 'numeric']
        ]);

        if ($validator->fails()) {
            return $this->error('Incorrect values entered', 401, ['error' => $validator->errors()]);
        }
        $fields = $request->all();
        $id = $fields['id'];
        $product = Product::find($id);

        if(!$product) {
            abort(404);
        }

        $session = new Session();
        $cart = $session->get('cart_' . $this->getCartId($request));

        $cart[$id] = [
                "name" => $product->name,
                "quantity" => $fields['qty'],
                "price" => $product->price,
        ];

        $session->set('cart_' . $this->getCartId($request), $cart);
        $session->save();
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

        $session = new Session();
        if($request->id and $request->qty)
        {
            $cart = $session->get('cart_' . $this->getCartId($request));

            $cart[$request->id]["quantity"] = $request->qty;

            $session->set('cart_' . $this->getCartId($request), $cart);

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

        $session = new Session();
        if($request->id) {

            $cart = $session->get('cart_' . $this->getCartId($request));

            if(isset($cart[$request->id])) {

                unset($cart[$request->id]);

                $session->set('cart_' . $this->getCartId($request), $cart);
                $session->save();
            }

            return $this->success([], 'Product removed successfully');
        }
    }

    public function get(Request $request)
    {
        $session = new Session();
        $cart = $session->get('cart_' . $this->getCartId($request));
        $response = [];
        foreach ($cart as $key => $item) {
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

    public function clear()
    {
        $session = new Session();
        $session->clear();
        return $this->success([], 'Cart cleared');
    }
}
