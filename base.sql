CREATE OR REPLACE DATABASE Regime;
USE Regime;

CREATE OR REPLACE TABLE Utilisateur(
    id_Utilisateur int primary key auto_increment,
    nom varchar(75),
    email varchar(30),
    genre varchar(1),
    motdepasse varchar(20),
    taille double,
    poids double
);

CREATE OR REPLACE TABLE Objectif(
    id_Objectif int primary key auto_increment,
    libelle varchar(20)
);

INSERT INTO Objectif (libelle) VALUES 
('Augmenter son poids'),
('Reduire son poids'),
('Atteindre son IMC ideal');

CREATE OR REPLACE TABLE UtilisateurObjectif(
    id_UtilisateurObjectif int primary key auto_increment,
    id_Utilisateur int references Utilisateur (id_Utilisateur),
    id_Objectif int references Objectif (id_Objectif)
);

