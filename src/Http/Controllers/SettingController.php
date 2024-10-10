<?php

namespace Novay\Apigen\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Novay\Apigen\Models\Setting;
use Session;

class SettingController extends Controller
{
    protected $title, $prefix, $view;
    protected $data;

    public function __construct()
    {
        $this->title = __('Pengaturan');

        $this->data = new Setting;

        $this->prefix = 'apigen::settings';
        $this->view = 'apigen';

        view()->share([
            'title' => $this->title, 
            'prefix' => $this->prefix,
            'view' => $this->view
        ]);
    }

    public function index(Request $request) 
    {
        $data = $this->data->first();

        if ($request->filled('purpose') && $request->purpose == 'test-connection') {
            // Lakukan tes koneksi ke database
            if ($data && $this->testConnection($data)) {
                $data->update(['status' => 1]);
                Session::flash('success', 'Berhasil terhubung ke database.');
                return redirect()->back();
            } else {
                $data->update(['status' => 0]);
                Session::flash('error', 'Gagal terhubung ke database.');
                return redirect()->back();
            }
        }

        return view("{$this->view}::settings", compact('data'));
    }

    public function store(Request $request) 
    {
        $input = $request->validate([
            'host' => 'required', 
            'port' => 'required', 
            'database' => 'required', 
            'username' => 'required', 
            'password' => 'nullable'
        ]);

        $input['driver'] = 'mysql';

        if(!$this->data->first()):
            $this->data->create($input);
        else:
            $edit = $this->data->first();
            $input['password'] = $request->filled('password') ? $request->password : $edit->password;

            $edit->update($input);
        endif;

        Session::flash('success', 'Berhasil menyimpan pengaturan');
        return redirect()->back();
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