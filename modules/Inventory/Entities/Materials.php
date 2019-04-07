<?php

namespace Modules\Inventory\Entities;

use Illuminate\Database\Eloquent\Model;

class Materials extends Model
{
    public $timestamps = false;
    protected $table = 'materials';
    protected $fillable = ['material_type','material_name','material_stock'];


}
