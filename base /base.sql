drop database Notes;
create database Notes;
use Notes;

create or replace table Semestres (
    idSemestre int auto_increment PRIMARY KEY,
    libelle varchar(20)  
);

create or replace table Parcours(
    idParcours int auto_increment PRIMARY KEY,
    parcours varchar(50)
);

create or replace table Etudiants(
    ETU varchar(20) PRIMARY KEY,
    Nom varchar(50),
    Prenom varchar(20),
    DateNaissance date,
    domaine varchar(20)
);

create or replace table Matieres(
    idMatiere varchar(20) PRIMARY KEY,
    Nom varchar(50),
    idSemestre int,
    FOREIGN KEY (idSemestre) REFERENCES Semestres(idSemestre)
);

create or replace table MatiereParcours(
    idMatiere varchar(20),
    idParcours int,
    Credit int,
    estObligatoire boolean DEFAULT true,
    PRIMARY KEY (idMatiere, idParcours),
    FOREIGN KEY (idMatiere) REFERENCES Matieres(idMatiere),
    FOREIGN KEY (idParcours) REFERENCES Parcours(idParcours)
);

create or replace table Notes (
    idNote int PRIMARY KEY auto_increment,
    idEtudiant varchar(20),
    idMatiere varchar(20),
    idParcours int,
    valeur double,
    resultat VARCHAR(3),
    FOREIGN KEY (idEtudiant) REFERENCES Etudiants(ETU),
    FOREIGN KEY (idMatiere) REFERENCES Matieres(idMatiere),
    FOREIGN KEY (idParcours) REFERENCES Parcours(idParcours)
);

create or replace table Utilisateur(
    id_user int PRIMARY KEY AUTO_INCREMENT,
    nom_user VARCHAR(20),
    password_user VARCHAR(100),
    email VARCHAR(20)
);
