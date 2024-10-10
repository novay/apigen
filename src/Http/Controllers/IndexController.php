<?php

namespace Novay\Apigen\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\DB;

use Novay\Apigen\Models\Setting;

use Novay\Apigen\Models\Dataset;
use Novay\Apigen\Models\Endpoint;
use Novay\Apigen\Models\User;

class IndexController extends Controller
{
    public function index(Request $request) 
    {
        $datasets = Dataset::all();
        $setting = Setting::first();

        if ($request->filled('purpose') && $request->purpose == 'test-connection') {
            if ($setting && $this->testConnection($setting)) {
                $setting->update(['status' => 1]);
                Session::flash('success', 'Berhasil terhubung ke database.');
                return redirect()->back();
            } else {
                $setting->update(['status' => 0]);
                Session::flash('error', 'Gagal terhubung ke database.');
                return redirect()->back();
            }
        }

        return view('apigen::welcome', compact('datasets', 'setting'));
    }

    public function logout(Request $request) 
    {
        User::truncate();
        Endpoint::truncate();
        Dataset::truncate();

        Session::flush();

        return redirect()->route('apigen::login');
    }

    protected function testConnection($data)
    {
        try {
            // Buat konfigurasi koneksi sementara berdasarkan data yang ada
            config(['database.connections.temp' => [
                'driver' => 'mysql',
                'host' => $data->host,
                'port' => $data->port,
                'database' => $data->database,
                'username' => $data->username,
                'password' => $data->password,
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_ci',
                'prefix' => '',
            ]]);

            // Coba koneksi ke database
            DB::connection('temp')->getPdo();
            return true; // Koneksi berhasil
        } catch (\Exception $e) {
            return false; // Koneksi gagal
        }
    }
}
