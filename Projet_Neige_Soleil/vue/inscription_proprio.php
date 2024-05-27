
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("../controlleur/controlleur.class.php"); 
//instanciation de la classe controleur 
$unControleur = new Controleur(); 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérez et traitez les données du formulaire ici
    $unControleur->insertProprio($_POST);

    echo "Inscription réussie";
    header("Location: connexion.php");
    exit(); 
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/style.css">
    <title>Inscription</title>
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
    // Vérifier si l'utilisateur est un propriétaire
    if ($_SESSION['roles'] == 'proprio') {
        // Si c'est un propriétaire, afficher le bouton "Mettre son logement"
        echo '<button onclick="window.location.href=\'insert_logement.php\'">Mettre son logement</button>';
    }
} else {
    // Utilisateur non connecté, afficher le bouton de connexion et de mettre son logement
    echo '<button onclick="window.location.href=\'connexion.php\'">Connexion</button>';
    echo '<button onclick="window.location.href=\'inscription_proprio.php\'">Mettre son logement</button>';
}
?>
</div>
</header>
  <br>
    <center><h3>Bienvenue sur Neige et Soleil</h3></center>
<br>
<br>
<div class="inscription">
  <div class="formulaire">
<form class="row g-3" method="post" enctype="multipart/form-data">
<div class="col-12">
    <label  class="form-label">Nom</label>
    <input type="text" class="form-control" name="nom">
  </div>
  <div class="col-12">
    <label  class="form-label">Prénom</label>
    <input type="text" class="form-control" name="prenom">
  </div>
  <div class="col-md-6">
    <label for="inputEmail4" class="form-label">Email</label>
    <input type="text" class="form-control" id="inputEmail4" name="email">
  </div>
  <div class="col-12">
    <label  class="form-label">Téléphone</label>
    <input type="tel" class="form-control" name="telephone">
  </div>
  <div class="col-md-6">
    <label for="inputPassword4" class="form-label">Mot de Passe </label>
    <input type="password" class="form-control" id="inputPassword4" name="mdp">
  </div>
  <td><input type="hidden" name="roles" value="proprio"></td> 
  <div class="col-12">
    <button type="submit" class="btn btn-primary">Inscription</button>
  </div>
  <a href="connexion.php">Déja inscrit ? Connectez-vous ici!</a>
</form>
</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>
</html>