<?php
class EmpruntManager
{
    private $_bdd; // Instance de PDO

    public function __construct($bdd)
    {
        $this->setBdd($bdd);
    }

    public function create(Emprunt $emprunt)
    {
        echo '<pre>';
        echo 'objet pret pour la bdd :';
        var_dump($emprunt);
        echo '</pre>';

        // préparation de la requête SQL pour insérer dans la bdd
        $create_emprunt = $this->_bdd->prepare('INSERT INTO emprunt (idabonne, idlivre, dateemprunt) VALUES(:idabonne, :idlivre, :dateemprunt)');
        // bindValue — Associe une valeur à un paramètre
        // On associe les différentes variables aux marqueurs en respectant le type de chacunes
        $create_emprunt->bindValue(':idabonne', $emprunt->getIdabonne(), PDO::PARAM_STR);
        $create_emprunt->bindValue(':idlivre', $emprunt->getIdlivre(), PDO::PARAM_STR);
        $create_emprunt->bindValue(':dateemprunt', $emprunt->getDateemprunt(), PDO::PARAM_STR);
        // Exécution de la requête
        $create_emprunt->execute();

        $resultat = 0;
        $livres = $emprunt->getListeLivres();

        if ($create_emprunt->rowCount()) {
            foreach ($livres as $livre) {
                $create_livre_emprunt = $this->_bdd->prepare('INSERT INTO emprunt (idlivre, idabonne, dateemprunt) VALUES (:idemprunt, :idlivre, :dateemprunt)');
                $create_livre_emprunt->bindValue(':idlivre', $livre['idlivre'], PDO::PARAM_INT);
                $create_livre_emprunt->bindValue(':idabonne', $livre['idabonne'], PDO::PARAM_INT);
                $create_livre_emprunt->bindValue(':dateemprunt', $livre['dateemprunt'], PDO::PARAM_INT);
                $resultat = $create_livre_emprunt->rowCount();
            }
        }

        // closeCursor() libère la connexion au serveur, permettant ainsi à d'autres requêtes SQL d'être exécutées
        $create_emprunt->closeCursor();
        return $resultat;
    }

    public function delete(Emprunt $emprunt)
    {
        $resultat = 0;

        $livres = $this->getListeLivres($emprunt);
        foreach ($livres as $livre) {
            $delete_livre_emprunt = $this->_bdd->prepare("DELETE FROM emprunt WHERE idemprunt = :idemprunt");
            $delete_livre_emprunt->bindValue(':idemprunt', $emprunt->getId(), PDO::PARAM_INT);
            $resultat = $delete_livre_emprunt->rowCount();
        }
        $editeurs = $this->getListeEditeurs($emprunt);
        foreach ($livres as $livre) {
            $delete_editeur_emprunt = $this->_bdd->prepare("DELETE FROM edition WHERE idemprunt = :idemprunt");
            $delete_editeur_emprunt->bindValue(':idemprunt', $emprunt->getId(), PDO::PARAM_INT);
            $resultat = $delete_editeur_emprunt->rowCount();
        }
        $supports = $this->getListeSupports($emprunt);
        foreach ($livres as $livre) {
            $delete_support_emprunt = $this->_bdd->prepare("DELETE FROM adaptation WHERE idemprunt = :idemprunt");
            $delete_support_emprunt->bindValue(':idemprunt', $emprunt->getId(), PDO::PARAM_INT);
            $resultat = $delete_support_emprunt->rowCount();
        }
        if ($resultat) {
            $delete_emprunt = $this->_bdd->prepare("DELETE FROM emprunt WHERE id = :id");
            // bindParam — Lie un paramètre à un nom de variable spécifique
            // la différence avec bindValue c'est que l'on affecte non pas la valeur mais la variable en elle-même
            // cela peut permettre de modifier celle-ci entre plusieurs exécutions de requêtes successives.
            $delete_emprunt->bindParam(':id', $emprunt->getId(), PDO::PARAM_INT);
            $delete_emprunt->execute();

            // closeCursor() libère la connexion au serveur, permettant ainsi à d'autres requêtes SQL d'être exécutées
            $delete_emprunt->closeCursor();
            $resultat = $delete_emprunt->rowCount();
        }
        return $resultat;
    }

    public function get($id)
    {
        $id = (int)$id;

        $get_emprunt = $this->_bdd->query('SELECT * FROM emprunt WHERE id = ' . $id);
        $donnees = $get_emprunt->fetch(PDO::FETCH_ASSOC);
        // closeCursor() libère la connexion au serveur, permettant ainsi à d'autres requêtes SQL d'être exécutées
        $get_emprunt->closeCursor();

        return new Emprunt($donnees);
    }

    public function getAll()
    {
        $empruntx = [];
        $query = $this->_bdd->query('SELECT * FROM emprunt ORDER BY idabonne');
        $liste = $query->fetchAll(PDO::FETCH_ASSOC);
        foreach ($liste as $donnees) {
            $empruntx[] = new Emprunt($donnees);
        }
        return $empruntx;
    }

    public function update(Emprunt $emprunt)
    {
        // préparation de la requête SQL pour mettre à jour la BDD
        $update_emprunt = $this->_bdd->prepare('UPDATE emprunt SET idabonne = :idabonne, idlivre = :idlivre, dateemprunt = :dateemprunt, prix = :prix, image = :image, urlSite = :urlSite WHERE id = :id');
        // bindValue — Associe une valeur à un paramètre
        // On associe les différentes variables aux marqueurs en respectant le type de chacunes
        $update_emprunt->bindValue(':idabonne', $emprunt->getIdabonne(), PDO::PARAM_STR);
        $update_emprunt->bindValue(':idlivre', $emprunt->getIdlivre(), PDO::PARAM_STR);
        $update_emprunt->bindValue(':dateemprunt', $emprunt->getDateemprunt(), PDO::PARAM_INT);
        $update_emprunt->bindValue(':prix', $emprunt->getPrix(), PDO::PARAM_FLOAT);
        $update_emprunt->bindValue(':image', $emprunt->getImage(), PDO::PARAM_STR);
        $update_emprunt->bindValue(':urlSite', $emprunt->getUrlSite(), PDO::PARAM_STR);
        $update_emprunt->bindValue(':id', $emprunt->getId(), PDO::PARAM_INT);
        // Exécution de la requête
        $update_emprunt->execute();
        // closeCursor() libère la connexion au serveur, permettant ainsi à d'autres requêtes SQL d'être exécutées
        $update_emprunt->closeCursor();
        $livres = $emprunt->getListeLivres();
        $resultat = 0;
        if ($update_emprunt->rowCount()) {
            foreach ($livres as $livre) {
                $update_livre_emprunt = $this->_bdd->prepare("INSERT INTO emprunt (idlivre, idemprunt) VALUES (idlivre = :idlivre, idemprunt = :idemprunt WHERE idemprunt = :idemprunt ON DUPLICATE KEY UPDATE idemprunt = :idemprunt, idlivre = :idlivre)");
                $update_livre_emprunt->bindValue(':idemprunt', $livre['idlivre'], PDO::PARAM_INT);
                $update_livre_emprunt->bindValue(':idlivre', $livre['idemprunt'], PDO::PARAM_INT);
                $resultat = $update_livre_emprunt->rowCount();
            }
        }
        return $resultat;
    }

    public function getListeLivres($idemprunt){
        $query = $this->_bdd->query('SELECT * FROM emprunt WHERE id = ' . $idemprunt);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function setBdd(PDO $bdd)
    {
        $this->_bdd = $bdd;
    }
}