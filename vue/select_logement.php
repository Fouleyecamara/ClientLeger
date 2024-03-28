<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
 
try {
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
    <title>Votre Titre</title>
    <!-- Ajoutez ici vos liens vers les fichiers CSS si nécessaire -->
</head>
<body>
  <center> <h2>Récaputilatif de votre logement </h2> </center> 
<?php
 
    // Instancier le contrôleur
    $controleur = new Controleur();
    $controleur->setTable('logement');
 
    $logements = $controleur->selectAllLogements();
    echo '<div class="select_logement">';
   
    // Afficher le dernier logement
    if (!empty($logements)) {
        $dernierLogement = end($logements); // Permet d'obtenir la dernière entrée dans la base de données
 
        // Afficher les photos
        $photos = $controleur->selectPhotosByLogement($dernierLogement['id_logement']);
        if (!empty($photos)) {
            echo '<div id="carouselExample" class="carousel slide" data-bs-ride="carousel">';
            echo '<div class="carousel-inner">';
           
            $first = true;
            foreach ($photos as $key => $photo) {
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
 
        // Afficher les informations du logement après les photos
        echo '<div class="select">';
        echo '<p><strong>Adresse: &ensp; </strong> ' . ($dernierLogement['adresse'] ?? 'Non défini') . '</p>';
        echo '<p><strong>Ville: &ensp; </strong> ' . ($dernierLogement['ville'] ?? 'Non défini') . '</p>';
        echo '<p><strong>Type: &ensp; </strong> ' . ($dernierLogement['type'] ?? 'Non défini') . '</p>';
        echo '<p><strong>Description:&ensp;  </strong> ' . ($dernierLogement['description'] ?? 'Non défini') . '</p>';
        echo '<p><strong>Prix par nuit: &ensp; </strong> ' . ($dernierLogement['prix'] ?? 'Non défini') .'€</p>';
        echo '<p><strong>Capacité:&ensp;  </strong> ' . ($dernierLogement['capacite'] ?? 'Non défini') . '</p>';
        echo '<p><strong>Date de disponibilité:&ensp;  </strong>' . ($dernierLogement['date_dispo'] ?? 'Non défini') .'</p>';
        echo '<p><strong>Date de Fin disponibilité:&ensp;  </strong>' . ($dernierLogement['datefin_dispo'] ?? 'Non défini') .'</p>';
        echo '<p><strong>Saison:&ensp;  </strong> ' . ($dernierLogement['saison'] ?? 'Non défini') . '</p>';
        echo '</div>';
    }
    echo '</div>';
   
 
}catch (Exception $e) {
    echo '<p>Erreur lors de la récupération des logements : ' . $e->getMessage() . '</p>';
}
?>
<a href="profils.php">Vers votre profil</a>
 
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>