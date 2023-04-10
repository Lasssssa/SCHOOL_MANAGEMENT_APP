DELETE FROM administrateur;
DELETE FROM enseignant;
DELETE FROM etudiant;
DELETE FROM cycle;

INSERT INTO annee (numero_annee) VALUES (2021),(2022),(2023);
INSERT INTO semestre (numero_semestre,id_annee) VALUES (1,3),(2,3),(1,2),(2,2),(1,1),(2,1);

INSERT INTO administrateur (nom_admin,prenom_admin,telephone_admin,mail_admin,password_admin) VALUES 
('Porodo','Theo','0781908419','theo.porodo@isen-ouest.yncrea.fr','$2y$10$uyfPiSbqMovYRmSZT.fJlu9IVWj8v9hygi5Bj5hLHnuUdsQe9bUoW');
INSERT INTO enseignant (nom_prof,prenom_prof,telephone_prof,password_prof,mail_prof) VALUES 
('Karine','Ayoub','0675859647','$2y$10$uyfPiSbqMovYRmSZT.fJlu9IVWj8v9hygi5Bj5hLHnuUdsQe9bUoW','ayoub.karine@isen-ouest.yncrea.fr'),
('Leandro','Montero','0675859647','$2y$10$uyfPiSbqMovYRmSZT.fJlu9IVWj8v9hygi5Bj5hLHnuUdsQe9bUoW','leandro.montero@isen-ouest.yncrea.fr'),
('Pierre','Bouvier','0675859647','$2y$10$uyfPiSbqMovYRmSZT.fJlu9IVWj8v9hygi5Bj5hLHnuUdsQe9bUoW','pierre.bouvier@isen-ouest.yncrea.fr'),
('Jean','Dupont','0675859647','$2y$10$uyfPiSbqMovYRmSZT.fJlu9IVWj8v9hygi5Bj5hLHnuUdsQe9bUoW','jean.dupont@isen-ouest.yncrea.fr');

INSERT INTO cycle(nom_cycle) VALUES 
('CIR'),
('CEST'),
('CGSI'),
('CENT'),
('BIOST'),
('MECA'),
('BIAST');

INSERT INTO classe(annee_cursus,nom_cycle) VALUES
(1,'CIR'),
(1,'CEST'),
(1,'CGSI'),
(1,'CENT'),
(1,'BIOST'),
(1,'MECA'),
(1,'BIAST'),
(2,'CIR'),
(2,'CEST'),
(2,'CGSI'),
(2,'CENT'),
(2,'BIOST'),
(2,'MECA'),
(2,'BIAST'),
(3,'CIR'),
(3,'CEST'),
(3,'CGSI'),
(3,'CENT'),
(3,'BIOST'),
(3,'MECA'),
(3,'BIAST');

INSERT INTO etudiant (nom_etu,prenom_etu,mail_etu,password_etu,id_classe) VALUES 
('Croguennoc','Romain','romain.croguennoc@isen-ouest.yncrea.fr','$2y$10$uyfPiSbqMovYRmSZT.fJlu9IVWj8v9hygi5Bj5hLHnuUdsQe9bUoW',1),
('Sibylle','Rimbert','sibylle.rimbert@isen-ouest.yncrea.fr','$2y$10$uyfPiSbqMovYRmSZT.fJlu9IVWj8v9hygi5Bj5hLHnuUdsQe9bUoW',7),
('Pajdak','Antoine','antoine.pajdak@isen-ouest.yncrea.fr','$2y$10$uyfPiSbqMovYRmSZT.fJlu9IVWj8v9hygi5Bj5hLHnuUdsQe9bUoW',3),
('Maret','Julien','julien.maret@isen-ouest.yncrea.fr','$2y$10$uyfPiSbqMovYRmSZT.fJlu9IVWj8v9hygi5Bj5hLHnuUdsQe9bUoW',8),
('Dubois','Jeanne','jeanne.dubois@isen-ouest.yncrea.fr','$2y$10$uyfPiSbqMovYRmSZT.fJlu9IVWj8v9hygi5Bj5hLHnuUdsQe9bUoW',9),
('Dupont','Titouan','titouan.dupont@isen-ouest.yncrea.fr','$2y$10$uyfPiSbqMovYRmSZT.fJlu9IVWj8v9hygi5Bj5hLHnuUdsQe9bUoW',6);

