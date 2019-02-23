<?php 
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
// On inclut le "connecteur" à la bdd
include_once("../inc/connexion.php");

spl_autoload_register(function ($classe) {
    require_once '../classes/' . $classe . '.class.php';
});

/*récupération de l'id*/
$id = $_GET['id'];

$manager = new AbonneManager($bdd);
$abonneToDelete = $manager->get($id);
$resultat = $manager->delete($abonneToDelete);
if ($resultat) {
		// retour à l'accueil des abonnes si tout s'est bien passé
    $_SESSION['message'] = '<u>!! Genre bien supprimé !!</u>';
    header("Location: ../index_abonne.php");
} else {
    $_SESSION['message'] = 'ERREUR : Le abonne n\'a pas été supprimé !';
    header("Location: ../index_abonne.php");
}