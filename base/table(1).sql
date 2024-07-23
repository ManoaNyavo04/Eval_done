DROP DATABASE course;

CREATE DATABASE course;
\c course;
-- Création de la table Admin
CREATE TABLE admin (
    id_admin SERIAL PRIMARY KEY,
    login VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

-- Insertion d'un administrateur exemple
INSERT INTO admin (login, password) VALUES ('admin', 'admin');

-- Création de la table Equipe
CREATE TABLE equipe (
    id_equipe SERIAL PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    login VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

-- Création de la table Categorie
CREATE TABLE categorie (
    id_categorie SERIAL PRIMARY KEY,
    nom VARCHAR(255) NOT NULL UNIQUE
);

-- Création de la table Coureur
CREATE TABLE coureur (
    id_coureur SERIAL PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    numero_dossard INT NOT NULL UNIQUE,
    genre VARCHAR(20),
    date_naissance DATE NOT NULL,
    id_equipe INT,
    FOREIGN KEY (id_equipe) REFERENCES equipe(id_equipe)
);

CREATE TABLE categorie_coureur (
    id_categorie_coureur SERIAL PRIMARY KEY,
    id_categorie INT,
    id_coureur INT,
    FOREIGN KEY (id_categorie) REFERENCES categorie(id_categorie) ON DELETE CASCADE,
    FOREIGN KEY (id_coureur) REFERENCES coureur(id_coureur) ON DELETE CASCADE
);

-- Création de la table Etape
CREATE TABLE etape (
    id_etape SERIAL PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    longueur_km DECIMAL NOT NULL,
    nb_coureur INT NOT NULL,
    rang_etape INT NOT NULL,
    heure_depart Timestamp NOT NULL
);

-- Création de la table Rang_Points_Etape
-- CREATE TABLE rang_points_etape (
--     id_rang SERIAL PRIMARY KEY,
--     id_etape INT NOT NULL,
--     rang INT NOT NULL,
--     points DECIMAL NOT NULL,
--     FOREIGN KEY (id_etape) REFERENCES etape(id_etape) ON DELETE CASCADE
-- );

-- nasiko anty table ty
CREATE TABLE course(
    id_course SERIAL PRIMARY KEY ,
    daty date ,
    nom_course VARCHAR(100)
);

--ty mety ilaina ian de nataoko teo  louh
CREATE TABLE course_etape(
    id_course_etape SERIAL PRIMARY KEY,
    id_course INT,
    id_etape INT,
     FOREIGN KEY (id_etape) REFERENCES etape(id_etape) ON DELETE CASCADE,
    FOREIGN KEY (id_course) REFERENCES course(id_course) ON DELETE CASCADE
);

--le id_etape tato ovaina id_course
    CREATE TABLE rang_points_etape (
        id_rang SERIAL PRIMARY KEY,
        id_course INT,
        rang INT NOT NULL,
        points DECIMAL NOT NULL,
     FOREIGN KEY (id_course) REFERENCES course(id_course) ON DELETE CASCADE
    );


-- Création de la table Coureur_Etape
CREATE TABLE coureur_etape (
    id SERIAL PRIMARY KEY,
    id_etape INT NOT NULL,
    id_coureur INT NOT NULL,
    FOREIGN KEY (id_etape) REFERENCES etape(id_etape) ON DELETE CASCADE,
    FOREIGN KEY (id_coureur) REFERENCES coureur(id_coureur) ON DELETE CASCADE
);

-- Création de la table Coureur_Temps
CREATE TABLE coureur_temps (
    id SERIAL PRIMARY KEY,
    id_etape INT NOT NULL,
    id_coureur INT NOT NULL,
    heure_depart Timestamp,
    heure_arrivee Timestamp,
    duree INTERVAL NOT NULL,
    FOREIGN KEY (id_etape) REFERENCES etape(id_etape) ON DELETE CASCADE,
    FOREIGN KEY (id_coureur) REFERENCES coureur(id_coureur) ON DELETE CASCADE
);

--ajout

-- CREATE TABLE classment (
--     id SERIAL PRIMARY KEY,
--     id_etape INT NOT NULL,
--     id_coureur INT NOT NULL,
--     heure_arrivee TIME NOT NULL,
--     heure_depart TIME NOT NULL,
--     longueur DECIMAL NOT NULL,
--     duree INTERVAL NOT NULL,
--     id_equipe INT,
--     points DECIMAL ,
--     FOREIGN KEY (id_etape) REFERENCES etape(id_etape) ON DELETE CASCADE,
--     FOREIGN KEY (id_coureur) REFERENCES coureur(id_coureur) ON DELETE CASCADE
-- );
