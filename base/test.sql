create database lokorace_test1;
\c lokorace_test1

INSERT INTO categorie (nom) VALUES
('Junior'),
('Senior'),
('Veteran');
INSERT INTO categorie (nom) VALUES
    ('Homme'),('Femme');

-- INSERT INTO course (daty, nom_course) VALUES
-- ('2024-06-01', 'Tour de Test 2024'),
-- ('2024-07-01', 'Course des Champs 2024');


INSERT INTO equipe (nom, login, password) VALUES
('Cycling Pro Team', 'proteam@gmail.com', 'securepassword1'),
('Mountain Riders', 'mountainriders@gmail.com', 'securepassword2'),
('Speedster Squad', 'speedstersquad@gmail.com', 'securepassword3');

INSERT INTO etape (nom, longueur_km, nb_coureur, rang_etape, heure_depart) VALUES
('Stage 1: Mountain Ascent', 120.50, 5, 1, '2024-06-01 08:00:00'),
('Stage 2: Coastal Ride', 150.00, 4, 2, '2024-06-02 09:00:00'),
('Stage 3: Urban Sprint', 90.75, 3, 3, '2024-06-03 10:00:00');

-- INSERT INTO course_etape (id_course, id_etape) VALUES
-- -- Associating all stages with the first course
-- (1, 1), -- Stage 1: Mountain Ascent with Tour de France
-- (1, 2), -- Stage 2: Coastal Ride with Tour de France
-- (1, 3), -- Stage 3: Urban Sprint with Tour de France

-- -- Associating different stages with the second course
-- (2, 1), -- Stage 1: Mountain Ascent with Giro d'Italia
-- (2, 3); -- Stage 3: Urban Sprint with Giro d'Italia


-- Insertion des coureurs pour l'équipe 1
INSERT INTO coureur (nom, numero_dossard, genre, date_naissance, id_equipe) VALUES
('Thomas Dumoulin', 101, 'Homme', '1990-11-11', 1),
('Julian Alaphilippe', 102, 'Homme', '1992-06-11', 1),
('Egan Bernal', 103, 'Homme', '1997-01-13', 1),
('Marianne Vos', 104, 'Femme', '1987-05-13', 1),
('Anna van der Breggen', 105, 'Femme', '1990-04-18', 1);

INSERT INTO coureur (nom, numero_dossard, genre, date_naissance, id_equipe) VALUES
    ('Manoa', 2041, 'Femme', '2004-01-02', 1);

-- Insertion des coureurs pour l'équipe 2
INSERT INTO coureur (nom, numero_dossard, genre, date_naissance, id_equipe) VALUES
('Chris Froome', 201, 'Homme', '1985-05-20', 2),
('Geraint Thomas', 202, 'Homme', '1986-05-25', 2),
('Primož Roglič', 203, 'Homme', '1989-10-29', 2),
('Elisa Longo Borghini', 204, 'Femme', '1991-12-10', 2),
('Kasia Niewiadoma', 205, 'Femme', '1994-09-29', 2);

INSERT INTO coureur (nom, numero_dossard, genre, date_naissance, id_equipe) VALUES
    ('Mirindra', 306, 'Femme', '2003-06-04', 2);

-- Insertion des coureurs pour l'équipe 3
INSERT INTO coureur (nom, numero_dossard, genre, date_naissance, id_equipe) VALUES
('Peter Sagan', 301, 'Homme', '1990-01-26', 3),
('Nairo Quintana', 302, 'Homme', '1990-02-04', 3),
('Alejandro Valverde', 303, 'Homme', '1980-04-25', 3),
('Lizzie Deignan', 304, 'Femme', '1988-12-18', 3),
('Chantal Blaak', 305, 'Femme', '1989-10-22', 3);



-- Insertion des coureurs dans les catégories

-- Catégorie 1
INSERT INTO categorie_coureur (id_categorie, id_coureur) VALUES
(1, 1), -- Thomas Dumoulin
(1, 6), -- Chris Froome
(1, 11), -- Peter Sagan
(1, 2), -- Julian Alaphilippe
(1, 7); -- Geraint Thomas

