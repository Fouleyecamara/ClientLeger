<?php
    require_once ("../modele/modele.class.php");

    class Controleur {
        private $unModele ; 

        public function  __construct (){
            $this->unModele = new Modele (); 
        }
        public function setTable($table){
            $this->unModele->setTable($table);
        }
        public function getTable (){
            return $this->unModele->getTable();
        }

        /********** METTRE UN LOGEMENT********* */
        public function insertLogement ($tab, $photos){
           
            //on controle les données avant insertion 
            $idUtilisateur = $this->unModele->getIdUtilisateurByEmail($_SESSION['email']); // Assurez-vous de remplacer $_SESSION['email'] par le champ approprié

            // Ajoutez l'ID_Utilisateur aux données avant de les envoyer au modèle
            $tab['id_utilisateur'] = $idUtilisateur;
            //appel de la méthode du modele 
            $this->unModele->insertLogement($tab, $photos);
        }

        public function updateLogement($idLogement, $tab, $photos){
            return $this->unModele-> updateLogement($idLogement, $tab, $photos);
            
        }

        public function selectLogement($email){
            //appel de la méthode du modele 
            return $this->unModele->selectLogement($email);
        }
        public function selectPhotosByLogement($idLogement) {
            return $this->unModele->selectPhotosByLogement($idLogement);
        }
        /***************CATALOGUE NEIGE ********* */
        public function selectLogementByNeige(){
            return $this->unModele->selectLogementsByNeige();
        }


        /********** CATALOGUE SOLEIL *********** */
        public function selectLogementsBySoleil(){
            return $this->unModele->selectLogementsBySoleil();
        }
        
         /****INSCRIPTION PROPRIO ******** */
        public function insertProprio($tab){

			//appel de la méthode du modele 
			$this->unModele->insertProprio($tab);
		}
        public function  updateProprio($tab){
            $this->unModele->updateProprio($tab);
        }
        public function  updateClient($tab){
            $this->unModele->updateClient($tab);
        }
        /*********Inscription client **** */
        public function insertClient($tab){

			//appel de la méthode du modele 
			$this->unModele->insertClient($tab);
		}
        

        /****** afficher le profils ******* */

        public function UtilisateurConnecter() {
            // l'e-mail de l'utilisateur connecté 
            $email = $_SESSION['email'];
            $utilisateurConnecte = $this->unModele->UtilisateurConnecter($email);
            return $utilisateurConnecte;
        }
        
        
        /**** Connexion utilisateur******** */
       
        public function connexionUtilisateur($email, $mdp) {
            // Appel de la méthode du modèle
            $resultat = $this->unModele->connexionUtilisateur($email, $mdp);
        
            return $resultat;
        }

        /********* */
        public function getRoleUtilisateur($email) {
            $unModele = new Modele();
            return $unModele->getRoleUtilisateur($email);
        }

        /*********RECHERCHE DE LOGEMENT ********* */

        public function rechercheLogement($ville, $dateDebut, $dateFin) {
            $resultats= $this->unModele->rechercheLogement($ville, $dateDebut, $dateFin);
            return $resultats;
    }

  /*****recuperation de l'id du client ******* */
  public function getIdClient($email) {
    return $this->unModele->getIdClient($email);
}  


/*************AJOUT RESERVATION******************/
public function insertReservation($dateDebut, $dateFin, $idLogement, $idUtilisateur) {
    // Appelle la méthode du modèle pour insérer la réservation dans la base de données
    return $this->unModele->insertReservation($dateDebut, $dateFin, $idLogement, $idUtilisateur);
}



public function verifierDisponibilite($idLogement, $dateDebut, $dateFin) {
    // Appelle la méthode du modèle et retourne le résultat
    return $this->unModele->verifierDisponibilite($idLogement, $dateDebut, $dateFin);
}

/******SELECT RECAP RESERVATION  */

// Dans Controleur.class.php
public function selectReservation($email){
    //appel de la méthode du modele 
    return $this->unModele->selectReservation($email);
}

}



    
?>
