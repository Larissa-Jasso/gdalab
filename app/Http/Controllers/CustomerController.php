<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CustomerController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $user = Customer::where('email', $request->email)->first();
        // Si se requiere extender el tiempo de vida del token modificar los minutos
        $expiresAt = Carbon::now()->addMinutes(5);

        $token= $user->createToken($request->email,['*'], $expiresAt)->plainTextToken;
        if($token){
            return $token;

        }

    }

    public function user(Request $request)
    {

        try {
            return $request->user();
            //code...
        } catch (\Throwable $th) {
            return $th;
        }
    }
}
