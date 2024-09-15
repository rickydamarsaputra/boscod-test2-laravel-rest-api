<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekeningAdmin extends Model
{
    use HasFactory;
    protected $fillable = ['bank_id', 'nomor_rekening', 'nama_pemilik', 'saldo'];
}
