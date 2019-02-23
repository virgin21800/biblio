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
if(	isset($_POST['nom']) && !empty($_POST['nom']) &&
    isset($_POST['prenom']) && !empty($_POST['prenom']) ){

    $nom = filter_var($_POST['nom'], FILTER_SANITIZE_STRING);
    $nom = filter_var($_POST['prenom'], FILTER_SANITIZE_STRING);

    $manager = new AbonneManager($bdd);
    $donnees = array( [
        'nom'=>$nom,
        'prenom'=>$prenom] );
    $newAbonne = $manager->gestionPost($donnees);

	if( $newAbonne ){
		// retour à l'accueil des abonnes si tout s'est bien passé
        $_SESSION['message'] = '<u>!! Abonne bien ajouté !!</u>';
        header("Location: ../index_abonne.php");
	} else {
        $_SESSION['message'] = 'ERREUR : L\'abonne n\'a pas été ajouté !';
		header("Location: ../create_abonne.php");
    }
} else {
    $_SESSION['message'] = 'ERREUR : Tous les champs sont obligatoires';
    header("Location: ../create_abonne.php");
}
?>