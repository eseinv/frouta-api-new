<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Validator;

class UsersController extends Controller
{

    public function showProfile(Request $request,$id)
    {
        $owner = $request->auth->id;
        $type = $request->auth->type;
        if ($owner == $id || $type == 'admin') {
            $user = User::find($id);
            return response($user,200);
        }
        return response()->json(['error' => 'Not authorized']);
    }

    public function showAllProfiles(Request $request)
    {
        $type = $request->auth->type;
        if ($type == "admin") {
            $users = User::all();
            return response()->json($users, 200);
        }
        return response()->json(['Error'=> 'Not authorized']);
    }

    public function createUser(Request $request)
    {
        $user = new User;
        $user->name = $request['name'];
        $user->email = $request['email'];
        $user->password = app('hash')->make($request['password'], $options = []);
        $user->type = 'customer';
        $user->country = $request['country'] ? $request['country'] : ' ';
        $user->street = $request['street'] ? $request['street'] : ' ';
        $user->postal = $request['postal'] ? $request['postal'] : ' ';
	$user->phone = $request['phone'] ? $request['phone'] : ' ';
	$user->save();
        return response()->json(['Success' => 'Created user successfully'], 201);
    }

    public function updateUser(Request $request, $id)
    {
		$owner = $request->auth->id;
        $type = $request->auth->type;
        if ($owner == $id || $type == 'admin') {
        	$user = User::findOrFail($id);
        	$user->update($request->all());
			if ($owner == $id && $type !== 'admin') {
				$user->type = 'customer';
				$user->save();
			}
        return response()->json($user, 200);
    	}
	}

    public function deleteUser(Request $request, $id)
    {
		$type = $request->auth->type;
		if ($type == 'admin') {
        	User::findOrFail($id)->delete();
        	return response('Deleted successfully', 200);
		}
		return response()->json(['error'=> 'Not authorized']);
    }

}
