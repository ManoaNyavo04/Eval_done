<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class V_etape_coefficient extends Model
{
    use HasFactory;

    protected $table = 'v_etape_coefficient';
    protected $fillable = [
        'id_etape' ,     'nom'      , 'longueur_km' , 'nb_coureur' , 'rang_etape' ,    'heure_depart'     , 'coefficient'
    ];
    public $incrementing = false;
    public $timestamps = false;
}
