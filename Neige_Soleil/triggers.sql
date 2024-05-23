     /*Trigger qui permet de faire des insert dans ses table héritante**/


DROP TRIGGER IF EXISTS insert_client;
DELIMITER //
CREATE TRIGGER insert_client
BEFORE INSERT ON client
FOR EACH ROW
BEGIN
    IF NEW.id_utilisateur IS NULL OR NEW.id_utilisateur IN (SELECT id_utilisateur FROM utilisateur) OR NEW.id_utilisateur = 0 THEN
        SET NEW.id_utilisateur = IFNULL((SELECT id_utilisateur FROM utilisateur WHERE id_utilisateur >= ALL(SELECT id_utilisateur FROM utilisateur)), 0) + 1;
    END IF;
    INSERT INTO utilisateur VALUES (NEW.id_utilisateur, NEW.nom, NEW.prenom, NEW.email , NEW.telephone , NEW.mdp , NEW.roles);
END //
DELIMITER ;

DROP TRIGGER IF EXISTS insert_proprio;
DELIMITER //
CREATE TRIGGER insert_proprio
BEFORE INSERT ON proprietaire
FOR EACH ROW
BEGIN
    IF NEW.id_utilisateur IS NULL OR NEW.id_utilisateur IN (SELECT id_utilisateur FROM utilisateur) OR NEW.id_utilisateur = 0 THEN
        SET NEW.id_utilisateur = IFNULL((SELECT id_utilisateur FROM utilisateur WHERE id_utilisateur >= ALL(SELECT id_utilisateur FROM utilisateur)), 0) + 1;
    END IF;
    INSERT INTO utilisateur VALUES (NEW.id_utilisateur, NEW.nom, NEW.prenom, NEW.email , NEW.telephone , NEW.mdp , NEW.roles);
END //
DELIMITER ;

DROP TRIGGER IF EXISTS insert_gestionnaire;
DELIMITER //
CREATE TRIGGER insert_gestionnaire
BEFORE INSERT ON gestionnaire
FOR EACH ROW
BEGIN
    IF NEW.id_utilisateur IS NULL OR NEW.id_utilisateur IN (SELECT id_utilisateur FROM utilisateur) OR NEW.id_utilisateur = 0 THEN
        SET NEW.id_utilisateur = IFNULL((SELECT id_utilisateur FROM utilisateur WHERE id_utilisateur >= ALL(SELECT id_utilisateur FROM utilisateur)), 0) + 1;
    END IF;
    INSERT INTO utilisateur VALUES (NEW.id_utilisateur, NEW.nom, NEW.prenom, NEW.email , NEW.telephone , NEW.mdp , NEW.roles);
END //
DELIMITER ;

/****** trigger qui calcule le nombre de nuit pour une location ******/
DELIMITER //
CREATE TRIGGER before_reservation_insert
BEFORE INSERT ON reservation
FOR EACH ROW
BEGIN
    DECLARE nbJours INT;
    DECLARE prixParNuit DECIMAL(10, 2);
    SET nbJours = DATEDIFF(NEW.date_fin, NEW.date_debut);
    SELECT prix INTO prixParNuit FROM logement WHERE id_logement = NEW.id_logement;
    SET NEW.total_prix = nbJours * prixParNuit;
END;
//
DELIMITER ;

/***** Trigger pour que les update fait dans les table client et proprietaire soit automatique dans utilisateur aussi ***/


DELIMITER //
CREATE TRIGGER upd_client_user
AFTER UPDATE ON client
FOR EACH ROW
BEGIN
    UPDATE utilisateur
    SET nom = NEW.nom,
        prenom = NEW.prenom,
        email = NEW.email,
        telephone = NEW.telephone,
        mdp = NEW.mdp,
        roles = NEW.roles
    WHERE id_utilisateur = NEW.id_utilisateur;
END//
DELIMITER ;

DELIMITER //
CREATE TRIGGER upd_prorpio_user
AFTER UPDATE ON proprietaire
FOR EACH ROW
BEGIN
    UPDATE utilisateur
    SET nom = NEW.nom,
        prenom = NEW.prenom,
        email = NEW.email,
        telephone = NEW.telephone,
        mdp = NEW.mdp,
        roles = NEW.roles
    WHERE id_utilisateur = NEW.id_utilisateur;
END//

DELIMITER ;


