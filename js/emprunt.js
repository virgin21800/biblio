$(document).ready(function(){

// AFICHAGE DU TABLEAU D'EMPRUNTS ***************************************************************************************************
function afficheEmprunt() {
    $.post ('Traitement.php',  // URL du dossier où s'effectue le traitement
            'action=affiche_emprunt', // Valeur à 'envoyer', ici pas de valeurs à envoyer uniquement une indication pour le traitement
            function (emprunts) {
                if(emprunts.length > 0){
                    let tab=''; 
                    emprunts.forEach(emprunt => {
                        tab += '<tr>';
                            tab += '<td>'+emprunt.id_emprunt+'</td>';                           
                            tab += '<td><p>'+emprunt.prenom+' '+emprunt.nom+'</p><p>'+emprunt.id_abonne+'</p></td>';
                            tab += '<td><p>'+emprunt.titre+'</p><p>'+emprunt.auteur+'</p><p>'+emprunt.id_livre+'</p></td>';
                            tab += '<td><i id='+emprunt.id_livre+' class="modifier fas fa-pen blue-text"></i></td>';     
                            tab += '<td><i id='+emprunt.id_livre+' class="effacer fas fa-times blue-text"></i></td>';                                
                            tab += '</tr>';
                    });
                    $('.insert').append(tab);
                }
            }, 'json'); // format attendu pour le retour
}  // fin de la fonction afficheAbonne

afficheEmprunt();

//  AJOUT D'UN EMPRUNT **************************************************************************************************************
//soumission du formulaire et déclenchement de l'événement
$('#emprunt').on('submit', function(e){
    e.preventDefault(); //j'annule l'envoi du formulaire
    //je constitue mon paramètre
    let params='action=ajout_emprunt&id_abonne='+$('#id_abonne option:selected').val()+'&id_livre='+$('#id_livre option:selected').val()+'&date_emprunt='+$('#date_emprunt').val();
    $.post('Traitement.php', // URL du dossier où s'effectue le traitement
            params,  // Valeurs à 'envoyer' contenues dans la variable params
            function (ajout) {  
            	console.log(ajout);
 				if (ajout) {
                    $('#emprunt')[0].reset();  // reset du formulaire pour effacer les champs
                    $('.insert').html('');
                    afficheEmprunt(); 						
            	}
            }, 'json');
}); //fin de l'event d'ajout

}) //fin du document ready