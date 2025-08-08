<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';
    protected $fillable = [
        'id_metode',
        'tanggal',
        'pukul',
        'nama',
        'contact',
        'total',
        'potongan',
        'bayar',
        'kembali',
        'status'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'pukul' => 'datetime:H:i',
        'total' => 'decimal:2',
        'potongan' => 'decimal:2',
        'bayar' => 'decimal:2',
        'kembali' => 'decimal:2'
    ];

    public function metode()
    {
        return $this->belongsTo(Metode::class, 'id_metode');
    }

    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class, 'id_transaksi');
    }
}
