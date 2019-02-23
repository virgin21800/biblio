<?php
class AbonneManager
{
    private $_bdd; // Instance de PDO

    public function __construct($bdd)
    {
        $this->setBdd($bdd);
    }

    public function create(Abonne $abonne)
    {
        // préparation de la requête SQL pour insérer dans la bdd
        $create_abonne = $this->_bdd->prepare('INSERT INTO abonne (nom, prenom) VALUES(:nom, :prenom)');
		// bindValue — Associe une valeur à un paramètre
		// On associe les différentes variables aux marqueurs en respectant le type de chacunes
        $create_abonne->bindValue(':nom', $abonne->getNom(), PDO::PARAM_STR);
        $create_abonne->bindValue(':prenom', $abonne->getPrenom(), PDO::PARAM_STR);
		// Exécution de la requête
        $create_abonne->execute();
		// closeCursor() libère la connexion au serveur, permettant ainsi à d'autres requêtes SQL d'être exécutées
        $create_abonne->closeCursor();
        return $create_abonne->rowCount();
    }

    public function delete(Abonne $abonne)
    {
        $delete_abonne = $this->_bdd->prepare("DELETE FROM abonne WHERE id = :id");
	    // bindParam — Lie un paramètre à un nom de variable spécifique
	    // la différence avec bindValue c'est que l'on affecte non pas la valeur mais la variable en elle-même
	    // cela peut permettre de modifier celle-ci entre plusieurs exécutions de requêtes successives.
        $delete_abonne->bindParam(':id', $abonne->getId(), PDO::PARAM_INT);
        $delete_abonne->execute();
	    // closeCursor() libère la connexion au serveur, permettant ainsi à d'autres requêtes SQL d'être exécutées
        $delete_abonne->closeCursor();
        return $delete_abonne->rowCount();
    }

    public function get($id){
        $id = (int)$id;

        $query = $this->_bdd->query('SELECT * FROM abonne WHERE id = ' . $id);
        $donnees = $query->fetch(PDO::FETCH_ASSOC);

        return new Abonne($donnees);
    }

    public function getAll()
    {
        $query = $this->_bdd->query('SELECT * FROM abonne ORDER BY nom');
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update(Abonne $abonne)
    {
        // préparation de la requête SQL pour mettre à jour la BDD
        $update_abonne = $this->_bdd->prepare('UPDATE abonne SET nom = :nom, prenom = :prenom WHERE id = :id');
        // bindValue — Associe une valeur à un paramètre
        // On associe les différentes variables aux marqueurs en respectant le type de chacunes
        $update_abonne->bindValue(':nom', $abonne->getTitre(), PDO::PARAM_STR);
        $update_abonne->bindValue(':prenom', $abonne->getDescription(), PDO::PARAM_STR);
        $update_abonne->bindValue(':id', $abonne->getId(), PDO::PARAM_INT);
        // Exécution de la requête
        $update_abonne->execute();
        // closeCursor() libère la connexion au serveur, permettant ainsi à d'autres requêtes SQL d'être exécutées
        $update_abonne->closeCursor();
        return $update_abonne->rowCount();
    }

    public function gestionPOST(array $post)
    {
        // Récupère la super globale $_POST et traite les différents champs
        // pour rendre en sortie un objet Abonne si tout est correct !
        $abonne = new Abonne($post);

        // préparation de la requête SQL pour insérer dans la bdd
        $create_abonne = $this->_bdd->prepare('INSERT INTO abonne (nom, prenom) VALUES(:nom, :prenom)');
		// bindValue — Associe une valeur à un paramètre
		// On associe les différentes variables aux marqueurs en respectant le type de chacunes
        $create_abonne->bindValue(':nom', $abonne->getNom(), PDO::PARAM_STR);
        $create_abonne->bindValue(':prenom', $abonne->getPrenom(), PDO::PARAM_STR);
		// Exécution de la requête
        $create_abonne->execute();
		// closeCursor() libère la connexion au serveur, permettant ainsi à d'autres requêtes SQL d'être exécutées
        $create_abonne->closeCursor();

        if($create_abonne->rowCount()){
            return $abonne;
        }
    }

    public function setBdd(PDO $bdd)
    {
        $this->_bdd = $bdd;
    }
}
?>