<?php
require_once 'connexion.php';

$abonneMgr = new AbonneManager($bdd);

// AFFICHAGE DES ABONNES ****************************************************************************************
if (isset($_POST['action']) && $_POST['action'] == 'show') {   //je recois la requete ajax pour afficher les abonnes

    // J'appelle la méthode de récupération du tableau d'abonnes au manager
    $tab['abonnes'] = $abonneMgr->getAll();
    $tab['resultat'] = false;
    // Je regarde si le tableau contient des abonnes si oui la variable passe à 'Vrai'
    if (count($tab['abonnes']) > 0) {
        $tab['resultat'] = true;
    }
    // je renvoie mon tableau d'abonnes et ma variable de contrôle en JSON à la requête Ajax
    echo json_encode($tab);
}

// AJOUT D'UN ABONNE ****************************************************************************************
if (isset($_POST['action']) && $_POST['action'] == 'insert') {  //je recois la requete ajax pour inserer un abonne

    // On vérifie que TOUS les champs obligatoires existent
    if (
        isset($_POST['nom']) && !empty($_POST['nom']) &&
        isset($_POST['prenom']) && !empty($_POST['prenom'])
    ) {

        $nom = filter_var($_POST['nom'], FILTER_SANITIZE_STRING);
        $prenom = filter_var($_POST['prenom'], FILTER_SANITIZE_STRING);

        $donnees = array(
            'nom' => $nom,
            'prenom' => $prenom
        );
        $newAbonne = new Abonne ($donnees);
        $resultat = $abonneMgr->createAbonne($newAbonne);

        // Je prépare une variable qui me permettra de savoir si l'insertion c'est bien déroulé
        $tab['resultat'] = false;

        if ( $resultat ) {
            //insert réussit
            $tab['resultat'] = true;
            $tab['abonne'] = array(
                'id' => $bdd->lastInsertId(),
                'nom' => $newAbonne.getNom(),
                'prenom' => $newAbonne.getPrenom()
            );
            echo json_encode($tab);
        }
    }
}

// SUPPRESSION D'UN ABONNE ****************************************************************************************
if (isset($_POST['action']) && $_POST['action'] == 'delete') {  //je recois la requete ajax pour supprimer un abonne
