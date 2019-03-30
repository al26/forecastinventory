<?php

namespace Modules\SellHistory\Entities;

use Illuminate\Database\Eloquent\Model;

class SellHistory extends Model
{
    protected $fillable = ['period', 'product_code', 'amount'];

    public function products() {
        return $this->hasMany('Modules\Inventory\Entities\Product', 'product_code', 'product_code');
    }
}
