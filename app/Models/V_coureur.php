<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class V_coureur extends Model
{
    use HasFactory;

    protected $table = 'v_coureur';
    protected $fillable = [
        'nom', 'numero_dossard', 'genre', 'date_naissance', 'id_equipe', 'age'
    ];
    public $incrementing = false;
    public $timestamps = false;
}
