/*
DELETE FROM Commande;
DELETE FROM client;
DELETE FROM Produit;
DELETE FROM Est_Constitue;
*/

DELETE FROM administrateur;
DELETE FROM enseignant;
DELETE FROM etudiant;
DELETE FROM cycle;

INSERT INTO annee (numero_annee) VALUES (2020),(2021),(2022),(2023);
INSERT INTO semestre (numero_semestre,id_annee) VALUES (1,3),(2,3);

INSERT INTO administrateur (nom_admin,prenom_admin,telephone_admin,mail_admin,password_admin) VALUES 
('Porodo','Theo','0781908419','theo.porodo@isen-ouest.yncrea.fr','$2y$10$uyfPiSbqMovYRmSZT.fJlu9IVWj8v9hygi5Bj5hLHnuUdsQe9bUoW');
INSERT INTO enseignant (nom_prof,prenom_prof,telephone_prof,password_prof,mail_prof) VALUES 
('karine','ayoub','0675859647','$2y$10$uyfPiSbqMovYRmSZT.fJlu9IVWj8v9hygi5Bj5hLHnuUdsQe9bUoW','ayoub.karine@isen-ouest.yncrea.fr'),
('meuneu','Jean Jack','0675859647','mdpJean','jean-jack.meuneu@isen-ouest.yncrea.fr');

INSERT INTO cycle(nom_cycle) VALUES 
('CIR'),
('CEST'),
('CGSI'),
('CENT'),
('BIOST'),
('BIAST');

INSERT INTO etudiant (nom_etu,prenom_etu,mail_etu,password_etu,annee_cursus,nom_cycle) VALUES 
('croguy','romain','romain@gmail.com','$2y$10$uyfPiSbqMovYRmSZT.fJlu9IVWj8v9hygi5Bj5hLHnuUdsQe9bUoW',2,'CIR'),
('Pajdak','antoine','antoine@gmail.com','mdpAntoine',2,'CGSI'),
('fanjul','esteban','esteban@gmail.com','mdpEsteb',2,'CENT'),
('legoff','quentin','quentin@gmail.com','mdpQuentin',2,'CEST')
;

