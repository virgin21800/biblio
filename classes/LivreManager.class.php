<?php
class LivreManager
{
    private $_bdd; // Instance de PDO

    public function __construct($bdd)
    {
        $this->setBdd($bdd);
    }

    public function create(Livre $livre)
    {
        // préparation de la requête SQL pour insérer dans la bdd
        $create_livre = $this->_bdd->prepare('INSERT INTO livre (titre, auteur) VALUES(:titre, :auteur)');
		// bindValue — Associe une valeur à un paramètre
		// On associe les différentes variables aux marqueurs en respectant le type de chacunes
        $create_livre->bindValue(':titre', $livre->getTitre(), PDO::PARAM_STR);
        $create_livre->bindValue(':auteur', $livre->getAuteur(), PDO::PARAM_STR);
		// Exécution de la requête
        $create_livre->execute();
		// closeCursor() libère la connexion au serveur, permettant ainsi à d'autres requêtes SQL d'être exécutées
        $create_livre->closeCursor();
        return $create_livre->rowCount();
    }

    public function delete(Livre $livre)
    {
        $delete_livre = $this->_bdd->prepare("DELETE FROM livre WHERE id = :id");
	    // bindParam — Lie un paramètre à un nom de variable spécifique
	    // la différence avec bindValue c'est que l'on affecte non pas la valeur mais la variable en elle-même
	    // cela peut permettre de modifier celle-ci entre plusieurs exécutions de requêtes successives.
        $delete_livre->bindParam(':id', $livre->getId(), PDO::PARAM_INT);
        $delete_livre->execute();
	    // closeCursor() libère la connexion au serveur, permettant ainsi à d'autres requêtes SQL d'être exécutées
        $delete_livre->closeCursor();
        return $delete_livre->rowCount();
    }

    public function get($id){
        $id = (int)$id;

        $query = $this->_bdd->query('SELECT * FROM livre WHERE id = ' . $id);
        $donnees = $query->fetch(PDO::FETCH_ASSOC);

        return new Livre($donnees);
    }

    public function getAll()
    {
        $livre = [];

        $query = $this->_bdd->query('SELECT * FROM livre ORDER BY titre');

        while ($donnees = $query->fetch(PDO::FETCH_ASSOC)) {
            $livre[] = new Livre($donnees);
        }

        return $livre;
    }

    public function update(Livre $livre)
    {
        // préparation de la requête SQL pour mettre à jour la BDD
        $update_livre = $this->_bdd->prepare('UPDATE livre SET titre = :titre, auteur = :auteur WHERE id = :id');
        // bindValue — Associe une valeur à un paramètre
        // On associe les différentes variables aux marqueurs en respectant le type de chacunes
        $update_livre->bindValue(':titre', $livre->getTitre(), PDO::PARAM_STR);
        $update_livre->bindValue(':auteur', $livre->getDescription(), PDO::PARAM_STR);
        $update_livre->bindValue(':id', $livre->getId(), PDO::PARAM_INT);
        // Exécution de la requête
        $update_livre->execute();
        // closeCursor() libère la connexion au serveur, permettant ainsi à d'autres requêtes SQL d'être exécutées
        $update_livre->closeCursor();
        return $update_livre->rowCount();
    }

    public function gestionPOST(array $post)
    {
        // Récupère la super globale $_POST et traite les différents champs
        // pour rendre en sortie un objet Livre si tout est correct !
        $livre = new Livre($post);

        // préparation de la requête SQL pour insérer dans la bdd
        $create_livre = $this->_bdd->prepare('INSERT INTO livre (titre, auteur) VALUES(:titre, :auteur)');
		// bindValue — Associe une valeur à un paramètre
		// On associe les différentes variables aux marqueurs en respectant le type de chacunes
        $create_livre->bindValue(':titre', $livre->getTitre(), PDO::PARAM_STR);
        $create_livre->bindValue(':auteur', $livre->getAuteur(), PDO::PARAM_STR);
		// Exécution de la requête
        $create_livre->execute();
		// closeCursor() libère la connexion au serveur, permettant ainsi à d'autres requêtes SQL d'être exécutées
        $create_livre->closeCursor();

        if($create_livre->rowCount()){
            return new Livre ($post);
        }
    }

    public function setBdd(PDO $bdd)
    {
        $this->_bdd = $bdd;
    }
}
?>