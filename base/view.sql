-- v_coureur_etape j1
create or replace view v_coureur_etape as
    select
        ce.id,
        e.id_etape, e.nom as etape,
        c.id_coureur,
        c.nom as nom_coureur,
        c.id_equipe
    from coureur_etape ce
    join etape e on e.id_etape=ce.id_etape
    join coureur c on c.id_coureur=ce.id_coureur;

-- classement generale par etape
create or replace view v_classement_etape as(
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
    order by c.id_etape, rang
);

-- rehefa le jour 4 oe le résultat général (sans catégorie) par coureur de l’étape avec les infos suivantes (nom coureur, genre, chrono, pénalité, temps final,rang)
-- create or replace view classement_coureur_point as
-- WITH c AS (
--     select ct.id_etape, ct.id_coureur, co.genre, co.nom, sum(coalesce(heure_arrivee, now())-heure_depart) as chrono,
--         coalesce(sum(heure_penalite), INTERVAL '0 hours') as penalite ,
--         sum(coalesce(heure_arrivee, now())-heure_depart) + (coalesce(sum(heure_penalite), INTERVAL '0 hours') || ' hours')::INTERVAL as temps_final,
--         dense_rank() OVER (PARTITION BY ct.id_etape ORDER BY sum(coalesce(heure_arrivee, now())-heure_depart) + (coalesce(sum(heure_penalite), INTERVAL '0 hours') || ' hours')::INTERVAL ASC) AS rang
--     from coureur_temps ct
--     join coureur co on co.id_coureur=ct.id_coureur
--     left join penalite on penalite.id_equipe=co.id_equipe and ct.id_etape=penalite.id_etape
--     group by ct.id_etape, ct.id_coureur, co.genre , co.nom
-- )
-- select c.id_etape, c.id_coureur, c.nom, c.genre, c.chrono, c.penalite, c.temps_final,
--     c.rang, coalesce(points, 0) as points
-- from c
-- left join rang_points_etape rp on c.rang=rp.rang
-- order by c.id_etape, c.rang;

-- archive
create or replace view v_classement_coureur_point as
WITH c AS (
    select ct.id_etape, ct.id_coureur, co.genre, co.nom, sum(duree) as chrono,
        coalesce(sum(heure_penalite), INTERVAL '0 hours') as penalite ,
        sum(duree) + (coalesce(sum(heure_penalite), INTERVAL '0 hours') || ' hours')::INTERVAL as temps_final,
        dense_rank() OVER (PARTITION BY ct.id_etape ORDER BY sum(duree) + (coalesce(sum(heure_penalite), INTERVAL '0 hours') || ' hours')::INTERVAL ASC) AS rang
    from coureur_temps ct
    join coureur co on co.id_coureur=ct.id_coureur
    left join penalite on penalite.id_equipe=co.id_equipe and ct.id_etape=penalite.id_etape
    group by ct.id_etape, ct.id_coureur, co.genre , co.nom
)
select c.id_etape, c.id_coureur, c.nom, c.genre, c.chrono, c.penalite, c.temps_final,
    c.rang, coalesce(points, 0) as points
from c
left join rang_points_etape rp on c.rang=rp.rang
order by c.id_etape, c.rang;




-- classement general par equipe pour tout categorie
create or replace view  v_classement_equipe as(
    WITH c as (
        select c.id_coureur, id_equipe, sum(points) as points, sum(duree) as duree
        from v_classement_etape c
        join coureur co on co.id_coureur=c.id_coureur
        group by c.id_coureur, id_equipe
        order by id_equipe
    )
    select c.id_equipe, e.nom, sum(points) as points, sum(duree) as duree, dense_rank() OVER (ORDER BY sum(points) desc) AS rang
    from c
    join equipe e on e.id_equipe=c.id_equipe
    group by c.id_equipe, e.nom
);



create or replace view v_coureur_etape_equipe as(
    SELECT
        ce.id_coureur,
        c.nom,
        c.id_equipe,
        eq.nom AS equipe_nom,
        ce.id_etape,
        e.nom AS etape_nom,
        ct.duree
    FROM
        coureur c
    LEFT JOIN
        coureur_etape ce ON ce.id_coureur = c.id_coureur
    LEFT JOIN
        coureur_temps ct ON ct.id_coureur = c.id_coureur AND ct.id_etape = ce.id_etape
    LEFT JOIN
        etape e ON e.id_etape = ce.id_etape
    LEFT JOIN
        equipe eq ON eq.id_equipe = c.id_equipe
    -- WHERE
    --     c.id_equipe = 1
    --     AND ce.id_etape = 1
    GROUP BY
        ce.id_coureur,
        c.nom,
        c.id_equipe,
        eq.nom,
        ce.id_etape,
        e.nom,
        ct.duree
    ORDER BY
        ce.id_etape
);

