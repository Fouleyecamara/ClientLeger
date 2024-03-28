<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/style.css">
  <title>Neige et Soleil</title>
</head>
<body>

  <header>
    <div class="buttons">

    <?php
        // Vérifier si l'utilisateur est connecté
        if (isset($_SESSION['email'])) {
            // Utilisateur connecté, afficher le bouton de déconnexion
            echo '<button onclick="window.location.href=\'vue/deconnexion.php\'">Déconnexion</button>';
        } else {
            // Utilisateur non connecté, afficher le bouton de connexion
            echo '<button onclick="window.location.href=\'vue/connexion.php\'">Connexion</button>';
            echo '<button onclick="window.location.href=\'vue/inscription_proprio.php\'">Mettre son logement</button>';
        }
        ?>
      
    </div>
  </header>

  <main>
    <div class="welcome-message">
      <h1>Bienvenue Chez Neige et Soleil</h1>

     
    </div>
    <button onclick="window.location.href='vue/recherche.php'">Rechercher une location</button>
    
    <div class="image-container">
      <a href="vue/catalogue_neige.php">
        <img src="img/neige.jpg" alt="Image 1" width="200px" height="200px">
      </a>
      <a href="vue/catalogue_soleil.php">
        <img src="img/soleil.jpg.avif" alt="Image 2" width="200px" height="200px">
      </a>
    </div>
    <?php
        // Vérifier si l'utilisateur est connecté
        if (isset($_SESSION['email'])) {
            // Utilisateur connecté, afficher le bouton de déconnexion
            echo '<button onclick="window.location.href=\'vue/profils.php\'">Votre Profil</button>';
        } else {
           
        }
        ?>

  </main>

  <footer>
    <div class="footer-content">
      <p>Contact</p>
      <p>Mentions légales</p>
    </div>
  </footer>

</body>
</html>


