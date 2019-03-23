<?php

namespace Modules\Inventory\Entities;

use Illuminate\Database\Eloquent\Model;

class bahanbaku extends Model
{
    public $timestamps = false;
    protected $table = 'bahanbaku';
    protected $fillable = ['jenis_bahanbaku','nama_bahanbaku','jumlah_stock'];


}
