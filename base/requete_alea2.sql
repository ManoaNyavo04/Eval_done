-- manisy longuer am le pdf
 select
    ce.id_coureur,
    ce.id_etape,
    c.id_equipe,
    e.longueur_km,
    v.points
 from coureur_etape ce
 join coureur c on c.id_coureur=ce.id_coureur
 join etape e on e.id_etape=ce.id_etape
 join v_classement_equipe v on v.id_equipe=c.id_equipe
 order by v.points desc


create table coeff_etape(
    id_coeff serial primary key,
    id_etape int not null,
    coeffi DECIMAL(10,2),
    FOREIGN key(id_etape) REFERENCES etape(id_etape)
);


select
    c.id_etape,
    coalesce(coeffi, 1)
from coeff_etape c;

insert into coeff_etape(id_etape, coeffi) values
    (6, 2);

create or replace view v_classement_coureur_point as
WITH c AS (
    select ct.id_etape, ct.id_coureur, co.genre, co.nom, sum(duree) as chrono,
        coalesce(sum(heure_penalite), INTERVAL '0 hours') as penalite ,
        sum(duree) + (coalesce(sum(heure_penalite), INTERVAL '0 hours') || ' hours')::INTERVAL as temps_final,
        coef.coefficient,
        dense_rank() OVER (PARTITION BY ct.id_etape ORDER BY sum(duree) + (coalesce(sum(heure_penalite), INTERVAL '0 hours') || ' hours')::INTERVAL ASC) AS rang
    from coureur_temps ct
    join coureur co on co.id_coureur=ct.id_coureur
    join v_etape_coefficient coef on coef.id_etape=ct.id_etape
    left join penalite on penalite.id_equipe=co.id_equipe and ct.id_etape=penalite.id_etape
    group by ct.id_etape, ct.id_coureur, co.genre , co.nom,coef.coefficient
)
select c.id_etape, c.id_coureur, c.nom, c.genre, c.chrono, c.penalite, c.temps_final,
    c.rang, (c.coefficient*(coalesce(points, 0))) as points
from c
left join rang_points_etape rp on c.rang=rp.rang
order by c.id_etape, c.rang;

create or replace view v_etape_coefficient as
SELECT
    e.id_etape,
    e.nom ,
    e.longueur_km ,
    e.nb_coureur,
    e.rang_etape,
    e.heure_depart,
    COALESCE(c.coeffi, 1) AS coefficient
FROM
    etape e
LEFT JOIN
    coeff_etape c on c.id_etape = e.id_etape ;

-- test oe marina ve ny valiny rehefa misy coeff etape
create or replace view v_test_tsisy_coeff as
    WITH c AS (
            select ct.id_etape, ct.id_coureur, sum(duree) + ( coalesce(sum(heure_penalite), INTERVAL '0 hours') || ' hours')::INTERVAL as duree,
            dense_rank() OVER (PARTITION BY ct.id_etape ORDER BY sum(duree) + ( coalesce(sum(heure_penalite), INTERVAL '0 hours') || ' hours')::INTERVAL ASC) AS rang
            from coureur_temps ct
            join coureur co on co.id_coureur=ct.id_coureur
            left join penalite on penalite.id_equipe=co.id_equipe and ct.id_etape=penalite.id_etape
            group by ct.id_etape, ct.id_coureur
        )
        select c.id_etape, e.nom as nom_etape, c.id_coureur, co.nom as nom_coureur, co.numero_dossard, duree, c.rang, coalesce(points, 0) as points
        from c
        join etape e on e.id_etape=c.id_etape
        join coureur co on co.id_coureur=c.id_coureur
        left join rang_points_etape rp on c.rang=rp.rang
        order by c.id_etape, rang;

-- lasa miova zany ny classement rehetra
-- v_classement etape lasa miprendre en compte coeff
create or replace view v_classement_etape as
WITH c AS (
    select ct.id_etape, ct.id_coureur,
    sum(duree) + ( coalesce(sum(heure_penalite), INTERVAL '0 hours') || ' hours')::INTERVAL as duree,
    coef.coefficient,
    dense_rank() OVER (PARTITION BY ct.id_etape ORDER BY sum(duree) + ( coalesce(sum(heure_penalite), INTERVAL '0 hours') || ' hours')::INTERVAL ASC) AS rang
    from coureur_temps ct
        join coureur co on co.id_coureur=ct.id_coureur
        join v_etape_coefficient coef on coef.id_etape=ct.id_etape
        left join penalite on penalite.id_equipe=co.id_equipe and ct.id_etape=penalite.id_etape
    group by ct.id_etape, ct.id_coureur,coef.coefficient
)
select
    c.id_etape,
    e.nom as nom_etape,
    c.id_coureur,
    co.nom as nom_coureur,
    co.numero_dossard,
    duree, c.rang,
    (c.coefficient*(coalesce(points, 0))) as points
from c
join etape e on e.id_etape=c.id_etape
join coureur co on co.id_coureur=c.id_coureur
left join rang_points_etape rp on c.rang=rp.rang
order by c.id_etape, rang;

-- miova koa ny requete am par categorie
    -- WITH v AS (
    --     select c.id_etape, c.id_coureur, cc.id_equipe, sum(duree) + ( coalesce(sum(heure_penalite), INTERVAL '0 hours') || ' hours')::INTERVAL as duree,
    --         dense_rank() OVER (PARTITION BY c.id_etape ORDER BY sum(duree) + ( coalesce(sum(heure_penalite), INTERVAL '0 hours') || ' hours')::INTERVAL ASC) AS rang
    --     from coureur_temps c
    --     join categorie_coureur co on co.id_coureur=c.id_coureur
    --     join coureur cc on cc.id_coureur=c.id_coureur
    --     join categorie cat on cat.id_categorie=co.id_categorie
    --     join v_etape_coefficient coef on c.
    --         left join penalite on penalite.id_equipe=cc.id_equipe and c.id_etape=penalite.id_etape
    --     where cat.id_categorie=1
    --     group by c.id_etape, c.id_coureur, cc.id_equipe
    --     order by c.id_etape, rang
    -- ), d AS (
    --     select id_etape, id_coureur, id_equipe, duree, v.rang, coalesce(points, 0) as points
    --     from v
    --     left join rang_points_etape rp on v.rang=rp.rang
    --     order by id_etape, v.rang
    -- )
    -- select d.id_equipe, e.nom, sum(points) as points, sum(duree) as duree, dense_rank() OVER (ORDER BY sum(points) desc) AS rang
    -- from d
    -- join equipe e on e.id_equipe=d.id_equipe
    -- group by d.id_equipe, e.nom
    -- order by rang, e.nom
