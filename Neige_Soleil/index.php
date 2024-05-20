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

<header  style="display: flex; justify-content: space-between;">
    <a href="index.php"><img src="img/NS.png" alt="Logo" width="50" height="50"></a>
    <div class="buttons">

    <?php
// Vérifier si l'utilisateur est connecté
if (isset($_SESSION['email'])) {
    // Utilisateur connecté
    echo '<button onclick="window.location.href=\'vue/profils.php\'">Votre Profil</button>';
    echo '<button onclick="window.location.href=\'vue/deconnexion.php\'">Déconnexion</button>';
    // Vérifier si l'utilisateur est un propriétaire
    if ($_SESSION['roles'] == 'proprio') {
        // Si c'est un propriétaire, afficher le bouton "Mettre son logement"
        echo '<button onclick="window.location.href=\'vue/insert_logement.php\'">Mettre son logement</button>';
    }
} else {
    // Utilisateur non connecté, afficher le bouton de connexion et de mettre son logement
    echo '<button onclick="window.location.href=\'vue/connexion.php\'">Connexion</button>';
    echo '<button onclick="window.location.href=\'vue/inscription_proprio.php\'">Mettre son logement</button>';
}
?>

      
    </div>
  </header>

  <main>
    <div class="welcome-message">
      <h1>Bienvenue Chez Neige et Soleil</h1>
      <br>

      <p> Venez vous détendre en bord de plages après une séance intense de JetSki , ou bien préférez vous ski près du Mont Blanc et deguster une fondue après tant d'effort</p>
      <br><br>
      
      <p> Avec Neige et Soleil vous pouvez vous retrouvez dans les deux cas !!  , nous vous proposons une large selection de logement que vous allez ADORER ! </p>
   
    </div>
    <button onclick="window.location.href='vue/recherche.php'">Rechercher une location</button>
    <br>
    <br>
    <div class="catalogue">
  <div class="image-container">
    <a href="vue/catalogue_neige.php">
      <img src="img/neige.jpg" alt="Image 1" width="500px" height="500px" title="Découvrez notre collection de vacances à la montagne !">
    </a>
    <a href="vue/catalogue_soleil.php">
      <img src="img/soleil.jpg.avif" alt="Image 2" width="500px" height="500px" title="Explorez notre sélection de destinations ensoleillées !">
    </a>
  </div>
</div>

   

  </main>

  

</body>
</html>


