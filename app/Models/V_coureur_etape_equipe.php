<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class V_coureur_etape_equipe extends Model
{
    use HasFactory;

    protected $table = 'v_coureur_etape_equipe';
    protected $fillable = [
        'id_coureur', 'nom', 'id_equipe', 'equipe_nom', 'id_etape',
        'duree'
    ];
    public $incrementing = false;
    public $timestamps = false;
}