create or replace view v_coureur as(
    SELECT
        id_coureur,
        nom,
        numero_dossard,
        genre,
        date_naissance,
        id_equipe,
        EXTRACT(YEAR FROM AGE(date_naissance)) AS age
    FROM
        coureur
);

create or replace view v_categorie_coureur as(
    select
        cc.id_categorie,
        cc.id_coureur,
        c.nom as nom_coureur,
        c.genre,
        c.id_equipe,
        ct.nom as nom_categorie
    from categorie_coureur cc join coureur c on c.id_coureur = cc.id_coureur join
    categorie ct on ct.id_categorie=cc.id_categorie
);

-- classement toute categorie de manao where id_categorie rehefa hijery ny categorie samihafa
-- create or replace view v_classement_categorie as (
--     WITH v AS (
--         select cat.nom, cat.id_categorie, id_etape, c.id_coureur, cc.id_equipe, sum(duree) as duree, dense_rank() OVER (PARTITION BY id_etape ORDER BY sum(duree) ASC) AS rang
--         from coureur_temps c
--         join categorie_coureur co on co.id_coureur=c.id_coureur
--         join coureur cc on cc.id_coureur=c.id_coureur
--         join categorie cat on cat.id_categorie=co.id_categorie
--         -- where cat.nom='F'
--         -- where cat.id_categorie=1
--         group by id_etape, c.id_coureur, cc.id_equipe, cat.nom, cat.id_categorie
--         order by id_etape, rang
--     ), d AS (
--         select nom, id_categorie, id_etape, id_coureur, id_equipe, duree, v.rang, coalesce(points, 0) as points
--         from v
--         left join rang_points_etape rp on v.rang=rp.rang
--         order by id_etape, v.rang
--     )
--     select d.id_equipe, d.nom as categorie, d.id_categorie, e.nom, sum(d.points) as points, sum(d.duree) as duree, dense_rank() OVER (ORDER BY sum(d.points) desc) AS rang
--     from d
--     join equipe e on e.id_equipe=d.id_equipe
--     group by d.id_equipe, e.nom,d.nom , d.id_categorie
--     order by rang, e.nom
-- );

-- Catégorie Homme
create or replace view v_classement_equipe_homme as(
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
    )
    select d.id_equipe, e.nom, sum(points) as points, sum(duree) as duree, dense_rank() OVER (ORDER BY sum(points) desc) AS rang
    from d
    join equipe e on e.id_equipe=d.id_equipe
    group by d.id_equipe, e.nom
    order by rang, e.nom
);

