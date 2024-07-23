CREATE OR REPLACE FUNCTION get_interval_between(
    timestamp1 TIMESTAMP,
    timestamp2 TIMESTAMP
)
RETURNS INTERVAL
AS $$
DECLARE
    result_interval INTERVAL;
BEGIN
    result_interval := timestamp2 - timestamp1;
    RETURN result_interval;
END;
$$ LANGUAGE plpgsql;


CREATE OR REPLACE FUNCTION cast_valid_date(date_text VARCHAR)
RETURNS DATE
AS $$
DECLARE
    formatted_date_text VARCHAR;
    result_date DATE;
BEGIN
    formatted_date_text := REPLACE(date_text, '/', '-');
BEGIN
    result_date := TO_DATE(formatted_date_text, 'DD-MM-YYYY');
    EXCEPTION
        WHEN others THEN
            RETURN NULL;
        END;
    RETURN result_date;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION cast_valid_time(time_text VARCHAR)
RETURNS TIME
AS $$
DECLARE
    result_time TIME;
BEGIN
    BEGIN
        result_time := TO_TIMESTAMP(time_text, 'HH24:MI:SS')::TIME;
    EXCEPTION
        WHEN others THEN
            RETURN NULL;
    END;
    RETURN result_time;
END;
$$ LANGUAGE plpgsql;


CREATE OR REPLACE FUNCTION cast_valid_datetime(date_text VARCHAR)
RETURNS TIMESTAMP
AS $$
DECLARE
    result_date TIMESTAMP;
BEGIN
    BEGIN
        result_date := TO_TIMESTAMP(date_text, 'DD/MM/YYYY HH24:MI:SS');
    EXCEPTION
        WHEN others THEN
            RETURN NULL;
    END;
    RETURN result_date;
END;
$$ LANGUAGE plpgsql;


CREATE OR REPLACE FUNCTION is_numeric(num Text)
returns boolean
AS $$
BEGIN
    IF num ~ '^-?\d*\.?\d+$' THEN
        RETURN TRUE;
    ELSE
        RETURN FALSE;
    END IF;
END;
$$ language plpgsql;


CREATE OR REPLACE FUNCTION is_numeric_and_positive(num Text)
returns boolean
AS $$
BEGIN
    IF num ~ '^-?\d*\.?\d+$' THEN
        IF num::NUMERIC > 0 THEN
            RETURN TRUE;
        ELSE
            RETURN FALSE;
        END IF;
    ELSE
        RETURN FALSE;
    END IF;
END;
$$ language plpgsql;


---------------------------------------------------------------------------------------------------


create or REPLACE function verify_etape()
returns void as $$
begin
    insert into table_erreur (numligne, valeur, typeErreur)
        select ligne, longueur, 'longueur non numeric ou negatif'
        from etape_temp e1
        where (select is_numeric_and_positive(longueur) ) is FALSE
            union all
        select ligne, nb_coureur,'nb_coureur non numeric ou negatif'
        from etape_temp e2
        where (select is_numeric_and_positive(nb_coureur) ) is FALSE
            union all
        select ligne, rang,'rang non numeric ou negatif'
        from etape_temp e3
        where (select is_numeric_and_positive(rang) ) is FALSE
            union all
        select ligne, date_depart,'date_depart invalide'
        from etape_temp e4
        where (select cast_valid_date(date_depart) ) is null
            union all
        select ligne, heure_depart,'heure_depart invalide'
        from etape_temp e5
        where (select cast_valid_time(heure_depart) ) is null
            union all
        select ligne, etape,'etape null'
        from etape_temp e6
        where etape='';

END;
$$ LANGUAGE plpgsql;


create or REPLACE function insert_etape()
returns void as $$
begin

    insert into etape (nom, longueur_km, nb_coureur, rang_etape, heure_depart)
    select
        DISTINCT etape, longueur::numeric, etp.nb_coureur::numeric, rang::numeric,
            TO_TIMESTAMP((select cast_valid_date(date_depart) ) || ' ' || etp.heure_depart , 'YYYY-MM-DD HH24:MI:SS')
    from etape_temp etp
    where not exists (
        select 1 from etape e
        where   nom=etape
            and longueur_km=longueur::numeric
            and e.nb_coureur=etp.nb_coureur::numeric
            and rang_etape=rang::numeric
            and heure_depart=TO_TIMESTAMP((select cast_valid_date(date_depart) ) || ' ' || etp.heure_depart , 'YYYY-MM-DD HH24:MI:SS')
    );

END;
$$ LANGUAGE plpgsql;


create or REPLACE function verify_rang()
returns void as $$
begin
    insert into table_erreur (numligne, valeur, typeErreur)
        select ligne, classement, 'classement non numeric ou negatif'
        from point_temp p1
        where (select is_numeric_and_positive(classement) ) is FALSE
            union all
        select ligne, points,'points non numeric'
        from point_temp p2
        where (select is_numeric(points) ) is FALSE;

END;
$$ LANGUAGE plpgsql;


create or REPLACE function insert_rang()
returns void as $$
begin

    insert into rang_points_etape (rang, points)
    select
        DISTINCT classement::numeric, etp.points::numeric
    from point_temp etp
    where not exists (
        select 1 from rang_points_etape e
        where   rang=classement::numeric
            and e.points=etp.points::numeric
    );

END;
$$ LANGUAGE plpgsql;


