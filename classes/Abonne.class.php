<?php
class Abonne {

  protected $_id_abonne;
  protected $_prenom;
  protected $_nom;  

  // Un tableau de données doit être passé à la fonction (d'où le préfixe « array »).
  public function hydrate(array $donnees) {
     foreach ($donnees as $key => $value) {
      // On récupère le nom du setter correspondant à l'attribut.
      $method = 'set'.ucfirst($key);
      // Si le setter correspondant existe.
      if (method_exists($this, $method)) {
        // On appelle le setter.
        $this->$method($value);
      }
     }
  }

  public function getId_abonne() { return $this->_id_abonne; }
  public function getPrenom() { return $this->_prenom; }
  public function getNom() { return $this->_nom; }    

  private function setId_abonne($id) {
    $this->_id_abonne = $id;
  }

  public function setPrenom($prenom) {
    if (is_string($prenom) && strlen($prenom) <= 50) {
      $this->_prenom = $prenom;
    }  else {
        echo 'ERREUR ABONNE PRENOM'; die();
    }
  }

  public function setNom($nom) {
    if (is_string($nom) && strlen($nom) <= 50) {
      $this->_nom = $nom;
    }  else {
        echo 'ERREUR ABONNE NOM'; die();
    }
  }

  public function __construct(array $donnees) {
    $this->hydrate($donnees);
  }  
}