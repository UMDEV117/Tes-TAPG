<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penduduk extends Model
{
    use HasFactory;

    // Nama tabel yang digunakan oleh model
    protected $table = 'penduduks'; 

    // Kolom yang dapat diisi
    protected $fillable = [
        'provinsi',
        'Total',
    ];

    // Jika menggunakan timestamp, pastikan untuk menyesuaikan dengan kolom waktu (created_at, updated_at)
    public $timestamps = true; 
}
