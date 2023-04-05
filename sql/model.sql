
------------------------------------------------------------
--        A ADAPTER AVEC NOTRE BASE DE DONNEES
------------------------------------------------------------


------------------------------------------------------------
--        Script Postgre 
------------------------------------------------------------
DROP TABLE IF EXISTS client CASCADE;
DROP TABLE IF EXISTS Produit CASCADE;
DROP TABLE IF EXISTS Commande CASCADE;
DROP TABLE IF EXISTS Est_Constitue CASCADE;
------------------------------------------------------------
-- Table: client
------------------------------------------------------------
CREATE TABLE client(
	id_client       SERIAL NOT NULL ,
	nom             VARCHAR (50) NOT NULL ,
  prenom          VARCHAR (50) NOT NULL,
  email           VARCHAR (50) NOT NULL,
  passwordUser        VARCHAR (100) NOT NULL,
	adresse_ville   VARCHAR (50) NOT NULL ,
	code_postale    INT  NOT NULL  ,
	CONSTRAINT client_PK PRIMARY KEY (id_client)
)WITHOUT OIDS;


------------------------------------------------------------
-- Table: Produit
------------------------------------------------------------
CREATE TABLE Produit(
	reference        INT  NOT NULL ,
	prix             INT   ,
	designatiion     VARCHAR (50)  ,
	quantite_stock   INT   ,
	tva              FLOAT  NOT NULL  ,
	CONSTRAINT Produit_PK PRIMARY KEY (reference)
)WITHOUT OIDS;


------------------------------------------------------------
-- Table: Commande
------------------------------------------------------------
CREATE TABLE Commande(
	numero      SERIAL NOT NULL ,
	date        DATE  NOT NULL ,
	id_client   INT  NOT NULL  ,
	CONSTRAINT Commande_PK PRIMARY KEY (numero)

	,CONSTRAINT Commande_client_FK FOREIGN KEY (id_client) REFERENCES public.client(id_client)
)WITHOUT OIDS;


------------------------------------------------------------
-- Table: Est Constitué
------------------------------------------------------------
CREATE TABLE Est_Constitue(
	reference               INT  NOT NULL ,
	numero                  INT  NOT NULL ,
	nombre_produit_achete   INT  NOT NULL  ,
	CONSTRAINT Est_Constitue_PK PRIMARY KEY (reference,numero)

	,CONSTRAINT Est_Constitue_Produit_FK FOREIGN KEY (reference) REFERENCES public.Produit(reference)
	,CONSTRAINT Est_Constitue_Commande0_FK FOREIGN KEY (numero) REFERENCES public.Commande(numero)
)WITHOUT OIDS;



