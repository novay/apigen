<?php

namespace Novay\Apigen\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Novay\Apigen\Models\Endpoint;
use Novay\Apigen\Models\Generate;
use Novay\Apigen\Models\Setting;
use Novay\Apigen\Models\User;

class GenerateController extends Controller
{
    protected $title, $prefix, $view;
    protected $data, $generate;

    public function __construct()
    {
        $this->title = __('Generate API');

        $this->data = new Endpoint;
        $this->generate = new Generate;

        $this->prefix = 'apigen::generate';
        $this->view = 'apigen::generate';

        view()->share([
            'title' => $this->title, 
            'prefix' => $this->prefix,
            'view' => $this->view
        ]);
    }

    public function create(Request $request) 
    {
        $data = Setting::first();
        $test = $this->testConnection($data);
        if ($test) {
            $tables = DB::connection('temp')->select('SHOW TABLES');

            $tableList = array_map(function ($table) {
                return array_values((array)$table)[0];
            }, $tables);

            if($request->filled('table')):
                $table = $request->table;
                $columns = DB::connection('temp')->select("SHOW COLUMNS FROM $table");

                return view($this->view.'.create', compact('tableList', 'columns'));
            endif;

            return view($this->view.'.create', compact('tableList'));
        } else {
            Session::flash('error', 'Gagal terhubung ke database');
            return redirect()->back();
        }
    }

    public function store(Request $request) 
    {
        $input = $request->validate([
            'module' => 'required', 
            'table' => 'required', 
            'column' => 'required|array', 
            'column.*' => 'required', 
            'method' => 'required|array', 
            'method.*' => 'required'
        ]);

        $this->generate->create([
            'module' => $input['module'],
            'table_name' => $input['table'],
            'columns' => json_encode($input['column']),
            'methods' => json_encode($input['method'])
        ]);

        Session::flash('success', 'Generate API berhasil dibuat.');
        return redirect()->route('apigen::index');
    }

    protected function testConnection($data)
    {
        try {
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

            DB::connection('temp')->getPdo();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function update(Request $request, $id) 
    {
        $data = $this->generate->findOrFail($id);
        if($data->status > 0) {
            return redirect()->back()->with('error', 'API sudah dikirim.');
        }

        $user = User::first();

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $user->token,
        ])->withOptions([
            'verify' => false
        ])->post('https://api.kaltimprov.go.id/api/opd/pull', [
            'user_id' => $user->user_id, 
            'opd_id' => $user->opd_id, 
            'data' => [
                'table_name' => $data['table_name'],
                'columns' => json_decode($data['columns']),
                'methods' => $this->generateMethodsRoutes($data),
                'created_at' => $data['created_at'],
                'updated_at' => $data['updated_at'],
                'module' => $data['module'],
                'status' => $data['status'],
            ]
        ]);

        if ($response->successful()) {
            if($response->json()['success'] == true) {
                $data->update(['status' => 1]);
                
                Session::flash('success', 'API berhasil dikirim.');
                return redirect()->back();
            }
        }
    }

    protected function generateMethodsRoutes($data)
    {
        $methods = json_decode($data['methods'], true);
        $availableMethods = ['index', 'store', 'show', 'update', 'destroy'];
        $routes = [];

        foreach ($availableMethods as $method) {
            if (in_array($method, $methods)) {
                $routes[$method] = route("apigen::api.{$method}", $data['table_name']);
            }
        }

        return $routes;
    }
}