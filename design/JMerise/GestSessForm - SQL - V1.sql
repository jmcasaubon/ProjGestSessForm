#------------------------------------------------------------
#        Script MySQL.
#------------------------------------------------------------


#------------------------------------------------------------
# Table: gsf_stagiaire
#------------------------------------------------------------

CREATE TABLE gsf_stagiaire(
        id_stagiaire Int  Auto_increment  NOT NULL COMMENT "identifiant unique"  ,
        nom          Varchar (63) NOT NULL COMMENT "nom stagiaire"  ,
        prenom       Varchar (63) NOT NULL COMMENT "prénom stagiaire"  ,
        sexe         Varchar (7) NOT NULL COMMENT "sexe"  ,
        adresse      Varchar (255) COMMENT "n° et voie, complément d'adresse..."  ,
        cpostal      Varchar (15) COMMENT "code postal"  ,
        ville        Varchar (63) COMMENT "lieu de résidence"  ,
        telephone    Varchar (15) COMMENT "téléphone (fixe ou mobile)"  ,
        mail         Varchar (255) NOT NULL COMMENT "adresse de messagerie" 
	,CONSTRAINT gsf_stagiaire_AK UNIQUE (mail)
	,CONSTRAINT gsf_stagiaire_PK PRIMARY KEY (id_stagiaire)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: gsf_session
#------------------------------------------------------------

CREATE TABLE gsf_session(
        id_session Int  Auto_increment  NOT NULL COMMENT "identifiant unique"  ,
        intitule   Varchar (127) NOT NULL COMMENT "intitulé de la session"  ,
        date_debut Date NOT NULL COMMENT "date de démarrage de la session"  ,
        date_fin   Date NOT NULL COMMENT "Date d'achèvement de la session"  ,
        nb_places  Int NOT NULL COMMENT "Nombre maximal de stagiaires admis sur la session" 
	,CONSTRAINT gsf_session_PK PRIMARY KEY (id_session)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: gsf_categorie
#------------------------------------------------------------

CREATE TABLE gsf_categorie(
        id_categorie Int  Auto_increment  NOT NULL ,
        libelle      Varchar (63) NOT NULL COMMENT "intitulé de la catégorie" 
	,CONSTRAINT gsf_categorie_PK PRIMARY KEY (id_categorie)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: gsf_module
#------------------------------------------------------------

CREATE TABLE gsf_module(
        id_module      Int  Auto_increment  NOT NULL COMMENT "identifiant unique"  ,
        libelle        Varchar (63) NOT NULL COMMENT "intitulé du module"  ,
        duree_suggeree Int NOT NULL COMMENT "durée suggérée du module (en jours)"  ,
        id_categorie   Int NOT NULL
	,CONSTRAINT gsf_module_PK PRIMARY KEY (id_module)

	,CONSTRAINT gsf_module_gsf_categorie_FK FOREIGN KEY (id_categorie) REFERENCES gsf_categorie(id_categorie)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: programmer
#------------------------------------------------------------

CREATE TABLE programmer(
        id_module  Int NOT NULL COMMENT "identifiant unique"  ,
        id_session Int NOT NULL COMMENT "identifiant unique"  ,
        duree      Int NOT NULL COMMENT "nombre de jours prévus dans cette session" 
	,CONSTRAINT programmer_PK PRIMARY KEY (id_module,id_session)

	,CONSTRAINT programmer_gsf_module_FK FOREIGN KEY (id_module) REFERENCES gsf_module(id_module)
	,CONSTRAINT programmer_gsf_session0_FK FOREIGN KEY (id_session) REFERENCES gsf_session(id_session)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: participer
#------------------------------------------------------------

CREATE TABLE participer(
        id_session   Int NOT NULL COMMENT "identifiant unique"  ,
        id_stagiaire Int NOT NULL COMMENT "identifiant unique" 
	,CONSTRAINT participer_PK PRIMARY KEY (id_session,id_stagiaire)

	,CONSTRAINT participer_gsf_session_FK FOREIGN KEY (id_session) REFERENCES gsf_session(id_session)
	,CONSTRAINT participer_gsf_stagiaire0_FK FOREIGN KEY (id_stagiaire) REFERENCES gsf_stagiaire(id_stagiaire)
)ENGINE=InnoDB;

