drop database lokorace;

create database lokorace;

\c lokorace;

-- Création de la table Admin
CREATE TABLE Admin (
    id_admin SERIAL PRIMARY KEY,
    login VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

-- Insertion d'un administrateur exemple
INSERT INTO Admin (login, password) VALUES ('admin', 'admin');


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

CREATE TABLE categorie_coureur(
    id_categorie_coureur SERIAL PRIMARY KEY,
    id_categorie INT NOT NULL,
    id_coureur INT NOT NULL,
    FOREIGN KEY (id_categorie) REFERENCES categorie(id_categorie),
    FOREIGN KEY (id_coureur) REFERENCES coureur(id_coureur)
);

-- Création de la table Etape
CREATE TABLE etape (
    id_etape SERIAL PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    longueur_km DECIMAL(10,2) NOT NULL,
    nb_coureur INT NOT NULL,
    rang_etape INT NOT NULL,
    heure_depart TIMESTAMP NOT NULL
);

--ito asorina ny etape tato am rang
CREATE TABLE rang_points_etape (
    id_rang SERIAL PRIMARY KEY,
    rang INT NOT NULL,
    points DECIMAL (10,2) NOT NULL
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
    heure_depart TIMESTAMP NOT NULL,
    heure_arrivee TIMESTAMP NOT NULL,
    duree INTERVAL NOT NULL,
    FOREIGN KEY (id_etape) REFERENCES etape(id_etape) ON DELETE CASCADE,
    FOREIGN KEY (id_coureur) REFERENCES coureur(id_coureur) ON DELETE CASCADE
);

create table penalite (
    id_penalite serial PRIMARY KEY,
    id_etape INT not NULL REFERENCES etape (id_etape),
    id_equipe INT not NULL REFERENCES equipe (id_equipe),
    heure_penalite time
);

insert into penalite (id_etape, id_equipe, heure_penalite) values
    (4, 1, '00:20:00'),
    (3, 1, '03:00:00'),
    (5, 2, '03:00:00');

-- CREATE TABLE classment (
--     id INT SERIAL PRIMARY KEY,
--     id_etape INT NOT NULL,
--     id_coureur INT NOT NULL,
--     heure_arrivee TIMESTAMP NOT NULL,
--     heure_depart TIMESTAMP NOT NULL,
--     longueur DECIMAL(10,2) NOT NULL,
--     duree INTERVAL NOT NULL,
--     points DECIMAL (10,2),
--     FOREIGN KEY (id_etape) REFERENCES etape(id_etape) ON DELETE CASCADE,
--     FOREIGN KEY (id_coureur) REFERENCES coureur(id_coureur) ON DELETE CASCADE
-- );

-- table temporaire import

create table etape_temp(
    etape VARCHAR,
    longueur VARCHAR,
    nb_coureur VARCHAR,
    rang VARCHAR,
    date_depart VARCHAR,
    heure_depart VARCHAR
);

create table resultat_temp(
    etape_rang VARCHAR,
    numero_dossard VARCHAR,
    nom VARCHAR,
    genre VARCHAR,
    date_naissance VARCHAR,
    equipe VARCHAR,
    arrivee VARCHAR
);

create table point_temp(
    classement VARCHAR,
    points VARCHAR
);
alter table etape_temp add column ligne serial;
alter table resultat_temp add column ligne serial;
alter table point_temp add column ligne serial;


create table table_erreur (
    numligne varchar,
    valeur varchar,
    typeErreur varchar
);
