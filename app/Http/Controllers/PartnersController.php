<?php

namespace App\Http\Controllers;

use App\Partner;
use Illuminate\Http\Request;

class PartnersController extends Controller
{
    public function showAllPartners()
    {
        $partners = Partner::all();
        return response($partners, 200);
    }

    public function showPartners($id)
    {
        $partner = Partner::find($id);
        return response($partner, 200);
    }

    public function createPartner(Request $request)
    {
        $type = $request->auth->type;
        if ($type == 'admin') {
            $partner = new Partner;
            $partner->name = $request['name'];
            $partner->info = $request['info'];
            $partner->image = $request['image'];
            $partner->save();
            return response()->json(['success' => 'Partner was created'], 201);
        }
        return response()->json(['error' => 'Not authorized']);
    }

    public function updatePartner(Request $request, $id)
    {
        $type = $request->auth->type;
        if ($type == 'admin') {
            $partner = Partner::findOrFail($id);
            $partner->update($request->all());
            return response()->json($partner, 200);
        }
    }

    public function deletePartner(Request $request, $id)
    {
        $type = $request->auth->type;
        if ($type == 'admin') {
            Partner::findOrFail($id)->delete();
            return response(['success' => 'Deleted successfully'], 200);
        }
    }
}
