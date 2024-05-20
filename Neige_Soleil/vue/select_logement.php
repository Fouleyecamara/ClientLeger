<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
 

    // Inclure le modèle et le contrôleur
    require_once '../modele/modele.class.php';
    require_once '../controlleur/controlleur.class.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/style.css">
    <title>Mon Logement</title>
    <!-- Ajoutez ici vos liens vers les fichiers CSS si nécessaire -->
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
  <center> <h2>Récaputilatif de votre logement </h2> </center> 
<?php
   
   try{
    $idProprietaire =  $_SESSION['email'];  //recupere l'id du proprio connecter;
    
    $controleur = new Controleur();
    $controleur->setTable('logement');
 
    $logements = $controleur->selectLogement($idProprietaire); // logements selon le proprio connecter 
    echo '<div class="select_logement">';
   
   
    
 foreach ($logements as $logement){
        // Afficher les photos
        $photos = $controleur->selectPhotosByLogement($logement['id_logement']);
        if (!empty($photos)) {
            echo '<div id="carouselExample" class="carousel slide" data-bs-ride="carousel">';
            echo '<div class="carousel-inner">';
           
            $first = true;
            foreach ($photos as $key => $photo) 
            {
                echo '<div class="carousel-item' . ($first ? ' active' : '') . '">';
                echo '<img src="../photo_logements/' . $photo['nom_photo'] . '" class="d-block mx-auto" style="width: 400px; height: 300px;" alt="Photo">';
                echo '</div>';
                $first = false;
            }
           
            echo '</div>';
            echo '<button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">';
            echo '<span class="carousel-control-prev-icon" aria-hidden="true"></span>';
            echo '<span class="visually-hidden">Previous</span>';
            echo '</button>';
            echo '<button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">';
            echo '<span class="carousel-control-next-icon" aria-hidden="true"></span>';
            echo '<span class="visually-hidden">Next</span>';
            echo '</button>';
            echo '</div>';
        } else {
            echo '<p>Aucune photo trouvée pour ce logement.</p>';
        }
 
        
        echo '<div class="select">';
        echo '<p><strong>Adresse: &ensp; </strong> ' . ($logement['adresse'] ?? 'Non défini') . '</p>';
        echo '<p><strong>Ville: &ensp; </strong> ' . ($logement['ville'] ?? 'Non défini') . '</p>';
        echo '<p><strong>Type: &ensp; </strong> ' . ($logement['type'] ?? 'Non défini') . '</p>';
        echo '<p><strong>Description:&ensp;  </strong> ' . ($logement['description'] ?? 'Non défini') . '</p>';
        echo '<p><strong>Prix par nuit: &ensp; </strong> ' . ($logement['prix'] ?? 'Non défini') .'€</p>';
        echo '<p><strong>Capacité:&ensp;  </strong> ' . ($logement['capacite'] ?? 'Non défini') . '</p>';
        echo '<p><strong>Date de disponibilité:&ensp;  </strong>' . ($logement['date_dispo'] ?? 'Non défini') .'</p>';
        echo '<p><strong>Date de Fin disponibilité:&ensp;  </strong>' . ($logement['datefin_dispo'] ?? 'Non défini') .'</p>';
        echo '<p><strong>Saison:&ensp;  </strong> ' . ($logement['saison'] ?? 'Non défini') . '</p>';
        echo '<button onclick="window.location.href=\'modification_logement.php?id_logement=' . $logement['id_logement'] . '\'">Modifier ce logement</button>';

        echo '</div>';
    }

   
    echo '</div>';
   
 
}catch (Exception $e) {
    echo '<p>Erreur lors de la récupération des logements : ' . $e->getMessage() . '</p>';
}

?>
 
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>