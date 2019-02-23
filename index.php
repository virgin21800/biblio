<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}
// On inclut le 'header' du site
include_once("inc/header.php");
// On inclut le "connecteur" à la bdd
include_once("inc/connexion.php");

spl_autoload_register(function ($classe) {
	require_once 'classes/' . $classe . '.class.php';
});

$manager = new EmpruntsManager($bdd);
$emprunts = $manager->getAll();
?>

<main class="container-fluid">

	<div class="row text-center">
		<div class="col-6 mx-auto">
			<?php
		if (isset($_SESSION['message']) && !empty($_SESSION['message'])) {
			echo '<p class="text-danger font-weight-bold" style="font-size: 1.5rem;">' . $_SESSION['message'] . '</p>';
			unset($_SESSION['message']);
			session_destroy();
		}
		?>
		</div>
	</div>

	<div class="row">
		<div class="col-10 mx-auto border border-dark rounded bg-dark p-4 mt-5">
		<table class="table table-striped table-hover table-bordered table-fixed z-depth-3">
			<thead class="table-bordered text-center text-white darken-4">
					<tr>
						<th>Livre</th>
						<th>Abonne</th>
						<th>Date d'emprunt</th>
					</tr>
				</thead>
				<tbody class="table-bordered text-center">
					<?php foreach ($emprunts as $emprunt) : ?>
					<tr>
						<td><?= $emprunt->getIdlivre() ?></td>
						<td><?= $emprunt->getIdabonne() ?></td>
						<td><?= $emprunt->getDateemprunt() ?></td>

						<td><?php $genres = $manager->getListeGenres($emprunt->getId());
						foreach ($genres as $genre) : ?>
							<?= $genre->getTitre() . ', ' ?>
						<?php endforeach; ?></td>
						<td><?php $editeurs = $manager->getListeEditeurs($emprunt->getId());
						foreach ($editeurs as $editeur) : ?>
							<?= $editeur->getNom() . ', ' ?>
						<?php endforeach; ?></td>
						<td><?php $supports = $manager->getListeSupports($emprunt->getId());
						foreach ($supports as $support) : ?>
							<?= $support->getNom() . ', ' ?>
						<?php endforeach; ?></td>
						<td><a href="update_emprunt.php?id=<?= $emprunt->getId(); ?>"><i class="fas fa-edit fa-2x teal-text"></i></a></td>
						<td><a href="traitements/delete_emprunt_traitement.php?id=<?= $emprunt->getId(); ?>" class="confirmation"><i class="fas fa-trash-alt fa-2x red-text"></i></a></td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</main>
<?php
// On inclut le 'footer' du site
require('inc/footer.php');
?>
</body>
</html>