create or REPLACE function verify_resultat()
returns void as $$
begin

    insert into table_erreur (numligne, valeur, typeErreur)
        select ligne, etape_rang, 'etape_rang non numeric ou negatif'
        from resultat_temp r1
        where (select is_numeric_and_positive(etape_rang) ) is FALSE
            union all
        select ligne, numero_dossard,'numero_dossard non numeric'
        from resultat_temp r2
        where (select is_numeric(numero_dossard) ) is FALSE
            union all
        select ligne, nom,'nom null'
        from resultat_temp r3
        where nom=''
            union all
        select ligne, genre,'genre null'
        from resultat_temp r4
        where genre=''
            union all
        select ligne, date_naissance,'date_naissance invalide'
        from resultat_temp r5
        where (select cast_valid_date(date_naissance) ) is null
            union all
        select ligne, equipe,'equipe null'
        from resultat_temp r6
        where equipe=''
            union all
        select ligne, arrivee,'arrivee invalide'
        from resultat_temp r7
        where (select cast_valid_datetime(arrivee) ) is null
            union all
        -- select ligne, etape_rang,'etape_rang n''existe pas dans etape'
        -- from resultat_temp r8
        -- where (select rang_etape from etape where r8.etape_rang::numeric=etape.rang_etape) is null
        select ligne, etape_rang,'etape_rang n''existe pas dans etape'
        from resultat_temp r8
        where not exists (select rang_etape from etape where r8.etape_rang::numeric=etape.rang_etape);

END;
$$ LANGUAGE plpgsql;


create or REPLACE function insert_groupe()
returns void as $$
begin

    insert into equipe (nom, login, password)
        select
            DISTINCT rtp.equipe, rtp.equipe, rtp.equipe
        from resultat_temp rtp
        where not exists (
            select 1 from equipe e
            where   nom=rtp.equipe
                and login=rtp.equipe
                and password=rtp.equipe
        );

    insert into coureur (nom, numero_dossard, genre, date_naissance, id_equipe)
        select
            DISTINCT rtp.nom, rtp.numero_dossard::numeric, rtp.genre, (select cast_valid_date(rtp.date_naissance)), eq.id_equipe
        from resultat_temp rtp
        JOIN equipe eq ON eq.nom = rtp.equipe
        where not exists (
            select 1 from coureur c
            where   c.nom=rtp.nom
                and c.numero_dossard=rtp.numero_dossard::numeric
                and c.genre=rtp.genre
                and c.date_naissance=(select cast_valid_date(rtp.date_naissance))
                and c.id_equipe=eq.id_equipe
        );

    insert into coureur_etape (id_etape, id_coureur)
        select
            DISTINCT et.id_etape, co.id_coureur
        from resultat_temp rtp
        join etape et on et.rang_etape=rtp.etape_rang::numeric
        join coureur co on co.numero_dossard=rtp.numero_dossard::numeric and co.nom=rtp.nom
        where not exists (
            select 1 from coureur_etape c
            where   c.id_etape=et.id_etape
                and c.id_coureur=co.id_coureur
        );

    insert into coureur_temps (id_etape, id_coureur, heure_depart, heure_arrivee, duree)
        select
            DISTINCT et.id_etape, co.id_coureur, et.heure_depart, (select cast_valid_datetime(arrivee) ),
            (select get_interval_between( et.heure_depart, (select cast_valid_datetime(arrivee)) ))
        from resultat_temp rtp
        join etape et on et.rang_etape=rtp.etape_rang::numeric
        join coureur co on co.numero_dossard=rtp.numero_dossard::numeric and co.nom=rtp.nom
        where not exists (
            select 1 from coureur_temps c
            where   c.id_etape=et.id_etape
                and c.id_coureur=co.id_coureur
                and c.heure_depart=et.heure_depart
                and c.heure_arrivee=(select cast_valid_datetime(arrivee) )
                and c.duree=(select get_interval_between( et.heure_depart, (select cast_valid_datetime(arrivee)) ))
        );

END;
$$ LANGUAGE plpgsql;

---------------------------------------------------------------------------------------------------


create or REPLACE function insert_categorie_coureur()
returns void as $$
begin

    INSERT INTO categorie (nom)
        select 'Junior'
        where not exists (select 1  from categorie where nom = 'Junior');

    insert into categorie (nom)
        select DISTINCT genre from coureur co
        where not exists (select 1 from categorie c where c.nom=co.genre);

    insert into categorie_coureur (id_categorie, id_coureur)
        select DISTINCT ctg.id_categorie, co.id_coureur
        from coureur co
        join categorie ctg on ctg.nom=co.genre
        where not exists (
            select 1 from categorie_coureur cc where cc.id_categorie=ctg.id_categorie and cc.id_coureur=co.id_coureur
        );

    insert into categorie_coureur (id_categorie, id_coureur)
        select DISTINCT ctg.id_categorie, co.id_coureur
        from coureur co
        join categorie ctg on ctg.nom='Junior'
        where extract(year from now())-extract(year from date_naissance)<18
        and not exists (
            select 1 from categorie_coureur cc where cc.id_categorie=ctg.id_categorie and cc.id_coureur=co.id_coureur
        );

END;
$$ LANGUAGE plpgsql;


-- INSERT INTO categorie (nom)
--         select 'Major'
--         where not exists (select 1  from categorie where nom = 'Major');

--     insert into categorie_coureur (id_categorie, id_coureur)
--         select DISTINCT ctg.id_categorie, co.id_coureur
--         from coureur co
--         join categorie ctg on ctg.nom='Major'
--         where extract(year from now())-extract(year from date_naissance)>=18 and extract(year from now())-extract(year from date_naissance)<45
--         and not exists (
--             select 1 from categorie_coureur cc where cc.id_categorie=ctg.id_categorie and cc.id_coureur=co.id_coureur
--         );
