<?php
if (session_status() !== PHP_SESSION_ACTIVE) { session_start(); }
// On inclut le "connecteur" à la bdd
include_once("../inc/connexion.php");

spl_autoload_register(function($classe){
    require_once '../classes/'.$classe.'.class.php';
});

// echo '<pre>';
// var_dump($_POST);
// echo '</pre>';

// On vérifie que TOUS les champs obligatoires existent
if(	isset($_POST['titre']) && !empty($_POST['titre']) &&
    isset($_POST['auteur']) && !empty($_POST['auteur']) ){

    $titre = filter_var($_POST['titre'], FILTER_SANITIZE_STRING);
    $titre = filter_var($_POST['auteur'], FILTER_SANITIZE_STRING);

    $manager = new LivreManager($bdd);
    $donnees = array( [
        'titre'=>$titre,
        'auteur'=>$auteur] );
    $newLivre = $manager->gestionPost($donnees);

	if( $newLivre ){
		// retour à l'accueil des livres si tout s'est bien passé
        $_SESSION['message'] = '<u>!! Livre bien ajouté !!</u>';
        header("Location: ../index_livre.php");
	} else {
        $_SESSION['message'] = 'ERREUR : Le livre n\'a pas été ajouté !';
		header("Location: ../create_livre.php");
    }
} else {
    $_SESSION['message'] = 'ERREUR : Tous les champs sont obligatoires';
    header("Location: ../create_livre.php");
}
?>