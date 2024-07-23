WITH v AS (
        select c.id_etape, c.id_coureur, cc.id_equipe, sum(duree) + ( coalesce(sum(heure_penalite), INTERVAL '0 hours') || ' hours')::INTERVAL as duree,
            dense_rank() OVER (PARTITION BY c.id_etape ORDER BY sum(duree) + ( coalesce(sum(heure_penalite), INTERVAL '0 hours') || ' hours')::INTERVAL ASC) AS rang
        from coureur_temps c
        join categorie_coureur co on co.id_coureur=c.id_coureur
        join coureur cc on cc.id_coureur=c.id_coureur
        join categorie cat on cat.id_categorie=co.id_categorie
            left join penalite on penalite.id_equipe=cc.id_equipe and c.id_etape=penalite.id_etape
        where cat.nom='M'
        group by c.id_etape, c.id_coureur, cc.id_equipe
        order by c.id_etape, rang
    ), d AS (
        select id_etape, id_coureur, id_equipe, duree, v.rang, coalesce(points, 0) as points
        from v
        left join rang_points_etape rp on v.rang=rp.rang
        order by id_etape, v.rang
    ), c as (
    select d.id_equipe, e.nom, sum(points) as points, sum(duree) as duree, dense_rank() OVER (ORDER BY sum(points) desc) AS rang
    from d
    join equipe e on e.id_equipe=d.id_equipe
    group by d.id_equipe, e.nom
    order by rang, e.nom
    ), b as (
        select points, count(points) as isa
        from v_classement_homme
        group by points
    )
    select *
    from c
    join b on b.points=c.points;


create view v_test_detail as
select c.id_coureur, id_equipe, sum(points) as points, sum(duree) as duree
        from v_classement_etape c
        join coureur co on co.id_coureur=c.id_coureur
        -- where id_equipe=1
        group by c.id_coureur, id_equipe
        order by id_equipe;


create view v_detail_point as
select v.*, id_equipe from v_classement_etape v
join coureur on coureur.id_coureur=v.id_coureur;
-- where id_equipe=4;
