<?php

namespace Novay\Apigen\Models;

use Illuminate\Database\Eloquent\Model;

class Dataset extends Model
{
    protected $table = 'wip_datasets';

    protected $fillable = [
        'id', 
        'name', 
        'slug', 
        'description'
    ];

    public function endpoints()
    {
        return $this->hasMany(Endpoint::class);
    }
}