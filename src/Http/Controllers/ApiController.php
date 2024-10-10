<?php

namespace Novay\Apigen\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Novay\Apigen\Models\Setting;
use Novay\Apigen\Models\Generate;

class ApiController extends Controller
{
    protected $generate, $setting, $connect, $table;

    public function __construct()
    {
        $this->setting = Setting::first();
        $this->generate = new Generate;

        $this->connect = $this->testConnection($this->setting);
        if(!$this->connect):
            dd('Connection failed', $this->setting);
        else:
            $this->table = $this->generate->whereTableName(request()->segment(2))->first();
            if(!$this->table)
                dd('Table not found');

        endif;
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

    public function index(Request $request, $slug)
    {
        if(!in_array('index', json_decode($this->table->methods)))
            return response()->json(['message' => 'Method not allowed']);

        $tables = DB::connection('temp')->table($slug)->get(json_decode($this->table->columns));
        return response()->json([
            'success' => true, 
            'data' => $tables
        ]);
    }

    public function store(Request $request)
    {
        if(!in_array('store', json_decode($this->table->methods)))
            return response()->json(['message' => 'Method not allowed']);

        $columns = json_decode($this->table->columns);
        $missing_fields = [];

        foreach ($columns as $column) {
            if (!$request->has($column)) {
                $missing_fields[] = $column;
            }
        }

        if (!empty($missing_fields)) {
            return response()->json([
                'success' => false,
                'message' => 'The following fields are required but missing: ' . implode(', ', $missing_fields),
            ], 400);
        }

        $data = $request->only($columns);
        $id = DB::connection('temp')->table($this->table->table_name)->insertGetId($data);

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil disimpan.',
            'id' => $id
        ]);
    }

    public function show(Request $request, $tableName, $id)
    {
        if(!in_array('show', json_decode($this->table->methods)))
            return response()->json(['message' => 'Method not allowed']);

        $data = DB::connection('temp')->table($this->table->table_name)->find($id, json_decode($this->table->columns));
        if(!$data)
            return response()->json(['message' => 'Data not found'], 404);

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function update(Request $request, $tableName, $id)
    {
        if(!in_array('update', json_decode($this->table->methods)))
            return response()->json(['message' => 'Method not allowed']);

        $columns = array_diff(json_decode($this->table->columns), ['id']);

        $missing_fields = [];
        foreach ($columns as $column) {
            if (!$request->has($column)) {
                $missing_fields[] = $column;
            }
        }
    
        if (!empty($missing_fields)) {
            return response()->json([
                'success' => false,
                'message' => 'The following fields are required but missing: ' . implode(', ', $missing_fields),
            ], 400);
        }
    
        $data = $request->only($columns);
        $updated = DB::connection('temp')->table($this->table->table_name)->where('id', $id)->update($data);
    
        if (!$updated) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update data'
            ], 400);
        }
    
        return response()->json([
            'success' => true,
            'message' => 'Data berhasil diperbarui.'
        ]);
    }

    public function destroy($tableName, $id)
    {
        if(!in_array('destroy', json_decode($this->table->methods)))
            return response()->json(['message' => 'Method not allowed']);

        $deleted = DB::connection('temp')->table($this->table->table_name)->where('id', $id)->delete();
        if(!$deleted)
            return response()->json(['message' => 'Failed to delete data'], 400);

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil dihapus.'
        ]);
    }
}
