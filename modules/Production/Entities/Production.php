<?php

namespace Modules\Production\Entities;

use Illuminate\Database\Eloquent\Model;

class production extends Model
{
    protected $fillable = ['periode','jumlah_product','product_id', 'quarter', 'status'];
    protected $table = 'production';
}
