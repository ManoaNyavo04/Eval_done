<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class V_coureur_etape extends Model
{
    use HasFactory;

    protected $table = 'v_coureur_etape';
    protected $fillable = [
        'id_etape', 'etape', 'id_coureur', 'nom_coureur', 'id_equipe'
    ];
    public $incrementing = false;
    public $timestamps = false;
}
