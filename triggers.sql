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
