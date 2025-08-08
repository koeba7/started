<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Metode extends Model
{
    use HasFactory;

    protected $table = 'metode';
    protected $fillable = ['nama'];

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'id_metode');
    }
}
