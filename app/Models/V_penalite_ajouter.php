<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class V_penalite_ajouter extends Model
{
    use HasFactory;

    protected $table = 'v_penalite_ajouter';
    protected $fillable = [
        'id_penalite', 'id_etape', 'id_equipe', 'heure_penalite', 'etape',
        'equipe'
    ];
    public $incrementing = false;
    public $timestamps = false;
}
