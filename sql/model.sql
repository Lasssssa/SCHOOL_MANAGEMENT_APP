
------------------------------------------------------------
--        A ADAPTER AVEC NOTRE BASE DE DONNEES
------------------------------------------------------------
/*
DROP TABLE IF EXISTS client CASCADE;
DROP TABLE IF EXISTS Produit CASCADE;
DROP TABLE IF EXISTS Commande CASCADE;
DROP TABLE IF EXISTS Est_Constitue CASCADE;
*/

------------------------------------------------------------
--        Script Postgre 
------------------------------------------------------------
DROP TABLE IF EXISTS administrateur CASCADE;
DROP TABLE IF EXISTS enseignant CASCADE;
DROP TABLE IF EXISTS annee CASCADE;
DROP TABLE IF EXISTS participe CASCADE;
DROP TABLE IF EXISTS cycle CASCADE;
DROP TABLE IF EXISTS semestre CASCADE;
DROP TABLE IF EXISTS etudiant CASCADE;
DROP TABLE IF EXISTS cours CASCADE;
DROP TABLE IF EXISTS epreuve CASCADE;
DROP TABLE IF EXISTS appreciation CASCADE;
DROP TABLE IF EXISTS fait_epreuve CASCADE;
------------------------------------------------------------
--        Script Postgre 
------------------------------------------------------------



------------------------------------------------------------
-- Table: administrateur
------------------------------------------------------------
CREATE TABLE public.administrateur(
	id             SERIAL NOT NULL ,
	nom            VARCHAR (50) NOT NULL ,
	prenom         VARCHAR (50) NOT NULL ,
	telephone      VARCHAR (25) NOT NULL ,
	mail           VARCHAR (60) NOT NULL ,
	passworduser   VARCHAR (60) NOT NULL  ,
	CONSTRAINT administrateur_PK PRIMARY KEY (id)
)WITHOUT OIDS;


------------------------------------------------------------
-- Table: enseignant
------------------------------------------------------------
CREATE TABLE public.enseignant(
	id             SERIAL NOT NULL ,
	nom            VARCHAR (50) NOT NULL ,
	prenom         VARCHAR (50) NOT NULL ,
	telephone      VARCHAR (25) NOT NULL ,
	passworduser   VARCHAR (60) NOT NULL ,
	mail           VARCHAR (50) NOT NULL  ,
	CONSTRAINT enseignant_PK PRIMARY KEY (id)
)WITHOUT OIDS;


------------------------------------------------------------
-- Table: annee
------------------------------------------------------------
CREATE TABLE public.annee(
	id_annee   SERIAL NOT NULL ,
	numero     INT  NOT NULL  ,
	CONSTRAINT annee_PK PRIMARY KEY (id_annee)
)WITHOUT OIDS;


------------------------------------------------------------
-- Table: semestre
------------------------------------------------------------
CREATE TABLE public.semestre(
	id_semestre   SERIAL NOT NULL ,
	numero        INT  NOT NULL ,
	id_annee      INT  NOT NULL  ,
	CONSTRAINT semestre_PK PRIMARY KEY (id_semestre)

	,CONSTRAINT semestre_annee_FK FOREIGN KEY (id_annee) REFERENCES public.annee(id_annee)
)WITHOUT OIDS;


------------------------------------------------------------
-- Table: cours
------------------------------------------------------------
CREATE TABLE public.cours(
	nom_matiere   VARCHAR (50) NOT NULL ,
	duree         INT  NOT NULL ,
	id            INT  NOT NULL ,
	id_annee      INT  NOT NULL ,
	id_semestre   INT  NOT NULL  ,
	CONSTRAINT cours_PK PRIMARY KEY (nom_matiere)

	,CONSTRAINT cours_enseignant_FK FOREIGN KEY (id) REFERENCES public.enseignant(id)
	,CONSTRAINT cours_annee0_FK FOREIGN KEY (id_annee) REFERENCES public.annee(id_annee)
	,CONSTRAINT cours_semestre1_FK FOREIGN KEY (id_semestre) REFERENCES public.semestre(id_semestre)
)WITHOUT OIDS;


