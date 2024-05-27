

<!DOCTYPE html>
<html>
<head>
    <title>Recherche de Logement</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/style_recherche.css">
</head>
<body>
<header  style="display: flex; justify-content: space-between;">
    <a href="../index.php"><img src="../img/NS.png" alt="Logo" width="50" height="50"></a>
    <div class="buttons">

    <?php
    session_start();
    // Vérifier si l'utilisateur est connecté
    if (isset($_SESSION['email'])) {
        // Utilisateur connecté, afficher le bouton de déconnexion
        echo '<button onclick="window.location.href=\'deconnexion.php\'">Déconnexion</button>';
    } else {
       
    }
    ?>
 </header>
 <main>
    <div class = "form_recherche">
<form action="" method="post">
    <tr>
        <td> Destination : </td>
    <input type="text" name="ville" placeholder="Rechercher une destination">
</tr>
     <tr>
        <td> Arivée :  </td>
        <input type="date" name="date_debut" placeholder="Quand ? ">
        </tr>
        <tr>Départ :  </td>   
        <input type="date" name="date_fin" placeholder="Quand ?">
</tr>
        <input type="submit" name="Rechercher" value="Rechercher">
   
 </form>
</div>
<div class=annonces>
<?php


require_once("../controlleur/controlleur.class.php");

// Instanciation du contrôleur
$unControleur = new Controleur();
// formulaire vide 
$ville = "";
$dateDebut = "";
$dateFin = "";

     // Vérifier si le formulaire a été soumis
     if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Récupérer les valeurs du formulaire
        $ville = $_POST["ville"];
        $dateDebut = $_POST["date_debut"];
        $dateFin = $_POST["date_fin"];

       // Formater les dates en "JJ-MM-YYYY"
$date_debut_formatee = date("d-m-Y", strtotime($dateDebut));
$date_fin_formatee = date("d-m-Y", strtotime($dateFin));

$unControleur->rechercheLogement($ville,  $dateDebut, $dateFin);
     }

// Traiter la soumission du formulaire
  $controleur = new Controleur();
  $controleur->setTable('logement');
  $resultats = $controleur->rechercheLogement($ville, $dateDebut, $dateFin);
    
        foreach ($resultats as $ligne){

            echo '<div class="recherche">';


            $photos = $controleur->selectPhotosByLogement($ligne['id_logement']);
            
            // Afficher les photos
  if (!empty($photos)) {
      echo '<div id="carouselExample' . $ligne['id_logement'] . '" class="carousel slide">';
      echo '<div class="carousel-inner">';

      $first = true;
      foreach ($photos as $key => $photo) {
          echo '<div class="carousel-item' . ($first ? ' active' : '') . '">';
          echo '<img src="../photo_logements/' . $photo['nom_photo'] . '" class="d-block mx-auto" style="width: 400px; height: 300px;" alt="Photo">';
          echo '</div>';
          $first = false;
      }
      echo '</div>';
      echo '<button class="carousel-control-prev" type="button" data-bs-target="#carouselExample' . $ligne['id_logement'] . '" data-bs-slide="prev">';
      echo '<span class="carousel-control-prev-icon" aria-hidden="true"></span>';
      echo '<span class="visually-hidden">Previous</span>';
      echo '</button>';
      echo '<button class="carousel-control-next" type="button" data-bs-target="#carouselExample' . $ligne['id_logement'] . '" data-bs-slide="next">';
      echo '<span class="carousel-control-next-icon" aria-hidden="true"></span>';
      echo '<span class="visually-hidden">Next</span>';
      echo '</button>';
      echo '</div>';
  } else {
      echo '<p>Aucune photo trouvée pour ce logement.</p>';
  }




           
           echo '<p><strong>Ville:</strong> ' . ($ligne['ville'] ?? 'Non défini') . '</p>';
           echo '<p><strong>Type:</strong> ' . ($ligne['type'] ?? 'Non défini') . '</p>';
           echo '<p><strong>Prix:</strong> ' . ($ligne['prix'] ?? 'Non défini') . ' € par nuit </p>';
           echo '<p><strong>Saison:</strong> ' . ($ligne['saison'] ?? 'Non défini') . '</p>';
       
          
           $idLogement = $ligne['id_logement']; 

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
     


?>
</main>
   </div>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</body>
</html>