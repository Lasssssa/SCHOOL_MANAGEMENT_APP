------------------------------------------------------------
--        Script Postgre 
------------------------------------------------------------
DROP TABLE IF EXISTS administrateur CASCADE;
DROP TABLE IF EXISTS enseignant CASCADE;
DROP TABLE IF EXISTS annee CASCADE;
DROP TABLE IF EXISTS cycle CASCADE;
DROP TABLE IF EXISTS semestre CASCADE;
DROP TABLE IF EXISTS etudiant CASCADE;
DROP TABLE IF EXISTS cours CASCADE;
DROP TABLE IF EXISTS epreuve CASCADE;
DROP TABLE IF EXISTS appreciation CASCADE;
DROP TABLE IF EXISTS fait_epreuve CASCADE;
DROP TABLE IF EXISTS recoit_appreciation CASCADE;
DROP TABLE IF EXISTS classe CASCADE;
------------------------------------------------------------
--        Script Postgre 
------------------------------------------------------------



------------------------------------------------------------
-- Table: administrateur
------------------------------------------------------------
CREATE TABLE public.administrateur(
	id_admin          SERIAL NOT NULL ,
	nom_admin         VARCHAR (50) NOT NULL ,
	prenom_admin      VARCHAR (50) NOT NULL ,
	telephone_admin   VARCHAR (25) NOT NULL ,
	mail_admin        VARCHAR (60) NOT NULL ,
	password_admin    VARCHAR (60) NOT NULL  ,
	CONSTRAINT administrateur_PK PRIMARY KEY (id_admin)
)WITHOUT OIDS;


------------------------------------------------------------
-- Table: enseignant
------------------------------------------------------------
CREATE TABLE public.enseignant(
	id_prof          SERIAL NOT NULL ,
	nom_prof         VARCHAR (50) NOT NULL ,
	prenom_prof      VARCHAR (50) NOT NULL ,
	telephone_prof   VARCHAR (25) NOT NULL ,
	password_prof    VARCHAR (60) NOT NULL ,
	mail_prof        VARCHAR (50) NOT NULL  ,
	CONSTRAINT enseignant_PK PRIMARY KEY (id_prof)
)WITHOUT OIDS;


------------------------------------------------------------
-- Table: annee
------------------------------------------------------------
CREATE TABLE public.annee(
	id_annee       SERIAL NOT NULL ,
	numero_annee   INT  NOT NULL  ,
	CONSTRAINT annee_PK PRIMARY KEY (id_annee)
)WITHOUT OIDS;


------------------------------------------------------------
-- Table: semestre
------------------------------------------------------------
CREATE TABLE public.semestre(
	id_semestre       SERIAL NOT NULL ,
	numero_semestre   INT  NOT NULL ,
	id_annee          INT  NOT NULL  ,
	CONSTRAINT semestre_PK PRIMARY KEY (id_semestre)

	,CONSTRAINT semestre_annee_FK FOREIGN KEY (id_annee) REFERENCES public.annee(id_annee)
)WITHOUT OIDS;


------------------------------------------------------------
-- Table: cycle
------------------------------------------------------------
CREATE TABLE public.cycle(
	nom_cycle   VARCHAR (20) NOT NULL  ,
	CONSTRAINT cycle_PK PRIMARY KEY (nom_cycle)
)WITHOUT OIDS;


------------------------------------------------------------
-- Table: classe
------------------------------------------------------------
CREATE TABLE public.classe(
	id_classe      SERIAL NOT NULL ,
	annee_cursus   INT  NOT NULL ,
	nom_cycle      VARCHAR (20) NOT NULL  ,
	CONSTRAINT classe_PK PRIMARY KEY (id_classe)

	,CONSTRAINT classe_cycle_FK FOREIGN KEY (nom_cycle) REFERENCES public.cycle(nom_cycle)
)WITHOUT OIDS;


