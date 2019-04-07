<?php

namespace Modules\Inventory\Entities;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    public $timestamps = false;
    protected $table = 'products';
    protected $fillable = ['product_name', 'product_type'];

    public function sellHistories()
    {
        return $this->hasMany('Modules\SellHistory\Entities\SellHistory');
    }
}
