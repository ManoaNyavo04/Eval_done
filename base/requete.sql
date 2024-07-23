SELECT
    ce.id_etape,
    ce.id_coureur,
    c.nom,
    c.id_equipe,
    ct.duree
FROM
    coureur_etape ce
JOIN
    coureur_temps ct
    ON ct.id_coureur = ce.id_coureur
JOIN
    coureur c
    ON c.id_coureur = ce.id_coureur
where c.id_equipe=1 and ce.id_etape=1;


SELECT
    ce.id_coureur,
    c.nom,
    c.id_equipe,
    eq.nom AS equipe_nom,
    ct.id_etape,
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
    ct.id_etape,
    e.nom,
    ct.duree
ORDER BY
    ct.id_etape;



WITH classement_coureur AS (
        SELECT
            ct.id_coureur,
            c.nom_coureur,
            c.genre,
            c.nom_categorie,
            ct.id_etape,
            ct.heure_depart,
            ct.heure_arrivee,
            SUM(duree) AS duree_coureur,
            dense_rank() OVER (PARTITION BY id_etape ORDER BY SUM(duree) ASC) AS rang
        FROM coureur_temps ct
        JOIN v_categorie_coureur c on c.id_coureur = ct.id_coureur
        GROUP BY
            ct.id_coureur,
            c.nom_coureur,
            c.genre,
            c.nom_categorie,
            ct.id_etape,
            ct.heure_depart,
            ct.heure_arrivee
    )
    SELECT Distinct
        c.id_coureur,
        c.duree_coureur,
        c.rang,
        c.id_etape,
        c.nom_coureur,
        c.genre,
        c.nom_categorie,
        c.heure_depart,
        c.heure_arrivee,
        r.points
    FROM classement_coureur c
    JOIN rang_points_etape r on  c.rang = r.rang
    ORDER BY r.points DESC;

-- globale
WITH points_coureur AS (
    SELECT
        vc.id_coureur,
        SUM(rp.points) AS total_points
    FROM
        v_categorie_coureur vc
    JOIN
        rang_points_etape rp ON vc.id_categorie = rp.id_rang
    GROUP BY
        vc.id_coureur
),
classement_general AS (
    SELECT
        p.id_coureur,
        p.total_points,
        dense_rank() OVER (ORDER BY p.total_points DESC) AS rang_general
    FROM
        points_coureur p
)
SELECT
    cg.id_coureur,
    cg.total_points,
    c.nom_coureur,
    c.genre,
    cg.rang_general
FROM
    classement_general cg
JOIN
    v_categorie_coureur c ON cg.id_coureur = c.id_coureur
ORDER BY
    cg.rang_general;








-- par equipe ito
WITH classement_equipe AS (
    SELECT
        vc.id_equipe,
        SUM(r.points) AS total_points
    FROM
        v_categorie_coureur vc
    JOIN
        rang_points_etape r ON vc.id_categorie = r.id_rang
    GROUP BY
        vc.id_equipe
),
classement_general AS (
    SELECT
        ce.id_equipe,
        SUM(ce.total_points) AS total_general_points
    FROM
        classement_equipe ce
    GROUP BY
        ce.id_equipe
)
SELECT
    cg.id_equipe,
    cg.total_general_points,
    e.nom
FROM
    classement_general cg
JOIN
    equipe e ON cg.id_equipe = e.id_equipe
ORDER BY
    cg.total_general_points DESC;





















SELECT
    ce.id_coureur,
    c.nom,
    c.id_equipe,
    eq.nom AS equipe_nom,
    ct.id_etape,
    e.nom AS etape_nom,
    ct.duree
FROM
    coureur c
LEFT JOIN
    coureur_etape ce ON ce.id_coureur = c.id_coureur
LEFT JOIN
    coureur_temps ct ON ct.id_coureur = c.id_coureur
LEFT JOIN
    etape e ON e.id_etape = ct.id_etape
JOIN
    equipe eq ON eq.id_equipe = c.id_equipe
WHERE
    c.id_equipe = 1 and ct.id_etape=1
GROUP BY
    ce.id_coureur,
    c.nom,
    c.id_equipe,
    eq.nom,
    ct.id_etape,
    e.nom,
    ct.duree
ORDER BY
    ct.id_etape;


SELECT
    ce.id_coureur,
    c.nom,
    c.id_equipe,
    eq.nom AS equipe_nom,
    ct.id_etape,
    e.nom AS etape_nom,
    ct.duree
FROM
    coureur c
LEFT JOIN
    coureur_etape ce ON ce.id_coureur = c.id_coureur
LEFT JOIN
    coureur_temps ct ON ct.id_coureur = c.id_coureur
LEFT JOIN
    etape e ON e.id_etape = ct.id_etape
JOIN
    equipe eq ON eq.id_equipe = c.id_equipe
WHERE
    c.id_equipe = 1 and ct.id_etape=1
GROUP BY
    ce.id_coureur,
    c.nom,
    c.id_equipe,
    eq.nom,
    ct.id_etape,
    e.nom,
    ct.duree
ORDER BY
    ct.id_etape;






select
    p.id_equipe,
    ct.id_etape,
    c.nom,
    ct.duree,
    p.temps_penalite,
    (ct.duree+p.temps_penalite) as new_duree
from penalite p
join coureur c on c.id_equipe=p.id_equipe
join coureur_temps ct on ct.id_coureur=c.id_coureur
where ct.id_etape=1;



