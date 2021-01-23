<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        return User::orderBy('userid')->get();
    }

    public function show(User $user)
    {
        return $user;
    }

    public function update(Request $request, User $user)
    {
        $validated = Validator::make($request->all(), [
            'name' => 'string|min:3|max:255',
            'email' => 'email|unique:users',
            'password' => 'min:8'
        ]);

        if ($validated->fails()) {
            return response()->json($validated->errors()->first(), 400);
        }


        $usuario = $request->all();

        if ($request->has('password')) {
            $usuario['password'] = Hash::make($usuario['password']);
        }

        $user->update($usuario);

        return response()->json($user, 200);
    }

    public function destroy(User $user)
    {
        $user->delete();

        return response()->json(null, 204);
    }
}
