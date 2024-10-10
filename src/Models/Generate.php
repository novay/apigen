<?php

namespace Novay\Apigen\Models;

use Illuminate\Database\Eloquent\Model;

class Generate extends Model
{
    protected $table = 'wip_generate';

    protected $fillable = [
        'id', 
        'module', 
        'table_name', 
        'columns', 
        'methods', 
        'status'
    ];
}