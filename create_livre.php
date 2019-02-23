<?php
if (session_status() !== PHP_SESSION_ACTIVE) { session_start(); }
// On inclut le 'header' du site
include_once ("inc/header.php");

?>

<div class="container-fluid">
<!-- Ici on traite les messages de retour des différentes exécution en vérifiant si un message est présent en Session
et si oui en l'affichant puis en l'effaçant de la session. -->
	<div class="row text-center">
		<div class="col-6 mx-auto">
			<?php
				if ( isset($_SESSION['message']) && !empty($_SESSION['message']) ) {
					echo '<p class="text-danger">'.$_SESSION['message'].'</p>';
					unset($_SESSION['message']);
					session_destroy();
				}
			?>
		</div>
	</div>

	<div class="row">
		<div class="col-10 mx-auto">
			<form class="border border-dark rounded bg-dark p-4" action="traitements/create_abonne_traitement.php" method="POST">
				<h2 class="text-default text-center"><strong>Ajouter un nouveau livre</strong></h2><br>
				<p>
					<label for="titre">Titre</label>
					<input class="bg-dark border-default form-control"placeholder="(champ obligatoire)" type="text" name="titre" id="titre" class="form-control" required>
				</p>
				<p>
					<label for="auteur">Auteur</label>
					<textarea row=3 class="bg-dark border-default form-control text-white" placeholder="(champ obligatoire)" name="auteur" id="auteur"></textarea>
				</p>
				<p class="d-flex justify-content-around">
					<input type="submit" class="btn btn-default text-center" name="envoyer" value="envoyer" id="envoyer">
					<input type="button" class="btn btn-outline-default text-center"
							onclick="window.location.replace('index_abonne.php')" value="ANNULER" /> <!-- Bouton d'annulation -->
				</p>
			</form>
		</div>
	</div>
</div>
<?php
// On inclut le 'footer' du site
require('inc/footer.php');
?>