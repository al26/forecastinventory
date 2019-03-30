<?php

namespace Modules\Inventory\Entities;

use Illuminate\Database\Eloquent\Model;

class Materials_buyment extends Model
{
    protected $fillable = ['buyment_total', 'buyment_price', 'buyment_date'];
    public $timestamps = false;
    protected $table = 'materials_buyment';
}
