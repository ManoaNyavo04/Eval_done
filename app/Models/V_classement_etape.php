<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class V_classement_etape extends Model
{
    use HasFactory;

    protected $table = 'v_classement_etape';
    protected $fillable = [
        'id_etape', 'nom_etape', 'id_coureur', 'nom_coureur', 'numero_dossard',
        'duree', 'rang', 'points'
    ];
    public $incrementing = false;
    public $timestamps = false;
}
