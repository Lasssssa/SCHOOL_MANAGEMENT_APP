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
('Montero','Léandro','0675859647','$2y$10$uyfPiSbqMovYRmSZT.fJlu9IVWj8v9hygi5Bj5hLHnuUdsQe9bUoW','leandro.montero@isen-ouest.yncrea.fr'),
('Bouvier','Jean','0675859647','$2y$10$uyfPiSbqMovYRmSZT.fJlu9IVWj8v9hygi5Bj5hLHnuUdsQe9bUoW','pierre.bouvier@isen-ouest.yncrea.fr'),
('Jean','Dupont','0675859647','$2y$10$uyfPiSbqMovYRmSZT.fJlu9IVWj8v9hygi5Bj5hLHnuUdsQe9bUoW','jean.dupont@isen-ouest.yncrea.fr'),
('Lacourt','Marc','0675859647','$2y$10$uyfPiSbqMovYRmSZT.fJlu9IVWj8v9hygi5Bj5hLHnuUdsQe9bUoW','marc.lacourt@isen-ouest.yncrea.fr');

INSERT INTO cycle(nom_cycle) VALUES 
('CIR'),
('CEST'),
('CGSI'),
('CENT'),
('BIOST'),
('MECA'),
('BIAST');

INSERT INTO etudiant (nom_etu,prenom_etu,mail_etu,password_etu,annee_cursus,nom_cycle) VALUES 
('Croguennoc','Romain','romain.croguennoc@isen-ouest.yncrea.fr','$2y$10$uyfPiSbqMovYRmSZT.fJlu9IVWj8v9hygi5Bj5hLHnuUdsQe9bUoW',2,'CIR'),
('Sibylle','Rimbert','sibylle.rimbert@isen-ouest.yncrea.fr','$2y$10$uyfPiSbqMovYRmSZT.fJlu9IVWj8v9hygi5Bj5hLHnuUdsQe9bUoW',2,'CGSI'),
('Pajdak','Antoine','antoine.pajdak@isen-ouest.yncrea.fr','$2y$10$uyfPiSbqMovYRmSZT.fJlu9IVWj8v9hygi5Bj5hLHnuUdsQe9bUoW',2,'CIR'),
('Maret','Julien','julien.maret@isen-ouest.yncrea.fr','$2y$10$uyfPiSbqMovYRmSZT.fJlu9IVWj8v9hygi5Bj5hLHnuUdsQe9bUoW',1,'CIR'),
('Dubois','Jeanne','jeanne.dubois@isen-ouest.yncrea.fr','$2y$10$uyfPiSbqMovYRmSZT.fJlu9IVWj8v9hygi5Bj5hLHnuUdsQe9bUoW',1,'CENT'),
('Dupont','Titouan','titouan.dupont@isen-ouest.yncrea.fr','$2y$10$uyfPiSbqMovYRmSZT.fJlu9IVWj8v9hygi5Bj5hLHnuUdsQe9bUoW',3,'CEST');

