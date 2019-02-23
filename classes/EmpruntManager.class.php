<?php
class empruntManager  {

  private $_db; // Instance de PDO.

  public function setDb(PDO $db) {
    $this->_db = $db;
  }

  public function __construct($db) {
  $this->setDb($db);
  }

  public function addEmprunt(emprunt $emprunt) {
    // Préparation de la requête d'insertion. Assignation des valeurs. Exécution de la requête.
	    $add_emprunt = $this->_db->prepare('INSERT INTO emprunt(id_abonne, id_livre, date_emprunt) VALUES(:id_abonne, :id_livre, :date_emprunt);');    
	    $add_emprunt->bindValue(':id_abonne', $emprunt->getId_abonne(), PDO::PARAM_INT);
      $add_emprunt->bindValue(':id_livre', $emprunt->getId_livre(), PDO::PARAM_INT);
      $add_emprunt->bindValue(':date_emprunt', $emprunt->getDate_emprunt(), PDO::PARAM_STR);
	    $add_emprunt->execute();
      $add_emprunt->closeCursor();
      //return ($add_emprunt->rowCount());
   } 

  public function updateEmprunt(emprunt $emprunt) {
  // Prépare une requête de type UPDATE.
      $update_emprunt = $this->_db->prepare('UPDATE emprunt SET id_abonne = :id_abonne, id_livre = :id_livre, date_emprunt = :date_emprunt WHERE id='.$emprunt->getId_emprunt());    
      $update_emprunt->bindValue(':id_abonne', $emprunt->getId_abonne(), PDO::PARAM_INT);
      $update_emprunt->bindValue(':id_livre', $emprunt->getId_livre(), PDO::PARAM_INT);
      $update_emprunt->bindValue(':date_emprunt', $emprunt->getDate_emprunt(), PDO::PARAM_STR);
      $update_emprunt->execute();
      $update_emprunt->closeCursor();
      return ($update_emprunt->rowCount());
} 

  public function deleteEmprunt($id) {
  // Exécute une requête de type DELETE
      $delete_emprunt = $this->_db->query('DELETE FROM emprunt WHERE id_emprunt = '.$id);
      $delete_emprunt->closeCursor();
      return ($delete_emprunt->rowCount());
  }      

  public function geEmpruntbyId($id) {
    $emprunt = $this->_db->query('SELECT * FROM emprunt WHERE id_emprunt ='.$id)->fetch(PDO::FETCH_ASSOC);
    return ($emprunt);
  }   

  public function getListEmprunt() {
    $emprunts = $this->_db->query('SELECT emprunt.id_emprunt AS id_emprunt, abonne.prenom AS prenom, abonne.nom AS nom, abonne.id_abonne AS id_abonne, livre.titre AS titre, livre.auteur AS auteur, livre.id_livre AS id_livre, emprunt.date_emprunt AS date_emprunt 
                      FROM abonne
                      JOIN emprunt ON abonne.id_abonne = emprunt.id_abonne
                      JOIN livre ON emprunt.id_livre = livre.id_livre;')->fetchAll(PDO::FETCH_ASSOC);
    return $emprunts;
  }   
}