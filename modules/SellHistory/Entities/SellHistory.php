<?php

namespace Modules\SellHistory\Entities;

use Illuminate\Database\Eloquent\Model;

class SellHistory extends Model
{
    protected $fillable = ['period', 'product_code', 'amount'];

    public function products() {
        return $this->hasMany('Modules\Inventory\Entities\Products', 'product_code', 'product_code');
    }

    public function scopeProductSellHistory($query) {
        return $query
              ->select('sell_histories.id','sell_histories.period', 'sell_histories.product_code', 'products.product_name', 'sell_histories.amount')
              ->join('products', 'sell_histories.product_code', '=', 'products.product_code')
              ->get();
    }
}
