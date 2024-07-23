<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Classement_categorie extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_equipe','categorie', 'id_categorie', 'nom', 'points',
        'duree', 'rang', 'equipe'
    ];

    public $incrementing = false;
    public $timestamps = false;

    public function getClassementCat($id_categorie){
        $sql = "
            WITH v AS (
                select c.id_etape, c.id_coureur, cc.id_equipe, sum(duree) + ( coalesce(sum(heure_penalite), INTERVAL '0 hours') || ' hours')::INTERVAL as duree,
                    dense_rank() OVER (PARTITION BY c.id_etape ORDER BY sum(duree) + ( coalesce(sum(heure_penalite), INTERVAL '0 hours') || ' hours')::INTERVAL ASC) AS rang
                from coureur_temps c
                join categorie_coureur co on co.id_coureur=c.id_coureur
                join coureur cc on cc.id_coureur=c.id_coureur
                join categorie cat on cat.id_categorie=co.id_categorie
                    left join penalite on penalite.id_equipe=cc.id_equipe and c.id_etape=penalite.id_etape
                where cat.id_categorie=:id_categorie
                group by c.id_etape, c.id_coureur, cc.id_equipe
                order by c.id_etape, rang
            ), d AS (
                select id_etape, id_coureur, id_equipe, duree, v.rang, coalesce(points, 0) as points
                from v
                left join rang_points_etape rp on v.rang=rp.rang
                order by id_etape, v.rang
            )
            select d.id_equipe, e.nom, sum(points) as points, sum(duree) as duree, dense_rank() OVER (ORDER BY sum(points) desc) AS rang
            from d
            join equipe e on e.id_equipe=d.id_equipe
            group by d.id_equipe, e.nom
            order by rang, e.nom
        ";

        $results = DB::select($sql, ['id_categorie' => $id_categorie]);

        return $results;
    }

    public function detailsPointEquipePaCategorie($id_categorie, $id_equipe){
        $sql = "
            WITH v AS (
                SELECT
                    c.id_etape,
                    e.nom AS equipe,
                    cat.id_categorie,
                    cat.nom AS categorie,
                    cc.nom AS nom_coureur,
                    c.id_coureur,
                    cc.id_equipe,
                    SUM(duree) + (COALESCE(SUM(heure_penalite), INTERVAL '0 hours') || ' hours')::INTERVAL AS duree,
                    DENSE_RANK() OVER (PARTITION BY c.id_etape ORDER BY SUM(duree) + (COALESCE(SUM(heure_penalite), INTERVAL '0 hours') || ' hours')::INTERVAL ASC) AS rang
                FROM
                    coureur_temps c
                JOIN
                    categorie_coureur co ON co.id_coureur = c.id_coureur
                JOIN
                    coureur cc ON cc.id_coureur = c.id_coureur
                JOIN
                    equipe e ON e.id_equipe = cc.id_equipe
                JOIN
                    categorie cat ON cat.id_categorie = co.id_categorie
                LEFT JOIN
                    penalite ON penalite.id_equipe = cc.id_equipe AND c.id_etape = penalite.id_etape
                WHERE
                    cat.id_categorie = :id_categorie

                GROUP BY
                    c.id_etape, cat.id_categorie, cat.nom, c.id_coureur, cc.id_equipe, e.nom, cc.nom
                ORDER BY
                    c.id_etape, rang
            ), d AS (
                SELECT
                    id_etape,
                    equipe,
                    id_categorie,
                    categorie,
                    nom_coureur AS nom,
                    id_coureur,
                    id_equipe,
                    duree,
                    v.rang,
                    COALESCE(points, 0) AS points
                FROM
                    v
                LEFT JOIN
                    rang_points_etape rp ON v.rang = rp.rang
                ORDER BY
                    id_etape, v.rang
            )
            SELECT
                d.id_etape,
                d.id_equipe,
                d.equipe,
                d.id_categorie,
                d.categorie,
                d.nom,
                SUM(points) AS points,
                SUM(duree) AS duree,
                DENSE_RANK() OVER (ORDER BY SUM(points) DESC) AS rang
            FROM
                d
            WHERE d.id_equipe = :id_equipe
            GROUP BY
                d.id_etape, d.id_equipe, d.equipe, d.id_categorie, d.categorie, d.nom
            ORDER BY
                rang, d.equipe
        ";

        $results = DB::select($sql, ['id_categorie' => $id_categorie, 'id_equipe' => $id_equipe]);

        return $results;
    }


}
