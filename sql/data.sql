DELETE FROM administrateur;
DELETE FROM enseignant;
DELETE FROM etudiant;
DELETE FROM cycle;

INSERT INTO annee (numero_annee) VALUES ('2021-2022'),('2022-2023');
INSERT INTO semestre (numero_semestre,id_annee) VALUES (1,2),(2,2),(1,1),(2,1);

INSERT INTO administrateur (nom_admin,prenom_admin,telephone_admin,mail_admin,password_admin) VALUES 
('Gachete','Vincent','0781900502','admintest@gmail.com','$2y$10$fcTvVJwjFE73oS3elixLRux6zpnHh9Z66.Nefm.FLczB7YNLHSGv.');

INSERT INTO enseignant (nom_prof,prenom_prof,telephone_prof,password_prof,mail_prof) VALUES 
('Michelet','Benoit','0675859647','$2y$10$fcTvVJwjFE73oS3elixLRux6zpnHh9Z66.Nefm.FLczB7YNLHSGv.','proftest@gmail.com'),
('Menu','Jean','0675859647','$2y$10$fcTvVJwjFE73oS3elixLRux6zpnHh9Z66.Nefm.FLczB7YNLHSGv.','jean.menu@gmail.com'),
('Trolea','Francois','0675859647','$2y$10$fcTvVJwjFE73oS3elixLRux6zpnHh9Z66.Nefm.FLczB7YNLHSGv.','Francois.Trolea@gmail.com'),
('Jean','Julien','0785965748','$2y$10$fcTvVJwjFE73oS3elixLRux6zpnHh9Z66.Nefm.FLczB7YNLHSGv.','Julien.Jean@gmail.com'),
('Hika','Salome','1485963625','$2y$10$fcTvVJwjFE73oS3elixLRux6zpnHh9Z66.Nefm.FLczB7YNLHSGv.','Hika.Salome@gmail.com'),
('Crono','Matéo','0785965748','$2y$10$fcTvVJwjFE73oS3elixLRux6zpnHh9Z66.Nefm.FLczB7YNLHSGv.','mateo.Crono@gmail.com');

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
('Pidk','Romain','elevetest@gmail.com','$2y$10$fcTvVJwjFE73oS3elixLRux6zpnHh9Z66.Nefm.FLczB7YNLHSGv.',8,'0781963512'),
('flute','Antoine','antoine.flute@gmail.com','$2y$10$fcTvVJwjFE73oS3elixLRux6zpnHh9Z66.Nefm.FLczB7YNLHSGv.',8,'0785363512'),
('Okia','Theo','theo.Okia@gmail.com','$2y$10$fcTvVJwjFE73oS3elixLRux6zpnHh9Z66.Nefm.FLczB7YNLHSGv.',8,'0781463512'),
('maria','Mathias','mathias.maria@gmail.com','$2y$10$fcTvVJwjFE73oS3elixLRux6zpnHh9Z66.Nefm.FLczB7YNLHSGv.',8,'0725963512'),
('moinu','Mathis','mathis.moinu@gmail.com','$2y$10$fcTvVJwjFE73oS3elixLRux6zpnHh9Z66.Nefm.FLczB7YNLHSGv.',8,'0621963512'),
('Dupont', 'Ethan', 'ethan.Dupont@gmail.com','$2y$10$fcTvVJwjFE73oS3elixLRux6zpnHh9Z66.Nefm.FLczB7YNLHSGv.',8,'0736963512'),
('Kekeb','Paul','paul.Kekeb@gmail.com','$2y$10$fcTvVJwjFE73oS3elixLRux6zpnHh9Z66.Nefm.FLczB7YNLHSGv.',8,'0782563512'),
('Louia','Goustan','goustan.Louia@gmail.com','$2y$10$fcTvVJwjFE73oS3elixLRux6zpnHh9Z66.Nefm.FLczB7YNLHSGv.',8,'0712963512'),
('Renoat','Dorian','dorian.Renoat@gmail.com','$2y$10$fcTvVJwjFE73oS3elixLRux6zpnHh9Z66.Nefm.FLczB7YNLHSGv.',8,'0781963102'),
('Rimav','Sibylle','sibylle.Rimav@gmail.com','$2y$10$fcTvVJwjFE73oS3elixLRux6zpnHh9Z66.Nefm.FLczB7YNLHSGv.',10,'0730963512'),
('Sapo','Raphael','raphael.Sapo@isne-ouest.yncrea.fr','$2y$10$fcTvVJwjFE73oS3elixLRux6zpnHh9Z66.Nefm.FLczB7YNLHSGv.',10,'0720963512'),
('Edio','Victor','victor.Edio@gmail.com','$2y$10$fcTvVJwjFE73oS3elixLRux6zpnHh9Z66.Nefm.FLczB7YNLHSGv.',10,'0781251412'),
('Daoli','Erine','erine.Daoli@gmail.com','$2y$10$fcTvVJwjFE73oS3elixLRux6zpnHh9Z66.Nefm.FLczB7YNLHSGv.',10,'0781926512'),
('Issu','Océane','oceane.Issu@gmail.com','$2y$10$fcTvVJwjFE73oS3elixLRux6zpnHh9Z66.Nefm.FLczB7YNLHSGv.',2,'0781263512'),
('Coach','Léonore','leonore.Coach@gmail.com','$2y$10$fcTvVJwjFE73oS3elixLRux6zpnHh9Z66.Nefm.FLczB7YNLHSGv.',2,'0681962512'),
('Lola','Alex','alex.Lola@gmail.com','$2y$10$fcTvVJwjFE73oS3elixLRux6zpnHh9Z66.Nefm.FLczB7YNLHSGv.',2,'0781963366'),
('sesd','Guillaume','guillaume.sesd@gmail.com','$2y$10$fcTvVJwjFE73oS3elixLRux6zpnHh9Z66.Nefm.FLczB7YNLHSGv.',2,'0781965912');

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

