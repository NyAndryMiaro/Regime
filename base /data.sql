--Semestre
insert into Semestres (idSemestre, libelle) values
(1, 'S3'),
(2, 'S4');

-- Matieres S3
insert into Matieres (idMatiere, Nom, idSemestre) values
('INF201', 'Programmation orientée objet', 1),
('INF202', 'Base de données objet', 1),
('INF203', 'Programmation systeme', 1),
('INF208', 'Réseaux informatiques', 1),
('MTH201', 'Méthodes numériques', 1),
('ORG201', 'Bases de Gestion', 1);

-- Matieres S4
insert into Matieres (idMatiere, Nom, idSemestre) values
('INF204', 'Système d''information géographique', 2),
('INF205', 'Systèmes d''information', 2),
('INF206', 'Interface Homme/Machine', 2),
('INF207', 'Éléments d''algorithmique', 2),
('INF209', 'Web dynamique', 2),
('INF211', 'Mini-projet de Bases de données et réseaux', 2),
('INF212', 'Mini-projet de Web et design', 2),
('MTH202', 'Analyse de données', 2),
('MTH203', 'MAO', 2),
('MTH204', 'Géométrie', 2),
('MTH205', 'Équations différentielles', 2),
('MTH206', 'Optimisation', 2);

-- Parcours
insert into Parcours (parcours) values
('Tronc commun'),
('Développement'),
('Bases de Données et Réseaux'),
('Web et Design');

-- Associations Matieres-Parcours avec credits
-- TRONC COMMUN (idParcours = 1)
insert into MatiereParcours (idMatiere, idParcours, Credit, estObligatoire) values
('INF204', 1, 6, 3),
('INF205', 1, 6, 3),
('INF206', 1, 6, 3),
('INF209', 1, 6, 1),
('INF212', 1, 10, 1),
('MTH202', 1, 4, 3),
('MTH204', 1, 4, 3),
('MTH206', 1, 4, 3),
('MTH203', 1, 4, 1);

-- DEVELOPPEMENT (idParcours = 2)
insert into MatiereParcours (idMatiere, idParcours, Credit, estObligatoire) values
('INF205', 2, 6, 1),
('INF204', 2, 6, 3),
('INF206', 2, 6, 3),
('INF207', 2, 6, 3),
('INF211', 2, 10, 1),
('MTH202', 2, 4, 3),
('MTH205', 2, 4, 3),
('MTH206', 2, 4, 3),
('MTH203', 2, 4, 1);

-- BASES DE DONNEES ET RESEAUX (idParcours = 3)
insert into MatiereParcours (idMatiere, idParcours, Credit, estObligatoire) values
('INF204', 3, 6, 3),
('INF205', 3, 6, 3),
('INF206', 3, 6, 3),
('INF209', 3, 6, 1),
('INF212', 3, 10, 1),
('MTH202', 3, 4, 3),
('MTH204', 3, 4, 3),
('MTH206', 3, 4, 3),
('MTH203', 3, 4, 1);

-- WEB ET DESIGN (idParcours = 4)
insert into MatiereParcours (idMatiere, idParcours, Credit, estObligatoire) values
('INF204', 4, 6, true),
('INF205', 4, 6, true),
('INF206', 4, 6, true),
('INF209', 4, 6, true),
('INF212', 4, 10, true),
('MTH202', 4, 4, false),
('MTH204', 4, 4, false),
('MTH206', 4, 4, false),
('MTH203', 4, 4, false);

-- ===========================
-- Données de test : Etudiants
-- ===========================
insert into Etudiants (ETU, Nom, Prenom, DateNaissance, domaine) values
('ETU001234', 'Rakoto', 'Aina', '2003-05-14', 'Informatique'),
('ETU001235', 'Rabe', 'Tiana', '2002-11-03', 'Informatique'),
('ETU001236', 'Rasoa', 'Miora', '2003-01-22', 'Informatique'),
('ETU001237', 'Rabekoto', 'Miaro', '2003-08-12', 'Informatique'),
('ETU001238', 'Rakotobe', 'Rado', '2003-01-22', 'Informatique');


insert into Utilisateur(nom_user, password_user, email) VALUES
('admin', 'admin', 'admin@gmail.com'),  
('bob', 'admin', 'biblin@gmail.com'),
('alice', 'admin', 'alice@gmail.com');

-- ===========================
-- Données de test : Notes
-- ===========================
insert into Notes (idEtudiant, idMatiere, valeur, resultat) values
('ETU001234', 'INF201', 12, 'AB'),
('ETU001234', 'INF202', 15, 'B'),
('ETU001234', 'INF203', 10, 'AB'),
('ETU001234', 'INF208', 13, 'AB'),
('ETU001234', 'MTH201', 14, 'B'),
('ETU001234', 'ORG201', 11, 'AB'),

('ETU001234', 'INF204', 11, 'AB'),
('ETU001234', 'INF205', 17, 'B'),
('ETU001234', 'INF206', 9, 'P'),
('ETU001234', 'INF209', 14, 'B'),
('ETU001234', 'INF212', 16, 'B'),
('ETU001234', 'MTH202', 8, 'P'),
('ETU001234', 'MTH204', 15, 'B'),
('ETU001234', 'MTH206', 12, 'AB'),
('ETU001234', 'MTH203', 13, 'AB'),

('ETU001234', 'INF205', 16, 'B'),
('ETU001234', 'INF204', 10, 'AB'),
('ETU001234', 'INF206', 14, 'B'),
('ETU001234', 'INF207', 13, 'AB'),
('ETU001234', 'INF211', 12, 'AB'),
('ETU001234', 'MTH202', 9, 'P'),
('ETU001234', 'MTH205', 18, 'B'),
('ETU001234', 'MTH206', 7, 'P'),
('ETU001234', 'MTH203', 10, 'AB'),

('ETU001234', 'INF204', 12, 'AB'),
('ETU001234', 'INF205', 8, 'P'),
('ETU001234', 'INF206', 15, 'B'),
('ETU001234', 'INF209', 13, 'AB'),
('ETU001234', 'INF212', 17, 'B'),
('ETU001234', 'MTH202', 10, 'AB'),
('ETU001234', 'MTH204', 11, 'AB'),
('ETU001234', 'MTH206', 9, 'P'),
('ETU001234', 'MTH203', 14, 'B'),

('ETU001235', 'INF201', 8, 'P'),
('ETU001235', 'INF208', 9, 'P'),
('ETU001235', 'INF205', 7, 'P'),
('ETU001235', 'INF207', 15, 'B'),
('ETU001235', 'MTH205', 12, 'AB'),
('ETU001235', 'INF204', 6, 'P'),
('ETU001235', 'INF206', 10, 'AB'),
('ETU001235', 'MTH202', 14, 'B'),

('ETU001236', 'INF201', 10, 'AB'),
('ETU001236', 'INF202', 10, 'AB'),
('ETU001236', 'INF203', 10, 'AB'),
('ETU001236', 'INF208', 10, 'AB'),
('ETU001236', 'MTH201', 10, 'AB'),
('ETU001236', 'ORG201', 10, 'AB'),
('ETU001236', 'INF204', 14, 'B'),
('ETU001236', 'INF205', 14, 'B'),
('ETU001236', 'INF206', 14, 'B'),
('ETU001236', 'INF209', 15, 'B'),
('ETU001236', 'INF212', 15, 'B'),
('ETU001236', 'MTH202', 12, 'AB'),
('ETU001236', 'MTH204', 12, 'AB'),
('ETU001236', 'MTH206', 12, 'AB'),
('ETU001236', 'MTH203', 12, 'AB');
