<?php require_once 'inc/header.php'; ?>

 <div class="container-fluid">

<!--******************************* tableau ***********************************************************-->
	<div class="row">
		<div class="col-10 mx-auto">
			<div class='table-responsive my-4'>
			 <!--Table-->
				 <table class="table table-sm table-striped text-center">

					<thead>
						<tr>
							<th class="font-weight-bold">id_livre</th>
							<th class="font-weight-bold">Titre</th>
							<th class="font-weight-bold">Auteur</th>
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
            <form id="livre">

                <label for="titre" class="font-weight-bold">Titre</label>
                <input class="form-control mb-4" type="text" name="titre" id="titre" placeholder="titre" required>

                <label for="auteur" class="font-weight-bold">Auteur</label>
                <input class="form-control mb-4" type="text" name="auteur" id="auteur" placeholder="auteur" required>

                <input type="submit" class="btn btn-outline-blue-grey"  id="envoyer" name="envoyer" value="Ajouter ce livre">

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
	$js = ['livre'];
	require_once('inc/footer.php');
?>