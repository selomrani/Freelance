<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required'],
        ]);

        $user = User::where('email', $validated['email'])->first();
        if (! $user || ! Hash::check($validated['password'], $user->password)) {
            return response()->json([
                'message' => 'Invalid credentials',
            ], 401);
        }
        $user->load($user->user_type === 'client' ? 'client' : 'freelancer');
        $token = $user->createToken($user->first_name)->plainTextToken;

        return response()->json([
            'status' => 'success',
            'token' => $token,
            'user' => $user,
        ]);
    }
}
