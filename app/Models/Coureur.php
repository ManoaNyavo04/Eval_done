<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coureur extends Model
{
    use HasFactory;

    protected $table = 'coureur';
    protected $primaryKey = 'id_coureur';
    protected $fillable = [
        'nom', 'numero_dossard', 'genre', 'date_naissance', 'id_equipe'
    ];
    public $incrementing = false;
    public $timestamps = false;
}
