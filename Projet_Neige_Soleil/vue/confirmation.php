<?php
session_start();
require_once '../modele/modele.class.php';
require_once '../controlleur/controlleur.class.php';


//$controleur = new Controleur();
//$idReservation = $_GET['id_reservation']; 

//$detailsReservation = $controleur->getReservationDetails($idReservation);

?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/style.css">
  <title>Neige et Soleil</title>
</head>
<body>
<header  style="display: flex; justify-content: space-between;">
    <a href="../index.php"><img src="../img/NS.png" alt="Logo" width="50" height="50"></a>
    <div class="buttons">

    <?php
// Vérifier si l'utilisateur est connecté
if (isset($_SESSION['email'])) {
    // Utilisateur connecté
    echo '<button onclick="window.location.href=\'profils.php\'">Votre Profil</button>';
    echo '<button onclick="window.location.href=\'deconnexion.php\'">Déconnexion</button>';
    
}
?>

      
    </div>
  </header>
  <main>
<center><h1>Votre Réservation</h1></center>
<br><br>
<div class="confirmation"></div>

<?php
$idClient = $_SESSION['email'];
$controleur = new Controleur();
$controleur->setTable('reservation');
$reservations  = $controleur->selectReservation($idClient);

foreach ($reservations as $reservation){
echo'<p>Nom :'.($reservation['nom']??'Non défini').'</p>';
echo'<p>prenom :'.($reservation['prenom']??'Non défini').'</p>';
echo'<p>adresse :'.($reservation['adresse']??'Non défini').'</p>';
echo'<p>date debut :'.($reservation['date_debut']??'Non défini').'</p>';
echo'<p>date fin :'.($reservation['date_fin']??'Non défini').'</p>';
echo'<p>prix :'.($reservation['total_prix']??'Non défini').'</p>';
}


?>
</div>
</main>
</body>
</html>


