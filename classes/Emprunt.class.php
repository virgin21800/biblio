aute<?php

class Emprunt {

	private $_id_emprunt;
	private $_id_abonne;
	private $_id_livre;
	private $_date_emprunt;

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

	public function getId_emprunt() { return $this->_id_emprunt; }
	public function getId_abonne() { return $this->_id_abonne; }	
	public function getId_livre() { return $this->_id_livre; }
	public function getDate_emprunt() { return $this->_date_emprunt; }

	private function setId_emprunt($id) {
		$this->_id_emprunt = $id;
	}

	public function setId_abonne($id) {
		$this->_id_abonne = $id;
	}

	public function setId_livre($id) {
		$this->_id_livre = $id;
	}

	public function setDate_emprunt($date_emprunt) {
		$this->_date_emprunt = $date_emprunt;
	}

	public function __construct(array $donnees) {
	$this->hydrate($donnees);
	}
}