<?php

namespace Novay\Apigen\Models;

use Illuminate\Database\Eloquent\Model;

class Endpoint extends Model
{
    protected $table = 'wip_endpoints';

    protected $fillable = [
        'id', 
        'name', 
        'slug', 
        'description', 
        'base_url', 
        'base_method', 
        'path', 
        'method', 
        'scope', 
        'dataset_id', 
        'is_official', 
        'is_active'
    ];

    public function dataset()
    {
        return $this->belongsTo(Dataset::class, 'dataset_id');
    }
}