<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table_erreur extends Model
{
    use HasFactory;

    protected $table = 'table_erreur';
    protected $fillable = [
        'numligne', 'valeur', 'typeerreur'
    ];
    public $incrementing = false;
    public $timestamps = false;
}
