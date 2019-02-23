<?php
class abonneManager  {

  private $_db; // Instance de PDO.

  public function setDb(PDO $db) {
    $this->_db = $db;
  }

  public function __construct($db) {
  $this->setDb($db);
  }

  public function addAbonne(abonne $abonne) {
    // Préparation de la requête d'insertion. Assignation des valeurs. Exécution de la requête.
	    $add_abonne = $this->_db->prepare('INSERT INTO abonne(prenom, nom) VALUES(:prenom, :nom);');    
	    $add_abonne->bindValue(':prenom', $abonne->getPrenom(), PDO::PARAM_STR);
      $add_abonne->bindValue(':nom', $abonne->getNom(), PDO::PARAM_STR);      
	    $add_abonne->execute();
      $add_abonne->closeCursor();
      return ($add_abonne->rowCount());
   } 

  public function updateAbonne(abonne $abonne) {
  // Prépare une requête de type UPDATE.
      $update_abonne = $this->_db->prepare('UPDATE abonne SET prenom = :prenom, nom = :nom WHERE id_abonne='.$abonne->getId_abonne());    
      $update_abonne->bindValue(':prenom', $abonne->getPrenom(), PDO::PARAM_STR);
      $update_abonne->bindValue(':nom', $abonne->getNom(), PDO::PARAM_STR);      
      $update_abonne->execute();
      $update_abonne->closeCursor();
      return ($update_abonne->rowCount());
} 

  public function deleteAbonne($id) {
  // Exécute une requête de type DELETE
      $delete_abonne = $this->_db->query('DELETE FROM abonne WHERE id_abonne = '.$id);
      $delete_abonne->closeCursor();
      return ($delete_abonne->rowCount());
  }      

  public function getAbonnebyId($id) {
    $abonne = $this->_db->query('SELECT * FROM abonne WHERE id_abonne ='.$id)->fetch(PDO::FETCH_ASSOC);
    return ($abonne);
  }   

  public function getListAbonne() {
    $abonnes = $this->_db->query('SELECT * FROM abonne;')->fetchAll(PDO::FETCH_ASSOC);
    return $abonnes;
  }   
}