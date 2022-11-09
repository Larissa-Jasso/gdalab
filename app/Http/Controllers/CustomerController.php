<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Log;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Request as Req;

class CustomerController extends Controller
{
    public function login(Request $request)
    {

        $request->validate([
            'email' => 'required|email'
        ]);

        $method = $request->method();
        $ip = $request->getClientIp(true);;
        $customer = Customer::where('email', $request->email)->first();
        if ($customer) {
            // Si se requiere extender el tiempo de vida del token modificar los minutos
            $expiresAt = Carbon::now()->addMinutes(5);

            $token = $customer->createToken($request->email, ['*'], $expiresAt)->plainTextToken;
            if ($token) {

                $log = Log::create([
                    'customer_dni' => $customer->dni,
                    'email' => $customer->email,
                    'type' => $method,
                    'table' => "customers",
                    'ip' => $ip
                ]);

                if ($log) {
                    $response['token'] = $token;
                    $response['message'] = "Token retornado correctamente";
                    $response['success'] = true;
                    return $response;
                } else {
                    $response['token'] = $token;
                    $response['message'] = "Error al guardar el log";
                    $response['success'] = false;
                    return $response;
                }
            } else {
                $response['message'] = "Error al obtener token";
                $response['success'] = false;
                return $response;
            }
        } else {
            $response['message'] = "El correo electronico no existe";
            $response['success'] = false;
            return $response;
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
