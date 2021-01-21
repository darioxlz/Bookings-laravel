<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index() {
        return User::orderBy('userid')->get();
    }

    public function show($id) {
        return User::where('userid', '=', $id)->get();
    }

    public function store(Request $request) {
        $validated = Validator::make($request->all(), [
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8'
        ]);

        if ($validated->fails()) {
            return response()->json($validated->errors()->first(), 400);
        } else {
            $usuario = $request->all();
            $usuario['password'] = Hash::make($usuario['password']);

            $user = User::create($usuario);

            return response()->json($user, 201);
        }
    }

    public function update(Request $request, $id) {
        $validated = Validator::make($request->all(), [
            'name' => 'string|min:3|max:255',
            'email' => 'email|unique:users',
            'password' => 'min:8'
        ]);

        if ($validated->fails()) {
            return response()->json($validated->errors()->first(), 400);
        } else {
            $usuario = $request->all();

            if ($request->has('password')) {
                $usuario['password'] = Hash::make($usuario['password']);
            }

            User::findOrFail($id)->update($usuario);

            return response()->json(User::findOrFail($id), 200);
        }
    }

    public function delete($id) {
        User::findOrFail($id)->delete();

        return response()->json(null, 204);
    }
}
