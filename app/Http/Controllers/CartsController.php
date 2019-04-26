<?php

namespace App\Http\Controllers;

use App\Cart;
use App\User;
use Illuminate\Http\Request;

class CartsController extends Controller
{
    public function showAllCarts(Request $request)
    {
        $type = $request->auth->type;
        if ($type == 'admin') {
            $carts = Cart::all();
            return response($carts, 200);
        }
        return response()->json(['Error' => 'Not allowed'], 400);
    }

    public function showCart(Request $request, $id)
    {
        $owner = $request->auth->id;
        $type = $request->auth->type;
        if ($owner == $id || $type == 'admin') {
            $user = User::find($id);
            $user->load('carts');
            return response($user->carts, 200);
        }
        return response()->json(['Error' => 'Not allowed'], 400);
    }

    public function showUserCarts(Request $request, $id)
    {
        $type = $request->auth->type;
        $user = $id;
        if ($type == 'admin') {
            $carts = Cart::all()->where('userId', $user)->where('confirmed', 1);
            return response($carts, 200);
        }
        return response()->json(['Error' => 'Not allowed'], 400);
    }

    public function createCart(Request $request, $id)
    {
        $owner = $request->auth->id;
        $type = $request->auth->type;
        $checkcart = Cart::where('productId', $request['productId'])->where('userId', $owner);
        $exists = $checkcart->exists();
        if (!$exists) {
            if ($owner == $id || $type == 'admin') {
                $cart = new Cart;
                $cart->productId = $request['productId'];
                $cart->quantity = $request['quantity'];
                $cart->userId = $request['userId'];
                $cart->name = $request['name'];
                $cart->info = $request['info'];
                $cart->image = $request['image'];
                $cart->unitPrice = $request['unitPrice'];
                $cart->confirmed = '0';
                $cart->save();
                return response()->json(['Success' => 'Cart was created'], 201);
            }
            return response()->json(['Error' => 'Not allowed']);
        }
        $checkcart->update(['quantity' => $request['quantity']]);
        return response()->json(['Success' => 'Cart was updated']);

    }

    public function updateCart(Request $request, $id)
    {
            $cart = Cart::findOrFail($id);
            $cart->update($request->all());
            return response()->json($cart, 200);
    }

    public function confirmCart(Request $request, $id)
    {
        $owner = $request->auth->id;
        $type = $request->auth->type;
        if ($owner == $id || $type == 'admin') {
            //  $usercart = Cart::all()->where('userId', $id);
            $usercart = Cart::all()->where('userId', $id);
            foreach ($usercart as $cart) {
                $cart->confirmed = 1;
                $cart->save();
            }
            //  response()->json($usercart, 200);
            return response()->json(['Success' => 'Cart has been confirmed']);
        }
        return response()->json(['Error' => 'Not allowed'], 400);
    }

    public function deleteCart($id)
    {
        Cart::findOrFail($id)->delete();
        return response(['Success' => 'Deleted successfully'], 200);

    }
}
