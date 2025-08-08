<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    use HasFactory;

    protected $table = 'detail_transaksi';
    protected $fillable = [
        'id_transaksi',
        'id_barang',
        'nama',
        'jumlah',
        'harga',
        'diskon',
        'total'
    ];

    protected $casts = [
        'harga' => 'decimal:2',
        'diskon' => 'decimal:2',
        'total' => 'decimal:2'
    ];

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'id_transaksi');
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang');
    }
}
