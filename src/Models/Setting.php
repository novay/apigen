<?php

namespace Novay\Apigen\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'wip_settings';

    protected $fillable = [
        'driver', 
        'host', 
        'port', 
        'database', 
        'username', 
        'password', 
        'status'
    ];
}