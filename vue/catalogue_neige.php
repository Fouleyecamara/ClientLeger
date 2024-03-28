
<?php
try {
    // Inclure le modèle et le contrôleur
    require_once '../modele/modele.class.php';
    require_once '../controlleur/controlleur.class.php';
?>
<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/styleNE.css">
    <title>Neige </title>
    <!-- Ajoutez ici vos liens vers les fichiers CSS si nécessaire -->
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
            
        }
        ?>
    </div>
  </header>
    <h2> Neige </h2>
    <center><p> Santa , tell me if you reaky there ... Prêt pour une escapade à la neige </p></center>
    <div class=reserve>
<?php
$controleur = new Controleur();
$controleur->setTable('logement');
$logementsNeige = $controleur->selectLogementByNeige();

foreach ($logementsNeige as $logement){
    echo '<div class="neige">';
    
    $photos = $controleur->selectPhotosByLogement($logement['id_logement']);

    // Afficher les photos
    if (!empty($photos)) {
        echo '<div id="carouselExample' . $logement['id_logement'] . '" class="carousel slide">';
        echo '<div class="carousel-inner">';

        $first = true;
        foreach ($photos as $key => $photo) {
            echo '<div class="carousel-item' . ($first ? ' active' : '') . '">';
            echo '<img src="../photo_logements/' . $photo['nom_photo'] . '" class="d-block mx-auto" style="width: 400px; height: 300px;" alt="Photo">';
            echo '</div>';
            $first = false;
        }

        echo '</div>';
        echo '<button class="carousel-control-prev" type="button" data-bs-target="#carouselExample' . $logement['id_logement'] . '" data-bs-slide="prev">';
        echo '<span class="carousel-control-prev-icon" aria-hidden="true"></span>';
        echo '<span class="visually-hidden">Previous</span>';
        echo '</button>';
        echo '<button class="carousel-control-next" type="button" data-bs-target="#carouselExample' . $logement['id_logement'] . '" data-bs-slide="next">';
        echo '<span class="carousel-control-next-icon" aria-hidden="true"></span>';
        echo '<span class="visually-hidden">Next</span>';
        echo '</button>';
        echo '</div>';
    } else {
        echo '<p>Aucune photo trouvée pour ce logement.</p>';
    }

    // Afficher le texte après les photos
    echo '<p><strong>Ville:</strong> ' . ($logement['ville'] ?? 'Non défini') . '</p>';
    echo '<p><strong>Type:</strong> ' . ($logement['type'] ?? 'Non défini') . '</p>';
    echo '<p><strong>Prix:</strong> ' . ($logement['prix'] ?? 'Non défini') . ' € par nuit </p>';

  // Récupération de l'ID du logement actuel à partir du tableau $logement
$idLogement = $logement['id_logement']; 

// Vérifier si l'utilisateur est connecté
if (isset($_SESSION['id_utilisateur'])) {
    // Si l'utilisateur est connecté, créer le lien de réservation directement
    $reservationLink = 'insert_reservation.php?id_logement=' . $idLogement;
} else {
    // Si l'utilisateur n'est pas connecté, créer un lien vers la page de connexion
    // Après la connexion, l'utilisateur sera redirigé vers la page de réservation
    $reservationLink = 'connexion.php?redirect=insert_reservation.php&id_logement=' . $idLogement;
}

// Afficher le lien sous forme d'un bouton
echo '<button onclick="window.location.href=\'' . $reservationLink . '\'" class="btn-reserver">Réserver</button>';

    echo '</div>'; // Fermez la div du logement
}

} catch (Exception $e) {
    echo '<p>Erreur lors de la récupération des logements : ' . $e->getMessage() . '</p>';
}
?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>

    