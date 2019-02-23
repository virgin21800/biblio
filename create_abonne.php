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
			
		</div>
	</div>
</div>
<?php
// On inclut le 'footer' du site
require('inc/footer.php');
?>