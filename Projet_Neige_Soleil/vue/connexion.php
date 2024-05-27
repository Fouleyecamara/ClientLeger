<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start(); // Assurez-vous que session_start() est au début du script
require_once("../controlleur/controlleur.class.php"); 

$unControleur = new Controleur(); 

if (isset($_POST['email'])) {
  
    $email = $_POST['email'];
    $mdp = $_POST['mdp'];
    $resultat = $unControleur->connexionUtilisateur($email, $mdp);

    if ($resultat) {
        // Stocker les informations de l'utilisateur dans la session
        $_SESSION['email'] = $email;
        $_SESSION['id_utilisateur'] = $unControleur->getIdClient($email); 
        $_SESSION['roles'] = $unControleur->getRoleUtilisateur($email);

        // Gestion de la redirection basée sur le rôle de l'utilisateur
        if ($_SESSION['roles'] === 'proprio') {
            header("Location: insert_logement.php");
            exit();
        }

        // Gérer la redirection en fonction des paramètres de l'URL
        if (isset($_GET['redirect']) && isset($_GET['id_logement'])) {
            // Construction de l'URL de redirection à partir des paramètres GET
            $redirectUrl = $_GET['redirect'] . "?id_logement=" . $_GET['id_logement'];
            header("Location: $redirectUrl");
            exit();
        }

        // Redirection par défaut si aucun paramètre de redirection n'est spécifié
        header("Location: ../index.php");
        exit();
    } else {
        echo "Erreur de connexion. Veuillez vérifier vos informations.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Connexion</title>
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
    <center><h3>Bienvenue sur Neige et Soleil</h3></center>
   

    <div class="container">
    <div class="row">
      <div class="col-md-6 offset-md-3">
        <h2 class="text-center text-dark mt-5">Connectez Vous</h2>
        <div class="card my-5">

          <form method ="post" class="card-body cardbody-color p-lg-5">

            <div class="text-center">
              <img src="../img/NS.png" class="img-fluid profile-image-pic img-thumbnail rounded-circle my-3"
                width="200px" alt="profile">
            </div>

                        <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Email</label>
                <input type="text" class="form-control" id="exampleInputEmail1" name="email">
            
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label"> Mot de Passe </label>
                <input type="password" class="form-control" id="exampleInputPassword1" name="mdp">
            </div>

            <div class="text-center"> <button type="submit" class="btn btn-primary" name="SeConnecter" >Se Connecter </button></div>
            <div id="emailHelp" class="form-text text-center mb-5 text-dark">Pas encore inscrit ?<a href="inscription_client.php" class="text-dark fw-bold">Enregistrez vous ici ! </a>
            </div>
          </form>
        </div>

      </div>
    </div>
  </div>
   
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>

</body>
</html>
