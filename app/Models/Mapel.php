<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Siswa;
use App\Models\Guru;

class Mapel extends Model
{
    use HasFactory;

    protected $table = 'mapel';

    protected $guarded = [];

    public function guru(){
        return $this->belongsToMany(Guru::class);
    }

    public function siswa(){
        return $this->belongsToMany(Siswa::class);
    }
}
