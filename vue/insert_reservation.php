<?php
/***si l'utilsateur est connecter il se dirrege vers le formulaire avec l'id du logement. 
si l'utilsateur n'est pas connecter il se dirrigd simplement sur la page se connecter***/  
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Après la connexion à la base de données
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);


session_start();

if (!isset($_SESSION['id_utilisateur'])) {
    // Si l'utilisateur n'est pas connecté, redirigez-le vers la page de connexion
    header("Location: connexion.php?redirect=insert_reservation.php&id_logement=" . $_GET['id_logement']);
    exit();
}


require_once '../controlleur/controlleur.class.php'; // Assurez-vous que le chemin est correct

$controleur = new Controleur();

if (isset($_SESSION['id_utilisateur']) && isset($_GET['id_logement'])) {
    $idUtilisateur = $_SESSION['id_utilisateur']; // Récupérer l'ID de l'utilisateur de la session
    $idLogement = $_GET['id_logement'];           // Récupérer l'ID du logement de l'URL

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $dateDebut = $_POST['date_debut'];       
        $dateFin = $_POST['date_fin'];         
    
        // Vérifier la disponibilité avant de faire la réservation
        if ($controleur->verifierDisponibilite($idLogement, $dateDebut, $dateFin)) {
            // Si disponible, effectuez la réservation et obtenez l'ID de réservation
            $idReservation = $controleur->insertReservation($dateDebut, $dateFin, $idLogement, $idUtilisateur);
        
            // Redirigez vers la page de confirmation avec l'ID de la réservation
            header("Location: confirmation.php?id_reservation=" . $idReservation);
            exit(); 
        } else {
            // Si non disponible, affichez un message d'erreur
            echo "<p>Erreur : Le logement n'est pas disponible pour les dates sélectionnées.</p>";
        }
    
   
}
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réserver un Logement</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <!-- Ici, ajoutez le même contenu d'en-tête que sur votre page de recherche de logement -->
    </header>

    <main class="container">
        <h2>Réserver un Logement</h2>
        <form action="insert_reservation.php?id_logement=<?php echo $idLogement; ?>" method="post">
            <input type="hidden" name="id_logement" value="<?php echo $idLogement; ?>">

            <label for="date_debut">Date de début:</label>
            <input type="date" id="date_debut" name="date_debut" required>

            <label for="date_fin">Date de fin:</label>
            <input type="date" id="date_fin" name="date_fin" required>

            <button type="submit" class="btn btn-primary">Réserver</button>
        </form>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>


