<?php

namespace Modules\Inventory\Entities;

use Illuminate\Database\Eloquent\Model;

class pembelian_bahanbaku extends Model
{
    protected $fillable = ['nominal_pembelian','tanggal_pembelian','jumlah_pembelian'];
    public $timestamps = false;
    protected $table = 'pembelian_bahanbaku';
}
