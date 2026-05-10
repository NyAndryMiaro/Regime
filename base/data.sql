insert into Codes(code, montant) VALUES
('eeeeeeee', 50000),
('heehee', 40000);

INSERT INTO Regime(id_objectif, libelle,  variation_poids, prix_unitaire, duree, pourcentage_viande, pourcentage_legume, pourcentage_poisson) VALUES 
(1, 'Regime Augmenter poids 1', 2.5, 2000, 60, 50, 30,20),
(1, 'Regime Augmenter poids 2', 5, 3000, 60, 60, 30,10),
(2, 'Regime Diminuer poids 1', -2.5, 2000, 60, 10, 70,20),
(2, 'Regime Diminuer poids 2', -5, 2000, 60, 5, 65,20),
(2, 'Regime Diminuer poids 3', -7.5, 2000, 60, 5, 50,45);

INSERT INTO Activites(id_Objectif, libelle, duree, variation_poids) VALUES
(1, 'Marche légère', 30, 0.2),
(1, 'Yoga et étirements', 45, 0.5),
(2, 'Course rapide', 20, -1.2),
(2, 'HIIT intense', 30, -1.8),
(3, 'Natation modérée', 40, 0.9);