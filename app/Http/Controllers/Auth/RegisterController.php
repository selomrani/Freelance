<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Freelancer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function __invoke(Request $request)
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'max:255'],
            'company' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
            'user_type' => ['required', 'in:client,freelancer'],
            'skills' => ['required_if:user_type,freelancer', 'array'],
            'portfolio' => ['string'],
            'is_available' => ['boolean'],
        ]);

        $user = User::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'user_type' => $validated['user_type'],
        ]);

        if ($user->user_type == 'client') {
            Client::create([
                'user_id' => $user->id,
                'company' => $validated['company'],
                'description' => $validated['description'],
            ]);
        } elseif ($user->user_type == 'freelancer') {
            Freelancer::create([
                'user_id' => $user->id,
                'skills' => $validated['skills'],
                'portfolio' => $validated['portfolio'],
                'is_available' => $validated['is_available'],
            ]);
        }

        $token = $user->createToken($user->first_name)->plainTextToken;

        return response()->json([
            'status' => 'success',
            'token' => $token,
            'user' => $user,
        ]);
    }
}
