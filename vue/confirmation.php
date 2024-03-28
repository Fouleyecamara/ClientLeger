<?php

require_once '../controlleur/controlleur.class.php';

$controleur = new Controleur();


$idReservation = $_GET['id_reservation']; 

$detailsReservation = $controleur->getReservationDetails($idReservation);

// Utilisez ici les informations récupérées pour les afficher
?>
<h1>Confirmation de Réservation</h1>
<p>Nom: <?php echo $detailsReservation['client']['nom']; ?></p>
<p>Prénom: <?php echo $detailsReservation['client']['prenom']; ?></p>
<p>Logement: <?php echo $detailsReservation['logement']['adresse'] . ", " . $detailsReservation['logement']['ville']; ?></p>
<p>Date de début: <?php echo $detailsReservation['reservation']['date_debut']; ?></p>
<p>Date de fin: <?php echo $detailsReservation['reservation']['date_fin']; ?></p>
<p>Prix Total: <?php echo $detailsReservation['reservation']['totalPrix']; ?> €</p>
