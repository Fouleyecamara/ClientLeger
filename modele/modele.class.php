<?php

    class Modele {
        private $unPDO;
        private $table;
       

        public function  __construct (){
            try{
                $url ="mysql:host=localhost;dbname=NeigeSoleil"; 
                $user = "root"; 
                $mdp = ""; // PC : $mdp =""; 
                $this->unPDO = new PDO ($url, $user, $mdp); 
            }
            catch (PDOException $exp){
                echo "<br> Erreur de connexion à la BDD"; 
            }
        }
        public function setTable ($table){
            $this->table = $table;
        }
        public function getTable(){
            return $this->table;
        }
        /******************* GESTION DES LOGEMENTS *****************/

        public function getIdUtilisateurByEmail($email)
{
    $requete = "select id_utilisateur from proprietaire where email = :email;";
    $stmt = $this->unPDO->prepare($requete);
    $stmt->execute(array(":email" => $email));
    $resultat = $stmt->fetch(PDO::FETCH_ASSOC);

    return $resultat['id_utilisateur'];
}


        public function insertLogement($tab , $photos)

        {   
            try {
                $this->unPDO->beginTransaction();
            
                $requete = "insert into  logement (adresse, ville, type, description, prix, capacite, date_dispo, datefin_dispo, saison, id_utilisateur) 
                VALUES (:adresse, :ville, :type, :description, :prix, :capacite, :date_dispo, :datefin_dispo, :saison, :id_utilisateur);";


    // Obtenez l'ID_Utilisateur directement à partir de la session
    session_start();
    $idUtilisateur = $this->getIdUtilisateurByEmail($_SESSION['email']); // Assurez-vous de remplacer $_SESSION['email'] par le champ approprié

    $donnees = array(
        
            ":adresse" => $tab['adresse'],
            ":ville" => $tab['ville'],
            ":type" => $tab['type'],
            ":description" => $tab['description'],
            ":prix" => $tab['prix'],
            ":capacite" => $tab['capacite'],
            ":date_dispo" => $tab['date_dispo'],
            ":datefin_dispo" => $tab['datefin_dispo'],
            ":saison" => $tab['saison'],
            ":id_utilisateur" => $idUtilisateur
       
        
    );
            $select = $this->unPDO->prepare($requete);
            $select->execute($donnees);
            $idLogement = $this->unPDO->lastInsertId();

        // Insérer les informations des photos dans la table photo
        foreach ($photos['name'] as $key => $nomPhoto) {
            $targetPath = '../photo_logements/' . $nomPhoto;
        
            if (move_uploaded_file($photos['tmp_name'][$key], $targetPath)) {
                // L'upload a réussi, vous pouvez maintenant insérer dans la base de données
                $requetePhoto = "INSERT INTO photo VALUES (null, :nom_photo, :ID_Logement)";
                $donneesPhoto = array(
                    ":nom_photo" => $nomPhoto,
                    ":ID_Logement" => $idLogement
                );
                $selectPhoto = $this->unPDO->prepare($requetePhoto);
                $selectPhoto->execute($donneesPhoto);
            } else {
                // L'upload a échoué, affichez l'erreur
                echo "Erreur lors du téléchargement de l'image : " . $_FILES['photos']['error'][$key];
            }
        }
        

        $this->unPDO->commit();

    }
    catch (PDOException $e) {
        $this->unPDO->rollBack();
        echo "Erreur lors de l'insertion du logement : " . $e->getMessage();
    }
        }
        


        public function selectAllLogements (){
            $requete = "select * from logement"; 
            $select = $this->unPDO->prepare ($requete); 
            $select->execute ();
            return $select->fetchAll(); 
        }
        public function selectPhotosByLogement($idLogement) {
            $requete = "SELECT * FROM photo WHERE id_logement = :idLogement";
            $select = $this->unPDO->prepare($requete);
            $select->bindParam(':idLogement', $idLogement, PDO::PARAM_INT);
            $select->execute();
            return $select->fetchAll();
        }
         /************ CATALOGUE NEIGE ************** */

         public function selectLogementsByNeige()
         {
             $saison = 'Neige'; 
             $requete = "SELECT * FROM logement WHERE saison = :saison";
             $select = $this->unPDO->prepare($requete);
             $select->bindParam(':saison', $saison, PDO::PARAM_STR);
             $select->execute();
 
             return $select->fetchAll();
         }
          
         /********** CATALOGUE SOLEIL ************** */
 
         public function selectLogementsBySoleil()
         {
             $saison = 'Soleil'; 
             $requete = "SELECT * FROM logement WHERE saison = :saison";
             $select = $this->unPDO->prepare($requete);
             $select->bindParam(':saison', $saison, PDO::PARAM_STR);
             $select->execute();
 
             return $select->fetchAll();
         }

         /******* Inscription Utilisateur **** **********/

         public function insertProprio($tab) {
            
                $requete = "insert into proprietaire values (null , :nom, :prenom, :email, :telephone, :mdp, :roles);";
        
                // Hachage du mot de passe
                $hashedPassword = password_hash($tab['mdp'], PASSWORD_DEFAULT);
        
                $donnees = array(
                    ":nom" => $tab['nom'],
                    ":prenom" => $tab['prenom'],
                    ":email" => $tab['email'],
                    ":telephone" => $tab['telephone'],
                    ":mdp" => $hashedPassword, // Utilisation du mot de passe haché
                    ":roles" => $tab['roles'],
                );
        
                $select = $this->unPDO->prepare($requete);
                $select->execute($donnees);
            }
            
            public function insertClient($tab) {
            
                $requete = "insert into client values (null , :nom, :prenom, :email, :telephone, :mdp, :roles);";
        
                // Hachage du mot de passe
                $hashedPassword = password_hash($tab['mdp'], PASSWORD_DEFAULT);
        
                $donnees = array(
                    ":nom" => $tab['nom'],
                    ":prenom" => $tab['prenom'],
                    ":email" => $tab['email'],
                    ":telephone" => $tab['telephone'],
                    ":mdp" => $hashedPassword, // Utilisation du mot de passe haché
                    ":roles" => $tab['roles'],
                );
        
                $select = $this->unPDO->prepare($requete);
                $select->execute($donnees);
            }
            
            

            /**************** CONNEXION********** */

            public function connexionUtilisateur($email, $mdp) {
                try {
                    $requete = "SELECT * FROM utilisateur WHERE email = :email";
                    $select = $this->unPDO->prepare($requete);
                    $select->bindParam(':email', $email, PDO::PARAM_STR);
                    $select->execute();
                    $utilisateur = $select->fetch(PDO::FETCH_ASSOC);
            
                    // Vérifiez si l'utilisateur existe et si le mot de passe est correct
                    if ($utilisateur && password_verify($mdp, $utilisateur['mdp'])) {
                        // Connexion réussie
                        return true;
                    } else {
                        // Mot de passe incorrect ou utilisateur inexistant
                        return false;
                    }
                } catch (PDOException $exp) {
                    echo "<br> Erreur de connexion à la base de données";
                    return false;
                }
            }



            /************ Profils utilisateur connecter********* */

            public function UtilisateurConnecter($email){
                $requete = "select nom , prenom , email , telephone from utilisateur where email = :email";
                $select =$this->unPDO->prepare($requete);
                $select->bindParam(':email' , $email);
                $select ->execute();
                return $select->fetch(PDO::FETCH_ASSOC);
            }



            /************Permet de récuperer les roles necessaire lors des connexion ************* */
            public function getRoleUtilisateur($email) {
                try {
                    $requete = "SELECT roles FROM utilisateur WHERE email = :email";
                    $donnees = [':email' => $email];
                    $select = $this->unPDO->prepare($requete);
                    $select->execute($donnees);
                    $resultat = $select->fetch(PDO::FETCH_ASSOC);
        
                    if ($resultat) {
                        return $resultat['roles'];
                    } else {
                        return null; // L'utilisateur n'a pas été trouvé
                    }
                } catch (PDOException $e) {
                    // Gérer les erreurs de requête ici
                    return null;
                }
            }


            /**********Recherche de Logement ***** */

            public function rechercheLogement($ville,  $dateDebut, $dateFin) {
                try {
                    $requete = "SELECT * FROM logement WHERE ville = :ville AND  date_dispo <= :dateDebut AND datefin_dispo >= :dateFin";
                    $select = $this->unPDO->prepare($requete);
                    
                    // Associer les paramètres aux valeurs
                    $select->bindParam(':ville', $ville);
                    $select->bindParam(':dateDebut', $dateDebut);
                    $select->bindParam(':dateFin', $dateFin);
                    
                    // Exécuter la requête et retourner les résultats
                    $select->execute();
                    return $select->fetchAll(PDO::FETCH_ASSOC);
                } catch (PDOException $exp) {
                    // Gérer ou propager l'erreur
                    throw new Exception("Erreur de connexion à la base de données");
                }
            }

                 /**** Methode pour recuperer l'id du client *********** */
            public function getIdClient($email) {
                $requete = "SELECT id_utilisateur FROM client WHERE email = :email";
                $stmt = $this->unPDO->prepare($requete);
                $stmt->execute(array(":email" => $email));
                $resultat = $stmt->fetch(PDO::FETCH_ASSOC);
            
                return $resultat['id_utilisateur'];
            }
            

            /**********ajout reservation******************/

            public function insertReservation($dateDebut, $dateFin, $idLogement, $idUtilisateur) {
                $requete = "INSERT INTO reservation (date_debut, date_fin, statut, id_logement, id_utilisateur) 
                            VALUES (:dateDebut, :dateFin, 'réservé', :idLogement, :idUtilisateur)";
                
                $donnees = array(
                    ":dateDebut" => $dateDebut,
                    ":dateFin" => $dateFin,
                    ":idLogement" => $idLogement,
                    ":idUtilisateur" => $idUtilisateur
                );
            
                $select = $this->unPDO->prepare($requete);

                if($select->execute($donnees)) {
                    // Si l'insertion est réussie, retournez l'ID de la réservation
                    return $this->unPDO->lastInsertId();
                } else {
                   
                    echo  "Problème d'insertion dans la BDD.";
                    return false;
                }
            }
            
            /****dispo date logement */
            public function verifierDisponibilite($idLogement, $dateDebut, $dateFin) {
                $requete = "SELECT COUNT(*) FROM reservation WHERE id_logement = ? AND NOT (date_fin <= ? OR date_debut >= ?)";
                $stmt = $this->unPDO->prepare($requete);
                $stmt->execute([$idLogement, $dateDebut, $dateFin]);
                $nombreReservations = $stmt->fetchColumn();
                return $nombreReservations == 0; // True si disponible, false sinon
            }



            /********************select detail de la reservation************** */

            public function getReservationId($idReservation) {
                $requete = "SELECT * FROM reservation WHERE id_reservation = :idReservation";
                $stmt = $this->unPDO->prepare($requete);
                $stmt->bindParam(':idReservation', $idReservation, PDO::PARAM_INT);
                $stmt->execute();
                return $stmt->fetch(PDO::FETCH_ASSOC);
            }


            /************************************
             */

             public function getLogementId($idLogement) {
                $requete = "SELECT * FROM logement WHERE id_logement = :idLogement";
                $stmt = $this->unPDO->prepare($requete);
                $stmt->bindParam(':idLogement', $idLogement, PDO::PARAM_INT);
                $stmt->execute();
                return $stmt->fetch(PDO::FETCH_ASSOC);
            }

            public function getClientId($idClient) {
                $requete = "SELECT * FROM client WHERE id_utilisateur = :idClient";
                $stmt = $this->unPDO->prepare($requete);
                $stmt->bindParam(':idClient', $idClient, PDO::PARAM_INT);
                $stmt->execute();
                return $stmt->fetch(PDO::FETCH_ASSOC);
            }
            
            
            
            
            }

        

    
        
   

?>