------------------------------------------------------------
-- Table: epreuve
------------------------------------------------------------
CREATE TABLE public.epreuve(
	id              SERIAL NOT NULL ,
	nom             VARCHAR (50) NOT NULL ,
	coefficient     FLOAT  NOT NULL ,
	id_enseignant   INT  NOT NULL ,
	nom_matiere     VARCHAR (50) NOT NULL  ,
	CONSTRAINT epreuve_PK PRIMARY KEY (id)

	,CONSTRAINT epreuve_enseignant_FK FOREIGN KEY (id_enseignant) REFERENCES public.enseignant(id)
	,CONSTRAINT epreuve_cours0_FK FOREIGN KEY (nom_matiere) REFERENCES public.cours(nom_matiere)
)WITHOUT OIDS;


------------------------------------------------------------
-- Table: cycle
------------------------------------------------------------
CREATE TABLE public.cycle(
	nom_cycle   VARCHAR (20) NOT NULL  ,
	CONSTRAINT cycle_PK PRIMARY KEY (nom_cycle)
)WITHOUT OIDS;


------------------------------------------------------------
-- Table: etudiant
------------------------------------------------------------
CREATE TABLE public.etudiant(
	id             SERIAL NOT NULL ,
	nom            VARCHAR (50) NOT NULL ,
	prenom         VARCHAR (50) NOT NULL ,
	mail           VARCHAR (50) NOT NULL ,
	passworduser   VARCHAR (60) NOT NULL ,
	annee_cursus   INT  NOT NULL ,
	nom_cycle      VARCHAR (20) NOT NULL  ,
	CONSTRAINT etudiant_PK PRIMARY KEY (id)

	,CONSTRAINT etudiant_cycle_FK FOREIGN KEY (nom_cycle) REFERENCES public.cycle(nom_cycle)
)WITHOUT OIDS;


------------------------------------------------------------
-- Table: appreciation
------------------------------------------------------------
CREATE TABLE public.appreciation(
	id            SERIAL NOT NULL ,
	phrase        VARCHAR (50) NOT NULL ,
	id_etudiant   INT  NOT NULL ,
	id_semestre   INT  NOT NULL ,
	nom_matiere   VARCHAR (50) NOT NULL  ,
	CONSTRAINT appreciation_PK PRIMARY KEY (id)

	,CONSTRAINT appreciation_etudiant_FK FOREIGN KEY (id_etudiant) REFERENCES public.etudiant(id)
	,CONSTRAINT appreciation_semestre0_FK FOREIGN KEY (id_semestre) REFERENCES public.semestre(id_semestre)
	,CONSTRAINT appreciation_cours1_FK FOREIGN KEY (nom_matiere) REFERENCES public.cours(nom_matiere)
)WITHOUT OIDS;


------------------------------------------------------------
-- Table: participe
------------------------------------------------------------
CREATE TABLE public.participe(
	nom_matiere   VARCHAR (50) NOT NULL ,
	id            INT  NOT NULL  ,
	CONSTRAINT participe_PK PRIMARY KEY (nom_matiere,id)

	,CONSTRAINT participe_cours_FK FOREIGN KEY (nom_matiere) REFERENCES public.cours(nom_matiere)
	,CONSTRAINT participe_etudiant0_FK FOREIGN KEY (id) REFERENCES public.etudiant(id)
)WITHOUT OIDS;


------------------------------------------------------------
-- Table: fait_epreuve
------------------------------------------------------------
CREATE TABLE public.fait_epreuve(
	id            INT  NOT NULL ,
	id_etudiant   INT  NOT NULL ,
	note          FLOAT  NOT NULL ,
	est_note      BOOL  NOT NULL  ,
	CONSTRAINT fait_epreuve_PK PRIMARY KEY (id,id_etudiant)

	,CONSTRAINT fait_epreuve_epreuve_FK FOREIGN KEY (id) REFERENCES public.epreuve(id)
	,CONSTRAINT fait_epreuve_etudiant0_FK FOREIGN KEY (id_etudiant) REFERENCES public.etudiant(id)
)WITHOUT OIDS;



