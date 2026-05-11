-- Nettoyage complet des tables
DELETE FROM Codes;
DELETE FROM Regime;
DELETE FROM Activites;
DELETE FROM Utilisateur;

-- 1. INSERTION DE 3 UTILISATEURS (1 Standard, 1 Gold, 1 Admin)
INSERT INTO Utilisateur(nom, email, genre, motdepasse, taille, poids, argent, estAdmin, estGold) VALUES
('Clara', 'clara.diet@gmail.com', 'F', 'aaaaaaaa', 165, 55, 15000, FALSE, FALSE),
('Bob', 'bob@gmail.com', 'M', 'bbbbbbbb', 180, 85, 30000, FALSE, TRUE),
('Marc_Staff', 'marc.admin@regym.fr', 'M', 'wwwwwwww', 190, 75, 0, TRUE, FALSE);

-- 2. INSERTION DE 15 CODES DE RECHARGE
INSERT INTO Codes(code, montant) VALUES
('RE_GYM_50K', 50000),
('RE_GYM_40K', 40000),
('FIT_EASY_10', 10000),
('GOLDEN_P_30', 30000),
('REG_HEALTH2', 25000),
('WELCOME_15', 15000),
('SPORT_GAIN5', 5000),
('BOOST_GYM8', 8000),
('PROMO_DIET', 12000),
('VIP_REF_100', 100000),
('SILVER_REG', 20000),
('CHALLENG_3', 35000),
('START_WELL', 18000),
('ACTIVE_LIF', 45000),
('IMC_SPECIAL', 60000);

-- 3. INSERTION DE 5 RÉGIMES (id_objectif : 1 = Augmenter, 2 = Réduire, 3 = IMC idéal)
INSERT INTO Regime(id_objectif, libelle, variation_poids, prix_unitaire, duree, pourcentage_viande, pourcentage_legume, pourcentage_poisson) VALUES 
(1, 'Hyperprotéiné Masse Max', 4.5, 2500, 30, 60, 20, 20),
(1, 'Prise de masse Clean Gainer', 3.0, 1800, 30, 45, 35, 20),
(2, 'Brûleur de graisse Kéto', -3.5, 2200, 30, 20, 50, 30),
(2, 'Détox & Légèreté', -5.0, 1500, 45, 10, 70, 20),
(3, 'Équilibre Cardio-Vasculaire', 0.5, 2000, 30, 30, 40, 30);

-- 4. INSERTION DE 5 ACTIVITÉS SPORTIVES (id_objectif : 1 = Augmenter, 2 = Réduire, 3 = IMC idéal)
INSERT INTO Activites(id_Objectif, libelle, duree, variation_poids) VALUES
(1, 'Musculation Force & Volume', 60, 0.4),
(1, 'Renforcement musculaire lourd', 45, 0.3),
(2, 'Course fractionnée (Cardio HIIT)', 30, -0.8),
(2, 'Natation intensive (Crawl)', 45, -0.6),
(3, 'Pilates et gainage postural', 50, -0.1);