<?php

namespace Modules\Inventory\Entities;

use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    public $timestamps = false;
    protected $table = 'product';
    protected $fillable = ['nama_product','jenis_product'];
}
