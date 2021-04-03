<?php


namespace App;


use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Session\Session;

class Cart
{
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    private function getCartId(Request $request)
    {
        if ($request->header('Authorization')) {
            $uniqueCartId = Str::replaceFirst('Bearer ', '', $request->header('Authorization'));
        } else {
            if (!isset($_COOKIE['uniqueCartId'])) {
                $uniqueCartId = uniqid();
                setcookie('uniqueCartId', $uniqueCartId);
            } else {
                $uniqueCartId = $_COOKIE['uniqueCartId'];
            }
        }
        return $uniqueCartId;
    }

    public function add(Product $product, $quantity = 1)
    {
        $session = new Session();
        $cart = $session->get('cart_' . $this->getCartId($this->request));

        $cart[$product->id] = [
            "name" => $product->name,
            "quantity" => $quantity,
            "price" => $product->price,
        ];

        $session->set('cart_' . $this->getCartId($this->request), $cart);
        $session->save();
    }

    public function update($id, $quantity)
    {
        $session = new Session();
        $cart = $session->get('cart_' . $this->getCartId($this->request));
        $cart[$id]["quantity"] = $quantity;
        $session->set('cart_' . $this->getCartId($this->request), $cart);
    }

    public function remove($id)
    {
        $session = new Session();
        $cart = $session->get('cart_' . $this->getCartId($this->request));

        if(isset($cart[$id])) {
            unset($cart[$id]);

            $session->set('cart_' . $this->getCartId($this->request), $cart);
            $session->save();
        }
    }

    public function clear()
    {
        $session = new Session();
        $session->remove('cart_' . $this->getCartId($this->request));
        if (isset($_COOKIE['uniqueCartId'])) {
            setcookie('uniqueCartId', '', time()-3600, '/api');
        }
    }

    public function getItems()
    {
        $session = new Session();
        $cart = $session->get('cart_' . $this->getCartId($this->request));
        return $cart ?? [];
    }
}
