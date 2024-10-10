<?php

namespace Novay\Apigen\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Novay\Apigen\Models\Endpoint;

class EndpointController extends Controller
{
    protected $title, $prefix, $view;
    protected $data;

    public function __construct()
    {
        $this->title = __('Endpoint');

        $this->data = new Endpoint;

        $this->prefix = 'apigen::endpoints';
        $this->view = 'apigen::endpoints';

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
}