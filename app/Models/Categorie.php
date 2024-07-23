<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    use HasFactory;

    protected $table = 'categorie';
    protected $primaryKey = 'id_categorie';
    protected $fillable = [
        'nom'
    ];
    public $incrementing = false;
    public $timestamps = false;
}
