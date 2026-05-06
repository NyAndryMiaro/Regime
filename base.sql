CREATE OR REPLACE DATABASE Regime;
USE Regime;

CREATE OR REPLACE TABLE Utilisateur(
    nom varchar(75),
    email varchar(30),
    genre varchar(1),
    motdepasse varchar(20),
    taille double,
    poids double
);