<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class V_detail_point extends Model
{
    use HasFactory;

    protected $table = 'v_detail_point';
    protected $fillable = [
        'id_etape' ,  'nom_etape'   , 'id_coureur' , 'nom_coureur' , 'numero_dossard' ,  'duree'   , 'rang' , 'points',
         'id_equipe'
    ];
    public $incrementing = false;
    public $timestamps = false;
}
