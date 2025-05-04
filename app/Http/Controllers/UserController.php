<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Database\QueryException;

class UserController extends Controller
{
    public function store(Request $request)
    {
        // ...existing code...
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);
            return response()->json(['message' => 'User created successfully'], 201);
        } catch (QueryException $e) {
            if ($e->getCode() == 23000) { // SQLSTATE[23000]: Integrity constraint violation
                return response()->json(['message' => 'Account already exists'], 409);
            }
            return response()->json(['message' => 'An error occurred'], 500);
        }
    }
}