------------------------------------------------------------
-- Table: etudiant
------------------------------------------------------------
CREATE TABLE public.etudiant(
	id_etu         SERIAL NOT NULL ,
	nom_etu        VARCHAR (50) NOT NULL ,
	prenom_etu     VARCHAR (50) NOT NULL ,
	mail_etu       VARCHAR (50) NOT NULL ,
	password_etu   VARCHAR (60) NOT NULL ,
	id_classe      INT  NOT NULL  ,
	CONSTRAINT etudiant_PK PRIMARY KEY (id_etu)

	,CONSTRAINT etudiant_classe_FK FOREIGN KEY (id_classe) REFERENCES public.classe(id_classe)
)WITHOUT OIDS;


------------------------------------------------------------
-- Table: cours
------------------------------------------------------------
CREATE TABLE public.cours(
	id_matiere    SERIAL NOT NULL ,
	nom_matiere   VARCHAR (50) NOT NULL ,
	duree         INT  NOT NULL ,
	id_prof       INT  NOT NULL ,
	id_semestre   INT  NOT NULL ,
	id_classe     INT  NOT NULL  ,
	CONSTRAINT cours_PK PRIMARY KEY (id_matiere)

	,CONSTRAINT cours_enseignant_FK FOREIGN KEY (id_prof) REFERENCES public.enseignant(id_prof)
	,CONSTRAINT cours_semestre0_FK FOREIGN KEY (id_semestre) REFERENCES public.semestre(id_semestre)
	,CONSTRAINT cours_classe1_FK FOREIGN KEY (id_classe) REFERENCES public.classe(id_classe)
)WITHOUT OIDS;


------------------------------------------------------------
-- Table: epreuve
------------------------------------------------------------
CREATE TABLE public.epreuve(
	id_epreuve    SERIAL NOT NULL ,
	nom_epreuve   VARCHAR (50) NOT NULL ,
	coefficient   FLOAT  NOT NULL ,
	id_matiere    INT  NOT NULL  ,
	CONSTRAINT epreuve_PK PRIMARY KEY (id_epreuve)

	,CONSTRAINT epreuve_cours_FK FOREIGN KEY (id_matiere) REFERENCES public.cours(id_matiere) ON DELETE CASCADE
)WITHOUT OIDS;


------------------------------------------------------------
-- Table: appreciation
------------------------------------------------------------
CREATE TABLE public.appreciation(
	id_appreciation   SERIAL NOT NULL ,
	phrase            VARCHAR (50) NOT NULL ,
	id_matiere        INT  NOT NULL  ,
	CONSTRAINT appreciation_PK PRIMARY KEY (id_appreciation)

	,CONSTRAINT appreciation_cours_FK FOREIGN KEY (id_matiere) REFERENCES public.cours(id_matiere) ON DELETE CASCADE
)WITHOUT OIDS;


------------------------------------------------------------
-- Table: fait_epreuve
------------------------------------------------------------
CREATE TABLE public.fait_epreuve(
	id_epreuve   INT  NOT NULL ,
	id_etu       INT  NOT NULL ,
	note         FLOAT  NOT NULL ,
	est_note     BOOL  NOT NULL  ,
	CONSTRAINT fait_epreuve_PK PRIMARY KEY (id_epreuve,id_etu)

	,CONSTRAINT fait_epreuve_epreuve_FK FOREIGN KEY (id_epreuve) REFERENCES public.epreuve(id_epreuve)
	,CONSTRAINT fait_epreuve_etudiant0_FK FOREIGN KEY (id_etu) REFERENCES public.etudiant(id_etu)
)WITHOUT OIDS;


------------------------------------------------------------
-- Table: recoit_appreciation
------------------------------------------------------------
CREATE TABLE public.recoit_appreciation(
	id_appreciation   INT  NOT NULL ,
	id_etu            INT  NOT NULL  ,
	CONSTRAINT recoit_appreciation_PK PRIMARY KEY (id_appreciation,id_etu)

	,CONSTRAINT recoit_appreciation_appreciation_FK FOREIGN KEY (id_appreciation) REFERENCES public.appreciation(id_appreciation)
	,CONSTRAINT recoit_appreciation_etudiant0_FK FOREIGN KEY (id_etu) REFERENCES public.etudiant(id_etu)
)WITHOUT OIDS;



