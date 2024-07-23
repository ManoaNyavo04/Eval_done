<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipe extends Model
{
    use HasFactory;

    protected $table = 'equipe';
    protected $primaryKey = 'id_equipe';
    protected $fillable = [
        'nom', 'login', 'password'
    ];
    public $incrementing = false;
    public $timestamps = false;
}
