<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penalite extends Model
{
    use HasFactory;

    protected $table = 'penalite';
    protected $primaryKey = 'id_penalite';
    protected $fillable = [
        'id_equipe', 'id_etape', 'heure_penalite'
    ];
    public $incrementing = false;
    public $timestamps = false;
}
