<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Après la connexion à la base de données
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);


session_start();
require_once '../controlleur/controlleur.class.php'; // Assurez-vous que le chemin est correct

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $adresse = $_POST['adresse'];
    $ville = $_POST['ville'];
    $type = $_POST['type'];
    $description = $_POST['description'];
    $prix = $_POST['prix'];
    $capacite = $_POST['capacite'];
    $date_dispo=$_POST['date_dispo'];
    $datefin_dispo=$_POST['datefin_dispo'];
   $saison = isset($_POST['saison']) ? $_POST['saison'] : '';


        $donnees = [
            'adresse' => $adresse,
            'ville' => $ville,
            'type' => $type,
            'description' => $description,
            'prix' => $prix,
            'capacite' => $capacite,
            'date_dispo'=>$date_dispo,
            'datefin_dispo'=>$datefin_dispo,
            'saison' => $saison,
            ':id_utilisateur'=> $idUtilisateur
        ];

        // Instanciez le contrôleur et insérez les données dans la base de données
        $controleur = new Controleur();
        $controleur->setTable('logement'); // Assurez-vous que le nom de la table est correct
        $controleur->insertLogement($donnees, $_FILES['photos']);
        header('Location: select_logement.php');
        exit;
}
?>



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    

    <title>Mettre son logement</title>

</head>
<body>
<header  style="display: flex; justify-content: space-between;">
    <a href="../index.php"><img src="../img/NS.png" alt="Logo" width="50" height="50"></a>
    <div class="buttons">
      <button onclick="window.location.href='deconnexion.php'">Déconnexion</button>
      <button onclick="window.location.href='profils.php'">Mon Profil</button>
    </div>
  </header>
<main>
<h3> Vous souhaitez faire louée votre logement ? <br>
N'hésitez pas à remplir les informations ci dessous afin de le mettre en location !</h3>


    <div class="insert_logement">
        <div class="insert">
    <form method="post" enctype="multipart/form-data" class="insert_logement">
        <fieldset>
            <legend>Informations sur le logement</legend>

        
        <label for="adresse">Adresse :</label>
        <input type="text" id="adresse" name="adresse" required>

        <label for="ville">Ville :</label>
        <input type="text" id="ville" name="ville" required>

        <label for="type">Type :</label>
        <input type="text" id="type" name="type" required>

        <label for="description">Description :</label>
        <textarea id="description" name="description" required></textarea>

        <label for="prix">Prix :</label>
        <input type="number" id="prix" name="prix" required>

        <label for="capacite">Capacité :</label>
        <input type="number" id="capacite" name="capacite" required>
        </div>
        <div class="insert">
        <div class="mb-3">
            <label for="date_dispo" class="form-label">Date de disponibilité :</label>
            <input type="date" class="form-control" id="date_dispo" name="date_dispo" required>
        </div>

        <div class="mb-3">
            <label for="datefin_dispo" class="form-label">Date de fin de disponibilité :</label>
            <input type="date" class="form-control" id="datefin_dispo" name="datefin_dispo" required>
        </div>

        
        </fieldset>
        <fieldset>
    <legend>Types de location</legend>

    <label>
        <input type="checkbox" name="saison" value="Neige"> Location à la neige
    </label>

    <label>
        <input type="checkbox" name="saison" value="Soleil"> Location au soleil
    </label>
</fieldset>




  <fieldset>
            <legend>Photos</legend>

            <div class="mb-3" id="photoInputsContainer">
                <label for="formFileMultiple" class="form-label">Télécharger une ou plusieurs photos</label>
                <input class="form-control" type="file" name="photos[]" accept="image/*" multiple>
            </div>

            <button type="button" onclick="ajouterChampPhoto()">Ajouter une photo</button>
        </fieldset>

<br>
<br>
<br>
</div>
<button class="ajout" type="submit">Ajouter Logement</button>

</form>

</div>

</main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script>
        function ajouterChampPhoto() {
            var container = document.getElementById('photoInputsContainer');
            var newInput = document.createElement('input');
            newInput.className = 'form-control';
            newInput.type = 'file';
            newInput.name = 'photos[]';
            newInput.accept = 'image/*';
            container.appendChild(newInput);
        }
    </script> 
</body>
</html>