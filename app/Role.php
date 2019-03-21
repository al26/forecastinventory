<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';
    protected $primaryKey = 'id';

    public function scopeGetNames($query) {
        return $query->select('name')->get()->toArray();
    }
}