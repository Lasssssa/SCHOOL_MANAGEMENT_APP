DELETE FROM administrateur;
DELETE FROM enseignant;
DELETE FROM etudiant;
DELETE FROM cycle;

INSERT INTO annee (numero_annee) VALUES ('2021-2022'),('2022-2023');
INSERT INTO semestre (numero_semestre,id_annee) VALUES (1,2),(2,2),(1,1),(2,1);

INSERT INTO administrateur (nom_admin,prenom_admin,telephone_admin,mail_admin,password_admin) VALUES 
('Porodo','Theo','0781908419','admin@mail.com','$2y$10$fcTvVJwjFE73oS3elixLRux6zpnHh9Z66.Nefm.FLczB7YNLHSGv.');

INSERT INTO enseignant (nom_prof,prenom_prof,telephone_prof,password_prof,mail_prof) VALUES 
('Karine','Ayoub','0675859647','$2y$10$fcTvVJwjFE73oS3elixLRux6zpnHh9Z66.Nefm.FLczB7YNLHSGv.','ayoub.karine@isen-ouest.yncrea.fr'),
('Montero','Léandro','0675859647','$2y$10$fcTvVJwjFE73oS3elixLRux6zpnHh9Z66.Nefm.FLczB7YNLHSGv.','leandro.montero@isen-ouest.yncrea.fr'),
('Lacourt','Marc','0675859647','$2y$10$fcTvVJwjFE73oS3elixLRux6zpnHh9Z66.Nefm.FLczB7YNLHSGv.','marc.lacourt@isen-ouest.yncrea.fr'),
('Freixas','Jeremy','0785965748','$2y$10$fcTvVJwjFE73oS3elixLRux6zpnHh9Z66.Nefm.FLczB7YNLHSGv.','jeremy.freixas@isen-ouest.yncrea.fr'),
('Turmero','Virginia','1485963625','$2y$10$fcTvVJwjFE73oS3elixLRux6zpnHh9Z66.Nefm.FLczB7YNLHSGv.','virginia.turmero@isen-ouest.yncrea.fr'),
('Sorin','Matéo','0785965748','$2y$10$fcTvVJwjFE73oS3elixLRux6zpnHh9Z66.Nefm.FLczB7YNLHSGv.','mateo.sorin@isen-ouest.yncrea.fr');

INSERT INTO cycle(nom_cycle) VALUES 
('CIR'),
('CEST'),
('CGSI'),
('CENT'),
('BIOST'),
('MECA'),
('BIAST'),
('MASTER');

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
(3,'BIAST'),
(4,'MASTER'),
(5,'MASTER');

