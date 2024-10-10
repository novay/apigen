<?php

namespace Novay\Apigen\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

use Novay\Apigen\Models\Dataset;
use Novay\Apigen\Models\Endpoint;
use Novay\Apigen\Models\User;

class CheckController extends Controller
{
    public function login(Request $request) 
    {
        return view('apigen::login');
    }

    public function check(Request $request) 
    {
        $request->validate(['token' => 'required']);
    
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $request->token,
        ])->withOptions([
            'verify' => false
        ])->get('https://api.kaltimprov.go.id/api/opd/check');

        if ($response->successful() && isset($response->json()['user_id'])) {
            User::truncate();
            User::updateOrCreate(['user_id' => $response->json()['user_id']], [
                'token' => $response->json()['token'], 
                'user_nama' => $response->json()['user_nama'],
                'opd_id' => $response->json()['opd']['id'],
                'opd_nama' => $response->json()['opd']['name'],
            ]);

            Endpoint::truncate();
            Endpoint::insert($response->json()['endpoints']);
        
            Dataset::truncate();
            Dataset::insert($response->json()['datasets']);

            Session::put('api_data', $response->json());
    
            return redirect()->route('apigen::index');

        } else {
            return redirect()->route('apigen::login')->with('error', 'Token tidak valid');
        }
    }
}