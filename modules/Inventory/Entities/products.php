<?php

namespace Modules\Inventory\Entities;

use Illuminate\Database\Eloquent\Model;

class products extends Model
{
    public $timestamps = false;
    protected $table = 'products';
    protected $fillable = ['product_name','product_type'];
}
