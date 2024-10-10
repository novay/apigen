<?php

namespace Novay\Apigen\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'wip_users';

    protected $fillable = [
        'token', 
        'user_id', 
        'user_nama', 
        'opd_id', 
        'opd_nama'
    ];
}