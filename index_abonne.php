<?php
if (session_status() !== PHP_SESSION_ACTIVE) { session_start(); }
// On inclut le 'header' du site
include_once("inc/header.php");
// On inclut le "connecteur" à la bdd
include_once("inc/connexion.php");
spl_autoload_register(function($classe){
	require_once 'classes/'.$classe.'.class.php';
  });

$manager = new AbonneManager($bdd);
$abonnes = $manager->getAll();
?>
<div class="container-fluid">
	<div class="row">
		<div class="col-10 mx-auto border border-dark rounded bg-dark p-4 mt-5">
			<h3 class="text-default text-center my-2 display-5"><strong>Gestion des abonnes</strong></h3><br>
			<table class="table table-striped table-hover table-bordered table-fixed z-depth-3">
				<thead class="table-bordered text-center text-white darken-4">
					<tr>
						<th>Nom</th>
						<th>Prenom</th>
						<th>Modification</th>
						<th>Suppression</th>
					</tr>
				</thead>
				<tbody class="insert table-bordered text-center">
					<tr>
						<td class='vide' colspan='4'>Aucun abonné à afficher</td>
					</tr>
				</tbody>
			</table>
			<form id="abonne" class="border border-dark rounded bg-dark p-4">
				<h5 class="text-default my-2 display-5"><strong>Données de l'abonné</strong></h5><br>
				<p>
					<label for="nom">Nom</label>
					<input class="bg-dark border-default form-control"placeholder="(champ obligatoire)" type="text" name="nom" id="nom" class="form-control" required>
				</p>
				<p>
					<label for="prenom">Prenom</label>
					<textarea row=3 class="bg-dark border-default form-control text-white" placeholder="(champ obligatoire)" name="prenom" id="prenom"></textarea>
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
	$js = ['abonne'];
	require_once('inc/footer.php');
?>