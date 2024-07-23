<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coureur_temps extends Model
{
    use HasFactory;

    protected $table = 'coureur_temps';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_etape', 'id_coureur', 'heure_depart', 'heure_arrivee', 'duree'
    ];
    public $incrementing = false;
    public $timestamps = false;
}
