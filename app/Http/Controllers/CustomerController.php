<?php

namespace App\Http\Controllers;

use App\Models\Commune;
use App\Models\Customer;
use App\Models\Log;
use App\Models\Region;
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

      
        $customer = Customer::where('email', $request->email)->first();
        if ($customer) {
            // Si se requiere extender el tiempo de vida del token modificar los minutos
            $expiresAt = Carbon::now()->addMinutes(5);

            $token = $customer->createToken($request->email, ['*'], $expiresAt)->plainTextToken;
            if ($token) {

                $this->log($customer->dni,$request->email,'customers');

                $response['token'] = $token;
                $response['message'] = "Token retornado correctamente";
                $response['success'] = true;
                return $response;
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

    public function CreateCustomer(Request $request)
    {
        try {

            $loc = Region::join('communes', 'communes.region_id', 'regions.id')
                ->select(
                    'regions.*',
                    'communes.description as commune_desc',
                    'communes.status as commune_st',
                    'communes.id as commune_id'
                )
                ->where([
                    ['regions.description', $request->region],
                    ['communes.description', $request->commune],
                    ['regions.status', 'A'],
                    ['communes.status', 'A']
                ])->first();

            if ($loc) {
                $customer = Customer::create([
                    'region_id' => $loc->id,
                    'commune_id' => $loc->commune_id,
                    'dni' => $request->dni,
                    'email' => $request->email,
                    'name' => $request->name,
                    'last_name' => $request->last_name,
                    'address' => $request->address,
                ]);

                if ($customer) {
                    
                    $this->log($customer->dni,$request->email,'customers');

                    $response['message'] = "Registro exitoso";
                    $response['customer'] = $customer;
                    $response['success'] = true;
                    return $response;
                }
            } else {
                $response['message'] = "La comuna no pertenece a la region indicada";
                $response['success'] = false;
                return $response;
            }
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function log($customer,$email,$table)
    {
        $method = $request->method();
        $ip = $request->getClientIp(true);

        Log::create([
            'customer_dni' => $customer,
            'email' => $email,
            'type' => $method,
            'table' => $table,
            'ip' => $ip
        ]);
    }
}
