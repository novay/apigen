<?php

namespace Novay\Apigen\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Novay\Apigen\Models\Dataset;

class DatasetController extends Controller
{
    protected $title, $prefix, $view;
    protected $data;

    public function __construct()
    {
        $this->title = __('Dataset');

        $this->data = new Dataset;

        $this->prefix = 'apigen::datasets';
        $this->view = 'apigen::datasets';

        view()->share([
            'title' => $this->title, 
            'prefix' => $this->prefix,
            'view' => $this->view
        ]);
    }

    public function create(Request $request) 
    {
        return view("{$this->view}.create");
    }

    public function store(Request $request) 
    {
        $input = $request->validate([
            'name' => 'required', 
            'description' => 'nullable'
        ]);

        

        return view("{$this->view}.create");
    }

    public function show(Request $request, $id) 
    {
        $data = $this->data->whereSlug($id)->firstOrFail();

        return view($this->view.'.index', compact('data'));
    }
}