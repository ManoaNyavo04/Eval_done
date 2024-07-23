<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Categorie_coureur extends Model
{
    use HasFactory;

    protected $table = 'categorie_coureur';
    protected $primaryKey = 'id_categorie_coureur';
    protected $fillable = [
        'id_categorie', 'id_coureur'
    ];
    public $incrementing = false;
    public $timestamps = false;

    public function insertCategorieCoureur($idcategorie, $idcoureur){
        DB::statement('
            INSERT INTO categorie_coureur (id_categorie, id_coureur)
            VALUES (?, ?)',
            [$idcategorie, $idcoureur]
        );
    }
}
