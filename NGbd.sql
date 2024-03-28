CREATE TABLE utilisateur(
   id_utilisateur INT AUTO_INCREMENT,
   nom VARCHAR(50) NOT NULL,
   prenom VARCHAR(50) NOT NULL,
   email VARCHAR(50) NOT NULL,
   telephone INT NOT NULL,
   mdp VARCHAR(255) NOT NULL,
   roles  enum('client','proprio','admin') NOT NULL,
   PRIMARY KEY(id_utilisateur)
);

CREATE TABLE proprietaire(
  id_utilisateur INT AUTO_INCREMENT,
   nom VARCHAR(50) NOT NULL,
   prenom VARCHAR(50) NOT NULL,
   email VARCHAR(50) NOT NULL,
   telephone INT NOT NULL,
   mdp VARCHAR(255) NOT NULL,
   roles  enum('proprio') NOT NULL,
   PRIMARY KEY(id_utilisateur)
);

CREATE TABLE client(
  id_utilisateur INT AUTO_INCREMENT,
   nom VARCHAR(50) NOT NULL,
   prenom VARCHAR(50) NOT NULL,
   email VARCHAR(50) NOT NULL,
   telephone INT NOT NULL,
   mdp VARCHAR(255) NOT NULL,
   roles  enum('client') NOT NULL,
   PRIMARY KEY(id_utilisateur)
);

CREATE TABLE gestionnaire(
    id_utilisateur INT AUTO_INCREMENT,
   nom VARCHAR(50) NOT NULL,
   prenom VARCHAR(50) NOT NULL,
   email VARCHAR(50) NOT NULL,
   telephone INT NOT NULL,
   mdp VARCHAR(255) NOT NULL,
   roles  enum('admin') NOT NULL,
   PRIMARY KEY(id_utilisateur)
);

CREATE TABLE logement(
   id_logement INT AUTO_INCREMENT,
   adresse VARCHAR(50) NOT NULL,
   ville VARCHAR(50) NOT NULL,
   type VARCHAR(50) NOT NULL,
   description VARCHAR(255) NOT NULL,
   prix DECIMAL(15,2) NOT NULL,
   capacite INT NOT NULL,
   date_dispo DATE,
   datefin_dispo DATE,
   saison enum ('soleil' , 'neige') NOT NULL,
   id_utilisateur INT NOT NULL,
   PRIMARY KEY(id_logement),
   FOREIGN KEY(id_utilisateur) REFERENCES proprietaire(id_utilisateur)
);

CREATE TABLE reservation(
   id_reservation INT AUTO_INCREMENT,
   date_debut DATE NOT NULL,
   date_fin DATE NOT NULL,
   statut VARCHAR(50) NOT NULL,
   id_logement INT NOT NULL,
   id_utilisateur INT NOT NULL,
   PRIMARY KEY(id_reservation),
   FOREIGN KEY(id_logement) REFERENCES logement(id_logement),
   FOREIGN KEY(id_utilisateur) REFERENCES client(id_utilisateur)
);

ALTER TABLE reservation ADD COLUMN totalPrix DECIMAL(10, 2);


CREATE TABLE commentaire(
   id_commentaire INT AUTO_INCREMENT,
   note INT NOT NULL,
   contenu VARCHAR(255) NOT NULL,
   date_com DATE NOT NULL,
   id_logement INT NOT NULL,
   PRIMARY KEY(id_commentaire),
   FOREIGN KEY(id_logement) REFERENCES logement(id_logement)
);

CREATE TABLE photo(
   id_photo INT AUTO_INCREMENT,
   nom_photo VARCHAR(255) NOT NULL,
   id_logement INT NOT NULL,
   PRIMARY KEY(id_photo),
   FOREIGN KEY(id_logement) REFERENCES logement(id_logement)
);
