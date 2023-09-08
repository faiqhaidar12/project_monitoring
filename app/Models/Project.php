<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $table = 'projects';
    protected $fillable = [
        'judul',
        'project_leader',
        'tanggal_mulai',
        'tanggal_berakhir',
        'nama_klien',
        'progress',
        'foto',
        'email'
    ];
}
