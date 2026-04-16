<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poli extends Model
{
    use HasFactory;

    // Pastikan ini sesuai dengan nama tabel di database Anda (biasanya 'poli' atau 'polis')
    protected $table = 'poli'; 

    // Daftar kolom yang diizinkan untuk diisi melalui form
    protected $fillable = [
        'nama_poli',
        'keterangan',
    ];

    // Fungsi Relasi ke tabel User (Dokter)
    public function dokters()
    {
        return $this->hasMany(User::class, 'id_poli');
    }
}