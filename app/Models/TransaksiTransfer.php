<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class TransaksiTransfer extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'id_transaksi',
        'bank_pengirim_id',
        'bank_tujuan_id',
        'bank_perantara_id',
        'nilai_transfer',
        'kode_unik',
        'biaya_admin',
        'total_transfer',
        'rekening_tujuan',
        'atasnama_tujuan',
        'rekening_perantara',
        'berlaku_hingga'
    ];

    protected $casts = [
        'berlaku_hingga' => 'date'
    ];

    public function bank_perantara()
    {
        return $this->belongsTo(Bank::class, 'bank_perantara_id');
    }

    public static function generateTransactionId()
    {
        $date = Carbon::now()->format('ymd');
        $counter = self::whereDate('created_at', Carbon::today())->count() + 1;

        return 'TF' . $date . str_pad($counter, 5, '0', STR_PAD_LEFT);
    }
}
