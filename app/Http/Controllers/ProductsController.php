<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function showAllProducts()
    {
        $products = Product::all();
        return response($products, 200);
    }

    public function showProduct($id)
    {
        $product = Product::find($id);
        return response($product, 200);
    }

    public function createProduct(Request $request)
    {
        $type = $request->auth->type;
        if ($type == 'admin') {
            $product = new Product;
            $product->name = $request['name'];
            $product->info = $request['info'];
            $product->image = $request['image'];
            $product->unitPrice = $request['unitPrice'];
            $product->save();
            return response()->json(['Success' => 'Product was created'], 201);
        }
        return response()->json(['error'=> 'Not authorized']);
    }

    public function updateProduct(Request $request, $id)
    {
        $type = $request->auth->type;
        if ($type == 'admin') {
            $product = Product::findOrFail($id);
            $product->update($request->all());
            return response()->json($product, 200);
        }
    }

    public function deleteProduct(Request $request, $id)
    {
        $type = $request->auth->type;
        if ($type == 'admin') {
            Product::findOrFail($id)->delete();
            return response(['success'=>'Deleted successfully'], 200);
        }
    }
}