-- Catégorie 2
INSERT INTO categorie_coureur (id_categorie, id_coureur) VALUES
(2, 3), -- Egan Bernal
(2, 8), -- Primož Roglič
(2, 12), -- Nairo Quintana
(2, 4), -- Marianne Vos
(2, 9); -- Elisa Longo Borghini

-- Catégorie 3
INSERT INTO categorie_coureur (id_categorie, id_coureur) VALUES
(3, 5), -- Anna van der Breggen
(3, 10), -- Kasia Niewiadoma
(3, 13), -- Alejandro Valverde
(3, 14), -- Lizzie Deignan
(3, 15); -- Chantal Blaak


INSERT INTO rang_points_etape (rang, points) VALUES
(1, 10.0), -- 10 points for 1st place
(2, 8.0),  -- 8 points for 2nd place
(3, 6.0),  -- 6 points for 3rd place
(4, 4.0);  -- 4 points for 4th place


-- Étape 1
-- Équipe 1
INSERT INTO coureur_etape (id_etape, id_coureur) VALUES (1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5);

INSERT INTO coureur_etape (id_etape, id_coureur) VALUES
    (1, 16);

-- Équipe 2
INSERT INTO coureur_etape (id_etape, id_coureur) VALUES (1, 6),
(1, 7),
(1, 8),
(1, 9),
(1, 10);

INSERT INTO coureur_etape (id_etape, id_coureur) VALUES
    (1, 17);

-- Équipe 3
INSERT INTO coureur_etape (id_etape, id_coureur) VALUES (1, 11),
(1, 12),
(1, 13),
(1, 14),
(1, 15);


-- Étape 2
-- Équipe 1
INSERT INTO coureur_etape (id_etape, id_coureur) VALUES (2, 1),
(2, 2),
(2, 3),
(2, 4);

-- Équipe 2
INSERT INTO coureur_etape (id_etape, id_coureur) VALUES (2, 6),
(2, 7),
(2, 8),
(2, 9);

-- Équipe 3
INSERT INTO coureur_etape (id_etape, id_coureur) VALUES (2, 11),
(2, 12),
(2, 13),
(2, 14);


-- Étape 3
-- Équipe 1
INSERT INTO coureur_etape (id_etape, id_coureur) VALUES (3, 1),
(3, 2),
(3, 3);

-- Équipe 2
INSERT INTO coureur_etape (id_etape, id_coureur) VALUES (3, 6),
(3, 7),
(3, 8);

-- Équipe 3
INSERT INTO coureur_etape (id_etape, id_coureur) VALUES (3, 11),
(3, 12),
(3, 13);




-- Étape 1
-- Équipe 1
INSERT INTO coureur_temps (id_etape, id_coureur, heure_depart, heure_arrivee, duree)
VALUES
(1, 1, '2024-06-01 08:00:00', '2024-06-01 10:30:00', '02:30:00'),
(1, 2, '2024-06-01 08:05:00', '2024-06-01 10:28:00', '02:23:00'),
(1, 3, '2024-06-01 08:10:00', '2024-06-01 10:32:00', '02:22:00'),
(1, 4, '2024-06-01 08:15:00', '2024-06-01 10:35:00', '02:20:00'),
(1, 5, '2024-06-01 08:20:00', '2024-06-01 10:31:00', '02:11:00');

INSERT INTO coureur_temps (id_etape, id_coureur, heure_depart, heure_arrivee, duree)
VALUES
    (1, 16, '2024-06-01 09:20:00', '2024-06-01 10:31:00', '01:11:00');

-- Équipe 2
INSERT INTO coureur_temps (id_etape, id_coureur, heure_depart, heure_arrivee, duree)
VALUES
(1, 6, '2024-06-01 08:30:00', '2024-06-01 11:00:00', '02:30:00'),
(1, 7, '2024-06-01 08:35:00', '2024-06-01 11:02:00', '02:27:00'),
(1, 8, '2024-06-01 08:40:00', '2024-06-01 11:05:00', '02:25:00'),
(1, 9, '2024-06-01 08:45:00', '2024-06-01 11:07:00', '02:22:00'),
(1, 10, '2024-06-01 08:50:00', '2024-06-01 11:10:00', '02:20:00');