-- Catégorie Femme
create or replace view v_classement_equipe_femme as (
    WITH v AS (
        select c.id_etape, c.id_coureur, cc.id_equipe, sum(duree) + ( coalesce(sum(heure_penalite), INTERVAL '0 hours') || ' hours')::INTERVAL as duree,
            dense_rank() OVER (PARTITION BY c.id_etape ORDER BY sum(duree) + ( coalesce(sum(heure_penalite), INTERVAL '0 hours') || ' hours')::INTERVAL ASC) AS rang
        from coureur_temps c
        join categorie_coureur co on co.id_coureur=c.id_coureur
        join coureur cc on cc.id_coureur=c.id_coureur
        join categorie cat on cat.id_categorie=co.id_categorie
            left join penalite on penalite.id_equipe=cc.id_equipe and c.id_etape=penalite.id_etape
        where cat.id_categorie=1
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
);

-- Catégorie Junior
create or replace view v_classement_equipe_junior as (
    WITH v AS (
        select c.id_etape, c.id_coureur, cc.id_equipe, sum(duree) + ( coalesce(sum(heure_penalite), INTERVAL '0 hours') || ' hours')::INTERVAL as duree,
            dense_rank() OVER (PARTITION BY c.id_etape ORDER BY sum(duree) + ( coalesce(sum(heure_penalite), INTERVAL '0 hours') || ' hours')::INTERVAL ASC) AS rang
        from coureur_temps c
        join categorie_coureur co on co.id_coureur=c.id_coureur
        join coureur cc on cc.id_coureur=c.id_coureur
        join categorie cat on cat.id_categorie=co.id_categorie
            left join penalite on penalite.id_equipe=cc.id_equipe and c.id_etape=penalite.id_etape
        where cat.nom='Junior'
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
);



-- create or replace view v_details_points_par_categorie as
-- with v as(
-- select
--     c.id_etape,
--     equipe.nom as equipe ,
--     cc.nom  ,
--     c.id_coureur,
--     cc.id_equipe,
--     cat.nom as categorie,
--     cat.id_categorie,
--     duree + ( coalesce(sum(heure_penalite), INTERVAL '0 hours') || ' hours')::INTERVAL as duree,
--     dense_rank() OVER (PARTITION BY c.id_etape ORDER BY sum(duree) + ( coalesce(sum(heure_penalite), INTERVAL '0 hours') || ' hours')::INTERVAL ASC) AS rang
--     from coureur_temps c
--     join categorie_coureur co on co.id_coureur=c.id_coureur
--     join coureur cc on cc.id_coureur=c.id_coureur
--     join equipe on equipe.id_equipe = cc.id_equipe
--     join categorie cat on cat.id_categorie=co.id_categorie
--     left join penalite on penalite.id_equipe=cc.id_equipe and c.id_etape=penalite.id_etape
--     -- where cat.id_categorie =2
--     group by c.id_etape, c.id_coureur, cc.id_equipe ,equipe.nom ,cc.nom, cat.nom, duree,
--     cat.id_categorie
--     order by c.id_etape, rang
-- ), d AS (
--         select id_categorie, id_etape, id_coureur, nom, id_equipe, duree, v.rang, coalesce(points, 0) as points
--         from v
--         left join rang_points_etape rp on v.rang=rp.rang
--         order by id_etape, v.rang)
-- select
--     d.id_categorie,
--     d.id_etape,
--     d.id_coureur,
--     d.nom,
--     d.points,
--     d.rang,
--     d.id_equipe,
--     e.nom AS nom_equipe
-- from d
-- join equipe e on e.id_equipe=d.id_equipe
-- order by rang, e.nom;

-- details point par categorie de le requete ao iany no apesaina
create or replace view v_details_points_par_categorie as(
    WITH v AS (
    select c.id_etape, e.nom as equipe, cat.id_categorie ,cat.nom as categorie, cc.nom  ,  c.id_coureur, cc.id_equipe, sum(duree) + ( coalesce(sum(heure_penalite), INTERVAL '0 hours') || ' hours')::INTERVAL as duree,
                dense_rank() OVER (PARTITION BY c.id_etape ORDER BY sum(duree) + ( coalesce(sum(heure_penalite), INTERVAL '0 hours') || ' hours')::INTERVAL ASC) AS rang
            from coureur_temps c
            join categorie_coureur co on co.id_coureur=c.id_coureur
            join coureur cc on cc.id_coureur=c.id_coureur
            join equipe e on e.id_equipe = cc.id_equipe
            join categorie cat on cat.id_categorie=co.id_categorie
                left join penalite on penalite.id_equipe=cc.id_equipe and c.id_etape=penalite.id_etape
            -- where cat.id_categorie = 2
            -- and e.id_equipe = 1
            group by c.id_etape,cat.id_categorie ,cat.nom , c.id_coureur, cc.id_equipe ,e.nom ,cc.nom
            order by c.id_etape, rang
    ), d AS (
            select id_etape , equipe , id_categorie , categorie , nom , id_coureur, id_equipe, duree, v.rang, coalesce(points, 0) as points
            from v
            left join rang_points_etape rp on v.rang=rp.rang
            order by id_etape, v.rang
        )
        select d.id_etape, d.id_equipe, d.equipe, d.id_categorie , d.categorie, d.nom
        ,sum(points) as points, sum(duree) as duree, dense_rank() OVER (ORDER BY sum(points) desc) AS rang
        from d
        --join equipe e on e.id_equipe=d.id_equipe
        -- where id_equipe = 1
        group by d.id_etape ,d.id_equipe, d.equipe , d.equipe, d.id_categorie , d.categorie, d.nom
        order by rang,
        d.equipe
);




-- view teo aloha mety ilaina iany fa tsy fafana
/*create or replace view v_classement_etape as
    WITH classement_coureur AS (
        SELECT
            ct.id_coureur,
            c.nom,
            ct.id_etape,
            ct.heure_depart,
            ct.heure_arrivee,
            SUM(duree) AS duree_coureur,
            dense_rank() OVER (PARTITION BY id_etape ORDER BY SUM(duree) ASC) AS rang
        FROM coureur_temps ct
        JOIN coureur c on c.id_coureur = ct.id_coureur
        GROUP BY ct.id_etape, ct.id_coureur, c.nom,ct.heure_depart,
            ct.heure_arrivee
    )
    SELECT Distinct
        c.id_coureur,
        c.duree_coureur,
        c.rang,
        c.id_etape,
        c.nom,
        c.heure_depart,
        c.heure_arrivee,
        r.points
    FROM classement_coureur c
    JOIN rang_points_etape r on  c.rang = r.rang
    ORDER BY r.points DESC;

create or replace view  v_classement_equipe as
    WITH classement_equipe AS (
        SELECT
            c.id_equipe,
            equipe.nom,
            SUM(ct.points) AS points_equipe,
            dense_rank() OVER (ORDER BY SUM(ct.points) DESC) AS rang_global -- Ajusté pour un rang global
        FROM v_classement_etape ct
        JOIN coureur c ON ct.id_coureur = c.id_coureur
        JOIN  equipe on equipe.id_equipe = c.id_equipe
        GROUP BY c.id_equipe ,equipe.nom
    ),
    distinct_classement AS (
        SELECT DISTINCT
            ce.id_equipe,
            ce.nom,
            ce.points_equipe,
            ce.rang_global
        FROM classement_equipe ce
    )
    SELECT
        dc.nom,
        dc.id_equipe,
        dc.points_equipe,
        dc.rang_global
    FROM distinct_classement dc
    JOIN rang_points_etape rp ON dc.rang_global = rp.rang; */







/**********************************************************************************************************************************/
CREATE OR REPLACE VIEW classement_coureur_point AS
    WITH classement_coureur AS (
        SELECT
            ce.id_coureur,
            c.nom,
            ce.id_etape,
            e.nom AS etape,
            SUM(ct.duree) AS duree_coureur,
            DENSE_RANK() OVER (PARTITION BY ce.id_etape ORDER BY SUM(ct.duree) ASC) AS rang
        FROM coureur_etape ce
        JOIN coureur_temps ct ON ce.id_coureur = ct.id_coureur AND ce.id_etape = ct.id_etape
        JOIN coureur c ON ce.id_coureur = c.id_coureur
        JOIN etape e ON ce.id_etape = e.id_etape
        GROUP BY ce.id_etape, ce.id_coureur, c.nom, e.nom
    )
    SELECT
        cc.id_coureur,
        cc.nom,
        cc.duree_coureur,
        cc.rang,
        cc.id_etape,
        cc.etape,
        r.points
    FROM classement_coureur cc
    JOIN rang_points_etape r ON cc.rang = r.rang;

create or replace view  classement_equipe as

WITH classement_equipe AS (
        SELECT
            c.id_equipe,
            equipe.nom,
            SUM(ct.points) AS points_equipe,
            dense_rank() OVER (ORDER BY SUM(ct.points) DESC) AS rang_global -- Ajusté pour un rang global
        FROM v_classement_etape ct
        JOIN coureur c ON ct.id_coureur = c.id_coureur
        JOIN  equipe on equipe.id_equipe = c.id_equipe
        GROUP BY c.id_equipe ,equipe.nom
    ),
    distinct_classement AS (
        SELECT DISTINCT
            ce.id_equipe,
            ce.nom,
            ce.points_equipe,
            ce.rang_global
        FROM classement_equipe ce
    )
    SELECT
        dc.nom,
        dc.id_equipe,
        dc.points_equipe,
        dc.rang_global
    FROM distinct_classement dc
    JOIN rang_points_etape rp ON dc.rang_global = rp.rang;

-- test kely dense_renk
WITH classement_coureur AS (
    SELECT
        id_coureur,
        id_etape,
        SUM(duree) AS duree_coureur,
        DENSE_RANK() OVER (PARTITION BY id_etape ORDER BY SUM(duree) ASC) AS rang
    FROM coureur_temps
    GROUP BY id_etape, id_coureur
)
SELECT Distinct
    c.id_coureur,
    c.duree_coureur,
    c.rang,
    c.id_etape,
    r.points
FROM classement_coureur c
JOIN rang_points_etape r on  c.rang = r.rang;

-- manao anle rang anle coureur
SELECT id_etape, id_coureur, SUM(duree) AS duree_coureur
FROM coureur_temps
GROUP BY id_etape, id_coureur
ORDER BY SUM(duree) ASC;

WITH classement_coureur AS (
    SELECT
        id_etape,
        id_coureur,
        SUM(duree) AS duree_coureur,
        ROW_NUMBER() OVER (PARTITION BY id_etape ORDER BY SUM(duree) ASC) AS rang
    FROM coureur_temps
    GROUP BY id_etape, id_coureur
)
SELECT
    c.id_etape,
    c.id_coureur,
    c.duree_coureur,
    c.rang,
    r.points
FROM classement_coureur c
JOIN rang_points_etape r ON c.id_etape = r.id_etape AND c.rang = r.rang;

WITH classement_coureur AS (
    SELECT
        id_etape,
        id_coureur,
        heure_depart,
        heure_arrivee,
        duree,
        RANK() OVER (ORDER BY duree ASC) AS rang
    FROM coureur_temps
    GROUP BY id_etape, id_coureur, heure_depart, heure_arrivee, duree
)
SELECT
    c.id_coureur,
    id_etape,
    c.heure_depart,
    c.heure_arrivee,
    c.duree,
    r.points
FROM classement_coureur c
JOIN rang_points_etape r ON c.rang = r.rang;


