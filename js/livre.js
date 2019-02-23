$(document).ready(function(){

// AFICHAGE DU TABLEAU DE LIVRES ***************************************************************************************************
function afficheLivre() {
    $.post ('Traitement.php',  // URL du dossier où s'effectue le traitement
            'action=affiche_livre', // Valeur à 'envoyer', ici pas de valeurs à envoyer uniquement une indication pour le traitement
            function (livres) { 
                if(livres.length > 0){
                    let tab=''; 
                    livres.forEach(livre => {
                        tab += '<tr>';
                            tab += '<td>'+livre.id_livre+'</td>';                           
                            tab += '<td>'+livre.titre+'</td>';
                            tab += '<td>'+livre.auteur+'</td>';
                            tab += '<td><i id='+livre.id_livre+' class="modifier fas fa-pen blue-text"></i></td>';     
                            tab += '<td><i id='+livre.id_livre+' class="effacer fas fa-times blue-text"></i></td>';                                
                            tab += '</tr>';
                    });
                    $('.insert').append(tab);
                }
            }, 'json'); // format attendu pour le retour
}  // fin de la fonction afficheAbonne

afficheLivre();

//  AJOUT D'UN LIVRE **************************************************************************************************************
//soumission du formulaire et déclenchement de l'événement
$('#livre').on('submit', function(e){
    e.preventDefault(); //j'annule l'envoi du formulaire
    //je constitue mon paramètre
    let params='action=ajout_livre&titre='+$('#titre').val()+'&auteur='+$('#auteur').val();
    // console.log(params); // pensez à vérifier vos données ça peut servir !!
    $.post('Traitement.php', // URL du dossier où s'effectue le traitement
            params,  // Valeurs à 'envoyer' contenues dans la variable params
            function (ajout) {  
 				if (ajout) {
                    $('#livre')[0].reset();  // reset du formulaire pour effacer les champs
                    $('.insert').html('');
                    afficheLivre(); 						
            	}
            }, 'json');
}); //fin de l'event d'ajout


// EFFACEMENT D'UN LIVRE *************************************************************************************************************
$('.insert').on('click','.effacer', function(e) {
	e.preventDefault();
	let efface_id = $(this).attr('id');
	let ligne_a_effacer = $(this).closest('tr');
	let choix = confirm('Voulez vous effacer le livre n° '+efface_id);
	if (choix) {
		// traitement ajax de l'effacement
		params = 'action=supprime_livre&id_livre='+efface_id;
	    $.post('Traitement.php', // URL du dossier où s'effectue le traitement
	            params,  // Valeurs à 'envoyer' contenues dans la variable params
	            function (supprime) {  
	 				if (supprime) {
	 					// on efface uniquement la ligne qui vient d'être effacé en BDD dans le tableau
	 					ligne_a_effacer.remove();					
	            	}
	            }, 'json');	// fin de l'ajax   	
	}
}); // fin de l'event d'effacement


// UPDATE D'UN ABONNE ****************************************************************************************************************
// ouverture de la modal avec les infos de l'abonné à modifier
var update_id = ''; // sauvegarde de l'id de l'abonné à modifier utilisé dans les deux fonctions Ajax qui suivent donc on le garde au chaud
var ligne_a_modifier = '';

$('.insert').on('click','.modifier', function(e) {
	e.preventDefault();
	update_id = $(this).attr('id');
	ligne_a_modifier = $(this).closest('tr');
	infos_livre = 'action=get_livre&id_livre='+update_id;
    $.post('Traitement.php', // URL du dossier où s'effectue le traitement
            infos_livre,  // Valeurs à 'envoyer' contenues dans la variable params
            function (infos) {  
            	$('.modal-title').html('Modification du livre n° '+update_id);
				$('#titre_update').val(infos.titre);	
				$('#auteur_update').val(infos.auteur);
				$('#modalLoginForm').modal('show');					
            }, 'json');	// fin de l'ajax
});	

// validation des modifications et mise à jour de la BDD
$("#btnSaveIt").on('click', function (e) {
	e.preventDefault();
	let update_titre = $('#titre_update').val();
	let update_auteur = $('#auteur_update').val();
	let params='action=modification_livre&id_livre='+update_id+'&titre='+update_titre+'&auteur='+update_auteur;
	console.log(params);
    $.post('Traitement.php', // URL du dossier où s'effectue le traitement
            params,  // Valeurs à 'envoyer' contenues dans la variable params
            function (update) {
            	console.log(update);
            	if (update) {
                    $('#livre_update')[0].reset();  // reset du formulaire pour effacer les champs juste pour être propre !!
                    // on ne va remettre à jour à l'écran uniquement la ligne qui vient d'être modifié en BDD dans le tableau
                    let ligne=''; 
                    ligne += '<tr>';
                        ligne += '<td>'+update_id+'</td>';                           
                        ligne += '<td>'+update_titre+'</td>';
                        ligne += '<td>'+update_auteur+'</td>';
                        ligne += '<td><i id='+update_id+' class="modifier fas fa-pen blue-text"></i></td>';   
                        ligne += '<td><i id='+update_id+' class="effacer fas fa-times blue-text"></i></td>';                                
     				ligne += '</tr>';
                    ligne_a_modifier.replaceWith(ligne);				
            	}
				$('#modalLoginForm').modal('hide');
				update_id=''; // on reset les variables de sauvegarde toujours pour être propre !!
				ligne_a_modifier = '';
            }, 'json');	// fin de l'ajax
});

}) //fin du document ready