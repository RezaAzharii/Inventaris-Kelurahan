<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjam extends Model
{
    use HasFactory;

    protected $table = 'peminjams';
    protected $primaryKey = 'id_peminjam';
    protected $fillable = [
        'user_id',
        'nik',
        'nama_peminjam',
        'no_telp',
        'alamat',
    ];

    public function peminjamans(){
        return $this->hasMany(Peminjaman::class, 'id_peminjam', 'id_peminjam');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id_user');
    }
}