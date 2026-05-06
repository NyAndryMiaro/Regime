-- Active: 1772519182592@@127.0.0.1@3306@Regime
CREATE OR REPLACE DATABASE Regime;
USE Regime;

CREATE OR REPLACE TABLE Utilisateur(
    id_Utilisateur int primary key auto_increment,
    nom varchar(75),
    email varchar(30),
    genre varchar(1),
    motdepasse varchar(20),
    taille double,
    poids double,
    estAdmin boolean
);

INSERT INTO Utilisateur(nom, email, genre, motdepasse, taille, poids, estAdmin) VALUES
('Alice', 'Alice@gmail.com', 'F', 'aaaaaaaa', 150, 40, FALSE),
('Admin', 'Admin@gmail.com', 'M', 'wwwwwwww', 190, 75,TRUE);

CREATE OR REPLACE TABLE Objectif(
    id_Objectif int primary key auto_increment,
    libelle varchar(50)
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

