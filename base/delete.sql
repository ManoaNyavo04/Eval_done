CREATE OR REPLACE FUNCTION reset_tables()
RETURNS void AS $$
BEGIN
    -- Désactiver tous les déclencheurs sur la table
    ALTER TABLE equipe DISABLE TRIGGER ALL;
    ALTER TABLE categorie DISABLE TRIGGER ALL;
    ALTER TABLE coureur DISABLE TRIGGER ALL;
    ALTER TABLE etape DISABLE TRIGGER ALL;
    ALTER TABLE categorie_coureur DISABLE TRIGGER ALL;
    ALTER TABLE rang_points_etape DISABLE TRIGGER ALL;
    ALTER TABLE coureur_etape DISABLE TRIGGER ALL;
    ALTER TABLE coureur_temps DISABLE TRIGGER ALL;
    ALTER TABLE penalite DISABLE TRIGGER ALL;

    -- Supprimer toutes les lignes de la table
    DELETE FROM equipe;
    DELETE FROM categorie;
    DELETE FROM coureur;
    DELETE FROM etape;
    DELETE FROM categorie_coureur;
    DELETE FROM rang_points_etape;
    DELETE FROM coureur_etape;
    DELETE FROM coureur_temps;
    DELETE FROM penalite;

    -- Réinitialiser la séquence à 1
    ALTER SEQUENCE equipe_id_equipe_seq RESTART WITH 1;
    ALTER SEQUENCE categorie_id_categorie_seq RESTART WITH 1;
    ALTER SEQUENCE coureur_id_coureur_seq RESTART WITH 1;
    ALTER SEQUENCE etape_id_etape_seq RESTART WITH 1;
    ALTER SEQUENCE categorie_coureur_id_categorie_coureur_seq RESTART WITH 1;
    ALTER SEQUENCE rang_points_etape_id_rang_seq RESTART WITH 1;
    ALTER SEQUENCE coureur_etape_id_seq RESTART WITH 1;
    ALTER SEQUENCE coureur_temps_id_seq RESTART WITH 1;
    ALTER SEQUENCE penalite_id_penalite_seq RESTART WITH 1;

    -- Réactiver les déclencheurs sur la table
    ALTER TABLE equipe ENABLE TRIGGER ALL;
    ALTER TABLE categorie ENABLE TRIGGER ALL;
    ALTER TABLE coureur ENABLE TRIGGER ALL;
    ALTER TABLE etape ENABLE TRIGGER ALL;
    ALTER TABLE categorie_coureur ENABLE TRIGGER ALL;
    ALTER TABLE rang_points_etape ENABLE TRIGGER ALL;
    ALTER TABLE coureur_etape ENABLE TRIGGER ALL;
    ALTER TABLE coureur_temps ENABLE TRIGGER ALL;
    ALTER TABLE penalite ENABLE TRIGGER ALL;
END;
$$ LANGUAGE plpgsql;


-- select reset_tables();
-- select * FROM equipe;
-- select * FROM categorie;
-- select * FROM coureur;
-- select * FROM etape;
-- select * FROM categorie_coureur;
-- select * FROM rang_points_etape;
-- select * FROM coureur_etape;
-- select * FROM coureur_temps;
-- select * FROM penalite;
-- select * FROM etape_temp;
-- select * FROM resultat_temp;
-- select * FROM point_temp;


DELETE FROM etape_temp;
DELETE FROM resultat_temp;
DELETE FROM point_temp_temp;
ALTER SEQUENCE etape_temp_ligne_seq RESTART WITH 1;
ALTER SEQUENCE resultat_temp_ligne_seq RESTART WITH 1;
ALTER SEQUENCE point_temp_ligne_seq RESTART WITH 1;


