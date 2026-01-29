<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjamans';
    protected $primaryKey = 'id_peminjaman';
    protected $fillable = [
        'id_peminjam',
        'id_aset',
        'tanggal_pinjam',
        'tanggal_kembali',
        'status',
        'jumlah',
        'created_by_role',
    ];

    public function peminjam()
    {
        return $this->belongsTo(Peminjam::class, 'id_peminjam', 'id_peminjam');
    }

    public function aset()
    {
        return $this->belongsTo(Aset::class, 'id_aset', 'id_aset');
    }
}
