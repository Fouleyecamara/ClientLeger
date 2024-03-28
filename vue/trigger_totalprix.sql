DELIMITER //
CREATE TRIGGER before_reservation_insert
BEFORE INSERT ON reservation
FOR EACH ROW
BEGIN
    DECLARE nbJours INT;
    DECLARE prixParNuit DECIMAL(10, 2);

    -- Calculer le nombre de jours entre date_debut et date_fin
    SET nbJours = DATEDIFF(NEW.date_fin, NEW.date_debut);

    -- Récupérer le prix par nuit pour le logement réservé
    SELECT prix INTO prixParNuit FROM logement WHERE id_logement = NEW.id_logement;

    -- Définir le prix total pour la nouvelle ligne de réservation
    SET NEW.totalPrix = nbJours * prixParNuit;
END;
//
DELIMITER ;
