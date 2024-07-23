<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etape extends Model
{
    use HasFactory;

    protected $table = 'etape';
    protected $primaryKey = 'id_etape';
    protected $fillable = [
        'nom', 'longueur_km', 'nb_coureur', 'rang_etape', 'heure_depart'
    ];
    public $incrementing = false;
    public $timestamps = false;
}
