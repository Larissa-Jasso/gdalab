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
    /**
     * Creates the login token for determinate customer
     */
    public function login(Request $request)
    {

        $request->validate([
            'email' => 'required|email'
        ]);
        $customer = Customer::where('email', $request->email)->first();
        
        if ($customer) {
            // If it is required to extend the lifetime of the token, modify the minutes
            $expiresAt = Carbon::now()->addMinutes(5);

            $token = $customer->createToken($request->email, ['*'], $expiresAt)->plainTextToken;
            if ($token) {

                $this->log($request,$customer->dni, $request->email, 'customers');

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

    /**
     * Generate a new customer record
     */
    public function CreateCustomer(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email|max:120',
                'region' => 'required|max:90',
                'commune' => 'required|max:90',
                'dni' => 'required|max:45',
                'name' => 'required|max:45',
                'last_name' => 'required|max:45',
                'address' => 'max:255',
            ]);

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

                    $this->log($request, $customer->dni, $request->email, 'customers');

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
            return $th->getMessage();
        }
    }

    /**
     * Obtain customer data
     */
    public function GetCustomer(Request $request)
    {
        $customer = auth()->user()->where('status', 'A')->with('Region', 'Commune')->first();

        $this->log($request, $customer->dni, $customer->email, 'customers');

        if ($customer) {
            $response['message'] = "Informacion retornada correctamente";
            $response['customer'] = $customer;
            $response['success'] = true;
            return $response;
        } else {
            $response['message'] = "Este usuario no esta activo";
            $response['success'] = false;
            return $response;
        }
    }
    /**
     * Delete customer record
     */
    public function DeleteCustomer(Request $request)
    {
        $customer = auth()->user();

        $delete = Customer::where([
            ['dni', $customer->dni],
            ['status', '!=', 'trash'],
        ])->update([
            'status' => 'trash'
        ]);

        $this->log($request, $customer->dni, $customer->email, 'customers');

        if ($delete) {
            $response['message'] = "Registro eliminado correctamente";
            $response['success'] = true;
            return $response;
        } else {
            $response['message'] = "El registro no existe";
            $response['success'] = false;
            return $response;
        }
    }

    /**
     * Save logs
     */
    public function log($request, $customer, $email, $table)
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
