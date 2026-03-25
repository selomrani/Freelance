<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        Auth::attempt($validated);
        $user = Auth::user();
        // $rel = $user->user_type === 'client' ? $user->client : $user->freelancer;
        if ($user->user_type == 'client') {
            $rel = $user->client;
        } elseif ($user->user_type == 'freelancer') {
            $rel = $user->freelacer;
        }

        $token = $user->createToken($user->first_name);

        return response()->json([
            'status' => 'success',
            'user_type' => $user->user_type,
            'token' => $token,
            'user infos' => $rel,
        ]);

    }
}
