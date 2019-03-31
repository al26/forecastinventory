<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;


class Role extends Model
{
    protected $table = 'roles';
    protected $primaryKey = 'id';

    public function scopeGetNames($query) {
        return Schema::hasTable('roles') ? $query->select('name')->get()->toArray() : [];
    }
}