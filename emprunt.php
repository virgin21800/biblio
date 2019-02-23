<?php require_once 'inc/header.php'; 
require_once 'inc/connexion.php';
spl_autoload_register(function($classe){
  require_once 'classes/'.$classe.'.class.php';
});

$managerAbonne = new AbonneManager($bdd);
$managerLivre = new LivreManager($bdd);
$abonnes_Tab = $managerAbonne->getListAbonne();
$livres_Tab = $managerLivre->getListLivre();
?>

 <div class="container-fluid">

<!--******************************* tableau ***********************************************************-->
	<div class="row">
		<div class="col-10 mx-auto">
			<div class='table-responsive my-4'>
			 <!--Table-->
				 <table class="table table-sm table-striped text-center">

					<thead>
						<tr>
							<th class="font-weight-bold">id_emprunt</th>
							<th class="font-weight-bold">Abonne</th>
							<th class="font-weight-bold">Livre</th>
							<th class="font-weight-bold">Modification</th>
							<th class="font-weight-bold">Suppression</th>
						</tr>
					</thead>

					<tbody class="insert">
					</tbody>

				 </table>
			<!--Table-->
			</div>
		</div>
	</div>  <!-- fin de row -->

<!-- ************************************ formulaire d'ajout ******************************************-->
    <div class="row">
        <div class="col-10 mx-auto">
            <form id="emprunt">

                <label for="id_abonne" class="font-weight-bold">Abonné</label>
				<select class="form-control my-2" name="id_abonne" id="id_abonne">
				<option value="" selected disabled>Choisir l'abonné</option>
					<?php foreach ($abonnes_Tab as $key => $value): ?>
						<option value="<?=$value['id_abonne']?>"><?php echo $value['prenom'].' '.$value['nom']?></option>
					<?php endforeach; ?>
				</select>

                <label for="id_livre" class="font-weight-bold">Livre</label>				
				<select class="form-control my-2" name="id_livre" id="id_livre">
				<option value="" selected disabled>Choisir le livre</option>
					<?php foreach ($livres_Tab as $key => $value): ?>
						<option value="<?=$value['id_livre']?>"><?php echo $value['titre'].' de '.$value['auteur']?></option>
					<?php endforeach; ?>
				</select>							

                <label for="date_emprunt" class="font-weight-bold">Date d'emprunt</label>
                <input class="form-control my-2" type="date" name="date_emprunt" id="date_emprunt" placeholder="date d'emprunt" required>                

                <input type="submit" class="btn btn-outline-blue-grey my-4"  id="envoyer" name="envoyer" value="Ajouter cet emprunt">

            </form>
        </div>
    </div>  <!-- fin de row -->

</div>  <!-- fin du Container-fluid -->

<!--********************* Modal du formulaire d'Update *******************************************-->
<div class="modal fade" id="modalLoginForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

        <div class="modal-header text-center">
            <h4 class="modal-title w-100 font-weight-bold"></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div> 

        <div class="modal-body mx-3">
            <form id="livre_update">

                <label for="titre" class="font-weight-bold">Titre</label>
                <input class="form-control mb-4" type="text" name="titre_update" id="titre_update">

                <label for="auteur" class="font-weight-bold">Auteur</label>
                <input class="form-control mb-4" type="text" name="auteur_update" id="auteur_update">

            </form>
        </div>

      <div class="modal-footer d-flex justify-content-center">
            <button type="submit" class="btn btn-outline-blue-grey" id="btnSaveIt">Modifier ce livre</button>
            <button type="button" class="btn btn-blue-grey" id="btnCloseIt" data-dismiss="modal">Annuler</button>
      </div>

    </div>
  </div>
</div>
<!--********************* Modal du formulaire d'Update *******************************************-->
<?php
	$js = ['emprunt'];
	require_once('inc/footer.php');
?>