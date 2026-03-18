<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'max:255'],
            'company' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
        ]);
        $user = User::create(['first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password'])]);
        $client = Client::create([
            'user_id' => $user->id,
            'company' => $validated['company'],
            'description' => $validated['description'],
        ]);
        $token = $user->createToken($user->first_name);
        $clients = Client::with('infos')->get();

        return response()->json(['status' => 'success', 'token' => $token,
            'clients' => $clients]);
    }
}
