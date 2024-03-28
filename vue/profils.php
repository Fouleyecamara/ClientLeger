<?php
session_start();
require_once '../modele/modele.class.php';
    require_once '../controlleur/controlleur.class.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/style.css">
  <title> Mon Profils</title>  
</head>
<body>
    <header>
    <div class="buttons">

    <?php
    // Vérifier si l'utilisateur est connecté
    if (isset($_SESSION['email'])) {
        // Utilisateur connecté, afficher le bouton de déconnexion
        echo '<button onclick="window.location.href=\'deconnexion.php\'">Déconnexion</button>';
    } else {
       
    }
    ?>
    </div>
    </header>

    <?php 
$controleur = new Controleur();
$controleur->setTable('utilisateur');

$utilisateur = $controleur->UtilisateurConnecter(); // Récupérer les informations de l'utilisateur connecté

echo '<div class="select_logement">';

// Vérifier si l'utilisateur est connecté avant d'afficher le profil
if ($utilisateur) {
    // Afficher les informations du profil de l'utilisateur
    echo '<h1>Profil de ' . $utilisateur['nom'] . ' ' . $utilisateur['prenom'] . '</h1>';
    echo '<p>Nom: ' . $utilisateur['nom'] . '</p>';
    echo '<p>Prénom: ' . $utilisateur['prenom'] . '</p>';
    echo '<p>Email: ' . $utilisateur['email'] . '</p>';
    echo '<p>Télephone:' . $utilisateur['telephone'] . '</p>';
} else {
    // Si l'utilisateur n'est pas connecté, afficher un message d'erreur ou rediriger vers la page de connexion
    echo 'Utilisateur non connecté';
}

echo '</div>';
?>

    </main>
    <footer>

    </footer>
</body>