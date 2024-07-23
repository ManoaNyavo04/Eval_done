<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coureur_etape extends Model
{
    use HasFactory;

    protected $table = 'coureur_etape';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_etape', 'id_coureur'
    ];
    public $incrementing = false;
    public $timestamps = false;
}