INSERT INTO etudiant (nom_etu,prenom_etu,mail_etu,password_etu,id_classe,telephone_etu) VALUES
('Croguennoc','Romain','romain.croguennoc@isen-ouest.yncrea.fr','$2y$10$fcTvVJwjFE73oS3elixLRux6zpnHh9Z66.Nefm.FLczB7YNLHSGv.',8,'0781963512'),
('Pajdak','Antoine','antoine.pajdak@isen-ouest.yncrea.fr','$2y$10$fcTvVJwjFE73oS3elixLRux6zpnHh9Z66.Nefm.FLczB7YNLHSGv.',8,'0785363512'),
('Porodo','Theo','theo.porodo@isen-ouest.yncrea.fr','$2y$10$fcTvVJwjFE73oS3elixLRux6zpnHh9Z66.Nefm.FLczB7YNLHSGv.',8,'0781463512'),
('Paitier','Mathias','mathias.paitier@isen-ouest.yncrea.fr','$2y$10$fcTvVJwjFE73oS3elixLRux6zpnHh9Z66.Nefm.FLczB7YNLHSGv.',8,'0725963512'),
('Meunier','Mathis','mathis.meunier@isen-ouest.yncrea.fr','$2y$10$fcTvVJwjFE73oS3elixLRux6zpnHh9Z66.Nefm.FLczB7YNLHSGv.',8,'0621963512'),
('Le Pan', 'Ethan', 'ethan.le-pan@isen-ouest.yncrea.fr','$2y$10$fcTvVJwjFE73oS3elixLRux6zpnHh9Z66.Nefm.FLczB7YNLHSGv.',8,'0736963512'),
('Kebci','Paul','paul.kebci@isen-ouest.yncrea.fr','$2y$10$fcTvVJwjFE73oS3elixLRux6zpnHh9Z66.Nefm.FLczB7YNLHSGv.',8,'0782563512'),
('Sermon','Goustan','goustan.sermon@isen-ouest.yncrea.fr','$2y$10$fcTvVJwjFE73oS3elixLRux6zpnHh9Z66.Nefm.FLczB7YNLHSGv.',8,'0712963512'),
('Rena','Dorian','dorian.rena@isen-ouest.yncrea.fr','$2y$10$fcTvVJwjFE73oS3elixLRux6zpnHh9Z66.Nefm.FLczB7YNLHSGv.',8,'0781963102'),
('Rimbert','Sibylle','sibylle.rimbert@isen-ouest.yncrea.fr','$2y$10$fcTvVJwjFE73oS3elixLRux6zpnHh9Z66.Nefm.FLczB7YNLHSGv.',10,'0730963512'),
('Vrain','Raphael','raphael.vrain@isne-ouest.yncrea.fr','$2y$10$fcTvVJwjFE73oS3elixLRux6zpnHh9Z66.Nefm.FLczB7YNLHSGv.',10,'0720963512'),
('Edet','Victor','victor.edet@isen-ouest.yncrea.fr','$2y$10$fcTvVJwjFE73oS3elixLRux6zpnHh9Z66.Nefm.FLczB7YNLHSGv.',10,'0781251412'),
('Gadras','Erine','erine.gadras@isen-ouest.yncrea.fr','$2y$10$fcTvVJwjFE73oS3elixLRux6zpnHh9Z66.Nefm.FLczB7YNLHSGv.',10,'0781926512'),
('Rabussier','Océane','oceane.rabussier@isen-ouest.yncrea.fr','$2y$10$fcTvVJwjFE73oS3elixLRux6zpnHh9Z66.Nefm.FLczB7YNLHSGv.',2,'0781263512'),
('Le Floch','Léonore','leonore.le-floch@isen-ouest.yncrea.fr','$2y$10$fcTvVJwjFE73oS3elixLRux6zpnHh9Z66.Nefm.FLczB7YNLHSGv.',2,'0681962512'),
('Grimaud','Alex','alex.grimaud@isen-ouest.yncrea.fr','$2y$10$fcTvVJwjFE73oS3elixLRux6zpnHh9Z66.Nefm.FLczB7YNLHSGv.',2,'0781963366'),
('Petry','Guillaume','guillaume.petry@isen-ouest.yncrea.fr','$2y$10$fcTvVJwjFE73oS3elixLRux6zpnHh9Z66.Nefm.FLczB7YNLHSGv.',2,'0781965912');

INSERT INTO cours (nom_matiere,duree,id_prof,id_semestre,id_classe) VALUES
('PHP CIR2', 60, 1, 2, 8),
('HTML CIR2', 30, 1, 2, 8),
('Mathématiques CIR2',120,3,2,8),
('Physique CIR2',120,4,2,8),
('Mathématiques EST1',120,3,2,2),
('Physique EST1',120,4,2,2),
('Langage C CIR2',60,2,1,8),
('Anglais CIR2',30,5,2,8),
('FHS CIR2',30,6,2,8),
('Anglais EST1',30,5,2,2),
('FHS EST1',30,6,2,2),
('Anglais CGSI2',30,5,2,10),
('FHS CGSI2',30,6,2,10);

INSERT INTO epreuve (nom_epreuve,coefficient,id_matiere) VALUES 
('DS1',2,1),
('DS2',2,1),
('DS1',2,2),
('DS2',2,2),
('DS1',2,3),
('DS2',2,3),
('DS3',2,3),
('DS1',2,4),
('DS2',2,4),
('DS3',2,4),
('DS1',2,5),
('DS2',2,5),
('DS3',2,5),
('DS1',2,6),
('DS2',2,6),
('DS3',2,6),
('DS1',2,7),
('DS1',2,8),
('DS2',2,8),
('DS1',2,9),
('DS2',2,9),
('DS1',2,10),
('DS2',2,10),
('DS1',2,11),
('DS2',2,11),
('DS1',2,12),
('DS2',2,12);

