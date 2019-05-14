<?php

namespace App\Http\Controllers;

use App\Image;
use Illuminate\Http\Request;

class ImagesController extends Controller
{
    public function showAllImages()
    {
        $images = Image::all();
        return response($images, 200);
    }

    public function showImage($id)
    {
        $image = Image::find($id);
        return response($image, 200);
    }

    public function createImage(Request $request)
    {
        $type = $request->auth->type;
        if ($type == 'admin') {
            $image = new Image;
            $image->productId = $request['productId'];
            $image->path = $request['path'];
            $image->category = $request['category'];
            $image->main = $request['main'];
            $image->save();
            return response()->json(['success' => 'Image was created'], 201);
        }
        return response()->json(['error'=> 'Not authorized'], 400);
    }

    public function updateImage(Request $request, $id)
    {
        $type = $request->auth->type;
        if ($type == 'admin') {
            $image = Image::findOrFail($id);
            $image->update($request->all());
            return response()->json($image, 200);
        }
    }

    public function deleteImage(Request $request, $id)
    {
        $type = $request->auth->type;
        if ($type == 'admin') {
            Image::findOrFail($id)->delete();
            return response(['success' => 'Deleted successfully'], 200);
        }
    }
}
