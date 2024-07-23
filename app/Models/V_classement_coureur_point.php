<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class V_classement_coureur_point extends Model
{
    use HasFactory;

    protected $table = 'v_classement_coureur_point';
    protected $fillable = [
        'id_etape' , 'id_coureur' ,  'nom'   , 'genre' ,  'chrono'  , 'penalite' , 'temps_final' , 'rang' , 'points'
    ];
    public $incrementing = false;
    public $timestamps = false;
}
