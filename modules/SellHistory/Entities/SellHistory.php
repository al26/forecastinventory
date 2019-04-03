<?php

namespace Modules\SellHistory\Entities;

use Illuminate\Database\Eloquent\Model;

class SellHistory extends Model
{
    protected $fillable = ['period', 'quarter', 'product_code', 'amount'];

    public function products() {
        return $this->hasMany('Modules\Inventory\Entities\Products', 'product_code', 'product_code');
    }

    public function forecastAccuracies()
    {
        return $this->hasMany('Modules\Inventory\Entities\Products');
    }

    public function scopeProductSellHistory($query, &$where = []) {
        $query->select('sell_histories.id','sell_histories.period', 'sell_histories.quarter', 'sell_histories.product_code', 'products.product_name', 'sell_histories.amount')
              ->join('products', 'sell_histories.product_code', '=', 'products.product_code')
              ->orderBy('id', 'desc');
        
        if ($where && count($where) > 0) {
            $query->where(key($where), '=', $where[key($where)]);
            return $query->first();
        }
              
        return $query->get();
    }

    public function scopeGetLastPeriod($query, &$where = []) {
        $query->select('period', 'quarter')->orderBy('id', 'desc');
        if ($where && count($where) > 0) {
            $query->where(key($where), '=', $where[key($where)]);
        }
        $last = $query->first();

        if (isset($last->period)) {
            $last->period = intval($last->period) + 1;
        } else {
            $last->period = 1;
        }

        if (isset($last->quarter) && $last->quarter < 4) {
            $last->quarter = intval($last->quarter) + 1;
        } else {
            $last->quarter = 1;
        }

        return $last;
    }

    public function scopeCountProductActivePeriod($query, $product_code) {
        $totalPeriod = $query->select('period')->where('product_code', $product_code)->get()->count();
        return $totalPeriod % 12;
    }
}