-- Équipe 3
INSERT INTO coureur_temps (id_etape, id_coureur, heure_depart, heure_arrivee, duree)
VALUES
(1, 11, '2024-06-01 09:00:00', '2024-06-01 11:15:00', '02:15:00'),
(1, 12, '2024-06-01 09:05:00', '2024-06-01 11:20:00', '02:15:00'),
(1, 13, '2024-06-01 09:10:00', '2024-06-01 11:25:00', '02:15:00'),
(1, 14, '2024-06-01 09:15:00', '2024-06-01 11:30:00', '02:15:00'),
(1, 15, '2024-06-01 09:20:00', '2024-06-01 11:35:00', '02:15:00');

-- Étape 2
-- Équipe 1
INSERT INTO coureur_temps (id_etape, id_coureur, heure_depart, heure_arrivee, duree)
VALUES
(2, 1, '2024-06-02 09:00:00', '2024-06-02 11:45:00', '02:45:00'),
(2, 2, '2024-06-02 09:05:00', '2024-06-02 11:50:00', '02:45:00'),
(2, 3, '2024-06-02 09:10:00', '2024-06-02 11:55:00', '02:45:00'),
(2, 4, '2024-06-02 09:15:00', '2024-06-02 12:00:00', '02:45:00');

-- Équipe 2
INSERT INTO coureur_temps (id_etape, id_coureur, heure_depart, heure_arrivee, duree)
VALUES
(2, 6, '2024-06-02 09:30:00', '2024-06-02 12:15:00', '02:45:00'),
(2, 7, '2024-06-02 09:35:00', '2024-06-02 12:20:00', '02:45:00'),
(2, 8, '2024-06-02 09:40:00', '2024-06-02 12:25:00', '02:45:00'),
(2, 9, '2024-06-02 09:45:00', '2024-06-02 12:30:00', '02:45:00');

-- Équipe 3
INSERT INTO coureur_temps (id_etape, id_coureur, heure_depart, heure_arrivee, duree)
VALUES
(2, 11, '2024-06-02 09:50:00', '2024-06-02 12:35:00', '02:45:00'),
(2, 12, '2024-06-02 09:55:00', '2024-06-02 12:40:00', '02:45:00'),
(2, 13, '2024-06-02 10:00:00', '2024-06-02 12:45:00', '02:45:00'),
(2, 14, '2024-06-02 10:05:00', '2024-06-02 12:50:00', '02:45:00');

-- Étape 3
-- Équipe 1
INSERT INTO coureur_temps (id_etape, id_coureur, heure_depart, heure_arrivee, duree)
VALUES
(3, 1, '2024-06-03 10:00:00', '2024-06-03 12:20:00', '02:20:00'),
(3, 2, '2024-06-03 10:05:00', '2024-06-03 12:22:00', '02:17:00'),
(3, 3, '2024-06-03 10:10:00', '2024-06-03 12:25:00', '02:15:00');

-- Équipe 2
INSERT INTO coureur_temps (id_etape, id_coureur, heure_depart, heure_arrivee, duree)
VALUES
(3, 6, '2024-06-03 10:00:00', '2024-06-03 12:18:00', '02:18:00'),
(3, 7, '2024-06-03 10:05:00', '2024-06-03 12:23:00', '02:18:00'),
(3, 8, '2024-06-03 10:10:00', '2024-06-03 12:25:00', '02:15:00');

-- Équipe 3
INSERT INTO coureur_temps (id_etape, id_coureur, heure_depart, heure_arrivee, duree)
VALUES
(3, 11, '2024-06-03 10:00:00', '2024-06-03 12:15:00', '02:15:00'),
(3, 12, '2024-06-03 10:05:00', '2024-06-03 12:20:00', '02:15:00'),
(3, 13, '2024-06-03 10:10:00', '2024-06-03 12:25:00', '02:15:00');
