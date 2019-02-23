<?php
if (session_status() !== PHP_SESSION_ACTIVE) { session_start(); }
// On inclut le 'header' du site
include_once("inc/header.php");
// On inclut le "connecteur" à la bdd
include_once("inc/connexion.php");
spl_autoload_register(function($classe){
	require_once 'classes/'.$classe.'.class.php';
  });

$manager = new LivreManager($bdd);
$livres = $manager->getAll();
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
		<div class="col-10 mx-auto border border-dark rounded bg-dark p-4 mt-5">
			<h3 class="text-default text-center my-2 display-5"><strong>Gestion des livres</strong></h3><br>
			<table class="table table-striped table-hover table-bordered table-fixed z-depth-3">
				<thead class="table-bordered text-center text-white darken-4">
					<tr>
						<th>Titre</th>
						<th>Auteur</th>
						<th>Modification</th>
						<th>Suppression</th>
					</tr>
				</thead>
				<tbody class="table-bordered text-center">
					<?php foreach ($livres as $value):?>
					<tr>
						<td><?= $value->getTitre() ?></td>
						<td><?= $value->getAuteur() ?></td>
						<td><a href="update_livre.php?id=<?= $value->getId();?>"><i class="fas fa-edit fa-2x teal-text"></i></a></td>
						<td><a href="traitements/delete_livre_traitement.php?id=<?= $value->getId();?>" class="confirmation"><i class="fas fa-trash-alt fa-2x red-text"></i></a></td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<?php
// On inclut le 'footer' du site
require('inc/footer.php');
?>
<script type="text/javascript">
$(document).ready(function(){
	
	$('.confirmation').on('click', function () {
		return confirm ('Voulez-vous vraiment supprimer ce livre ?');
	});	
});	
</script>