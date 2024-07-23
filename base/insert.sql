-- Insertion des données de test pour la table Equipe
INSERT INTO equipe (nom, login, password) VALUES
('Team A', 'teamALogin', 'teamAPassword'),
('Team B', 'teamBLogin', 'teamBPassword');

-- Insertion des données de test pour la table Categorie
INSERT INTO categorie (nom) VALUES
('Junior'),
('Senior'),
('Veteran');

-- Insertion des données de test pour la table Coureur
INSERT INTO coureur (nom, numero_dossard, genre, date_naissance, id_equipe) VALUES
('John Doe', 101, 'Homme', '1990-01-01', 1),
('Jane Smith', 102, 'Femme', '1985-05-12', 1),
('Michael Johnson', 103, 'Homme', '1992-03-23', 2),
('Emily Davis', 104, 'Femme', '1993-07-17', 2);

-- Insertion des données de test pour la table categorie_coureur
INSERT INTO categorie_coureur (id_categorie, id_coureur) VALUES
(2, 1), -- John Doe in Senior
(2, 2), -- Jane Smith in Senior
(2, 3), -- Michael Johnson in Senior
(2, 4); -- Emily Davis in Senior

-- Insertion des données de test pour la table Etape
INSERT INTO etape (nom, longueur_km, nb_coureur, rang_etape, heure_depart) VALUES
('Stage 1', 120.5, 4, 1, '2024-06-01 08:00:00'),
('Stage 2', 150.0, 4, 2, '2024-06-02 09:00:00');

-- Insertion des données de test pour la table Rang_Points_Etape
INSERT INTO rang_points_etape (rang, points) VALUES
(1, 10), -- 1st place in Stage 1
(2, 8), -- 2nd place in Stage 1
(3, 6), -- 3rd place in Stage 1
(4, 4), -- 4th place in Stage 1
(5, 2),
(6, 1);

-- INSERT INTO rang_points_etape (id_etape, rang, points) VALUES
-- (1, 1, 10), -- 1st place in Stage 1
-- (1, 2, 6), -- 2nd place in Stage 1
-- (1, 3, 4), -- 3rd place in Stage 1
-- (1, 4, 2), -- 4th place in Stage 1
-- (1, 5, 1),
-- (2, 1, 10), -- 1st place in Stage 2
-- (2, 2, 6), -- 2nd place in Stage 2
-- (2, 3, 4), -- 3rd place in Stage 2
-- (2, 4, 2); -- 4th place in Stage 2

-- Insertion des données de test pour la table Coureur_Etape
INSERT INTO coureur_etape (id_etape, id_coureur) VALUES
(1, 1), -- John Doe in Stage 1
(1, 2), -- Jane Smith in Stage 1
(1, 3), -- Michael Johnson in Stage 1
(1, 4), -- Emily Davis in Stage 1
(2, 1), -- John Doe in Stage 2
(2, 2), -- Jane Smith in Stage 2
(2, 3), -- Michael Johnson in Stage 2
(2, 4); -- Emily Davis in Stage 2

-- Insertion des données de test pour la table Coureur_Temps
-- INSERT INTO coureur_temps (id_etape, id_coureur, heure_depart, heure_arrivee, duree) VALUES
-- (1, 1, '2024-06-01 08:00:00', '2024-06-01 11:30:00', '03:30:00'), -- John Doe in Stage 1
-- (1, 2, '2024-06-01 08:00:00', '2024-06-01 11:35:00', '03:35:00'), -- Jane Smith in Stage 1
-- (1, 3, '2024-06-01 08:00:00', '2024-06-01 11:40:00', '03:40:00'), -- Michael Johnson in Stage 1
-- (1, 4, '2024-06-01 08:00:00', '2024-06-01 11:45:00', '03:45:00'), -- Emily Davis in Stage 1
-- (2, 1, '', '2024-06-02 12:20:00', '03:20:00'), -- John Doe in Stage 2
-- (2, 2, '2024-06-02 09:00:00', '2024-02024-06-02 09:00:006-02 12:25:00', '03:25:00'), -- Jane Smith in Stage 2
-- (2, 3, '2024-06-02 09:00:00', '2024-06-02 12:30:00', '03:30:00'), -- Michael Johnson in Stage 2
-- (2, 4, '2024-06-02 09:00:00', '2024-06-02 12:35:00', '03:35:00'); -- Emily Davis in Stage 2
