 <?php
session_start();
require_once '../modele/modele.class.php';
require_once '../controlleur/controlleur.class.php';

$controleur = new Controleur();
$controleur->setTable('utilisateur');
$utilisateur = $controleur->UtilisateurConnecter(); 

?>
<?php
    
    if ($_SESSION['roles'] == 'proprio') {
        $modification_url = 'modification_proprio.php';
    } else {
        $modification_url = 'modification_client.php';
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
  <link rel="stylesheet" href="../css/style.css">
  <title>Mon Profil</title> 


  <style>

    @import url(https://fonts.googleapis.com/css?family=Dancing+Script);

    .main {
    margin-top: 9%;
    margin-left: 29%;
    font-size: 28px;
    padding: 0 10px;
    width: 58%;
}

.main h2 {
    color: #333;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    font-size: 24px;
    margin-bottom: 10px;
}

.main .card {
    background-color: #fff;
    border-radius: 18px;
    box-shadow: 1px 1px 8px 0 grey;
    height: auto;
    margin-bottom: 20px;
    padding: 20px 0 20px 50px;
}

.main .card table {
    border: none;
    font-size: 16px;
    height: 270px;
    width: 80%;
}
.edit {
    position: absolute;
    color: #e7e7e8;
    right: 14%;
}
  </style> 
</head>
<body>
    <header  style="display: flex; justify-content: space-between;">
    <a href="../index.php"><img src="../img/NS.png" alt="Logo" width="50" height="50"></a>
        <div class="buttons">
            <?php
            // Vérifier si l'utilisateur est connecté
            if (isset($_SESSION['email'])) {
                // Utilisateur connecté, afficher le bouton de déconnexion
                echo '<button onclick="window.location.href=\'deconnexion.php\'">Déconnexion</button>';

            } else {
                // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
                header("Location: connexion.php");
                exit();
            }
           
?>

            
        </div>
    </header>

    <div class="main">
    <h2>Mon Profil</h2>
    <div class="card">
        <div class="card-body">
        <a href="<?php echo $modification_url; ?>" class="edit"><i class="fa fa-pen fa-xs"></i></a>
            <table>
                <tbody>
                    <tr>
                        <td>Nom</td>
                        <td>:</td>
                        <td><?php echo $utilisateur['nom']; ?></td>
                    </tr>
                    <tr>
                        <td>Prenom</td>
                        <td>:</td>
                        <td><?php echo $utilisateur['prenom']; ?></td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td>:</td>
                        <td><?php echo $utilisateur['email']; ?></td>
                    </tr>
                    <tr>
                        <td>Téléphone</td>
                        <td>:</td>
                        <td><?php echo $utilisateur['telephone']; ?></td>
                    </tr>
                    
                </tbody>
            </table>
        </div>
    </div>

    <?php
       if ($_SESSION['roles'] == 'proprio') {
        // Si c'est un propriétaire, afficher le bouton "Mettre son logement"
        echo '<button onclick="window.location.href=\'select_logement.php\'"> Mon Logement </button>';
    }
else{
        echo '<button onclick="window.location.href=\'confirmation.php\'">Ma Réservation</button>';

}
?>

</div>

</body>


</html>