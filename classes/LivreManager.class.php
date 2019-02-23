<?php
class livreManager  {

  private $_db; // Instance de PDO.

  public function setDb(PDO $db) {
    $this->_db = $db;
  }

  public function __construct($db) {
  $this->setDb($db);
  }

  public function addLivre(livre $livre) {
    // Préparation de la requête d'insertion. Assignation des valeurs. Exécution de la requête.
	    $add_livre = $this->_db->prepare('INSERT INTO livre(titre, auteur) VALUES(:titre, :auteur);');    
	    $add_livre->bindValue(':titre', $livre->getTitre(), PDO::PARAM_STR);
      $add_livre->bindValue(':auteur', $livre->getAuteur(), PDO::PARAM_STR);      
	    $add_livre->execute();
      $add_livre->closeCursor();
      return ($add_livre->rowCount());
   } 

  public function updateLivre(livre $livre) {
  // Prépare une requête de type UPDATE.
      $update_livre = $this->_db->prepare('UPDATE livre SET titre = :titre, auteur = :auteur WHERE id_livre='.$livre->getId_livre());    
      $update_livre->bindValue(':titre', $livre->getTitre(), PDO::PARAM_STR);
      $update_livre->bindValue(':auteur', $livre->getAuteur(), PDO::PARAM_STR);      
      $update_livre->execute();
      $update_livre->closeCursor();
      return ($update_livre->rowCount());
} 

  public function deleteLivre($id) {
  // Exécute une requête de type DELETE
      $delete_livre = $this->_db->query('DELETE FROM livre WHERE id_livre = '.$id);
      $delete_livre->closeCursor();
      return ($delete_livre->rowCount());
  }      

  public function getLivrebyId($id) {
    $livre = $this->_db->query('SELECT * FROM livre WHERE id_livre ='.$id)->fetch(PDO::FETCH_ASSOC);
    return ($livre);
  }   

  public function getListLivre() {
    $livres = $this->_db->query('SELECT * FROM livre;')->fetchAll(PDO::FETCH_ASSOC);
    return $livres;
  }   
}