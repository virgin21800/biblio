$(document).ready(function () {

    // AFFICHAGE DES ABONNES ****************************************************************************************
    //Initialisation du site et affichage du tableau de données de véhicules
    function showAbonnes() {
        $.post('Traitements.php',  // URL du dossier où s'effectue le traitement
            'action=show', // Valeur à 'envoyer', ici pas de valeurs à envoyer uniquement une indication pour le traitement
            // Fonction de retour du traitement permettant l'affichage (donnees) est le retour du traitement suite à (echo) en PHP
            function (abonnes) { //traitement de la réponse
                //console.log(abonnes); // pensez à vérifier vos données ça peut servir !!
                // je recupère mon tableau d'abonnes et ma variable de contrôle en JSON envoyés par PHP en echo
                if (abonnes.length > 0) {
                    let tab = ''; // on initialise une variable pour mettre en forme le tableau
                    // je parcours mon tableau de Véhicules avec une boucle forEach et oui la même qu'en PHP !! 
                    // et je crée ainsi un tableau HTML contenant les valeurs
                    abonnes.forEach(abonne => {
                        tab += '<tr>';
                        // préparation de l'effacement, mise en place d'un bouton contenant l'ID du véhicule
                        // pour pouvoir la récupérer pour traiter la future requête
                        tab += '<td>' + abonne.nom + '</td>';
                        tab += '<td>' + abonne.prenom + '</td>';
                        tab += '<td><button class="update" type="button" id="' + abonne.id + '">Modifier</button></td>';
                        tab += '<td><button class="delete" type="button" id="' + abonne.id + '">Supprimer</button></td>';
                        tab += '</tr>';
                    });
                    // j'insère mon tableau ainsi crée dans le DOM pour affichage
                    // et j'efface le message si il est affiché
                    if ($('.vide').length > 0) { $('.insert').html(''); }
                    $('.insert').append(tab);
                }
            }, 'json'); // format attendu pour le retour
    }  // fin de la fonction showAbonne

    showAbonnes();

    // AJOUT D'UN ABONNE ****************************************************************************************
    //soumission du formulaire et déclenchement de l'événement
    $('#abonne').on('submit', function (e) {
        e.preventDefault(); //j'annule l'envoie du formulaire
        $('.msg').html(); //j'efface tout dans la div msg

        //je constitue mon paramètre
        let params = 'action=insert&nom=' + $('#nom').val() + '&prenom=' + $('#prenom').val(); // indication pour le traitement en PHP
        let erreurForm = '';
        // je teste tous les champs input un par un si il est vide on stocke un message d'erreur
        // sinon on mémorise la valeur dans une variable 'params'
        // et on le fait pour chaque
        if ($('#nom').val().length == 0) {
            erreurForm += '<div>Le champ "nom" ne peut pas être vide</div>';
        } else {
            params += '&nom=' + $('#nom').val();
        }
        if ($('#prenom').val().length == 0) {
            erreurForm += '<div>Le champ "prénom" ne peut pas être vide</div>';
        } else {
            params += '&prenom=' + $('#prenom').val();
        }

        if (erreurForm.length == 0) {
            // si erreurForm  = 0 alors ca veut dire qu'il n'y a pas d'erreurs
            // j'envoie ma requête ajax
            // console.log(params); // pensez à vérifier vos données ça peut servir !!
            $.post('Traitements.php', // URL du dossier où s'effectue le traitement
                params,  // Valeurs à 'envoyer' contenues dans la variable params
                function (donnees) {
                    //traitement de la réponse
                    if (donnees.resultat === true) {
                        showResultat = '<div>Vous avez ajouté l\'abonné avec succès.</div>';
                        $('#abonne')[0].reset();  // reset du formulaire pour effacer les champs
                        // version avec l'ajout d'une seule ligne et pas de tout le tableau, soyons optimum !!!
                        // même procédure que pour tout le tableau mais sur une seule ligne !!
                        let tab = '';
                        tab += '<tr>';
                        tab += '<td>' + donnees.abonne.nom + '</td>';
                        tab += '<td>' + donnees.abonne.prenom + '</td>';
                        tab += '<td><button class="update" type="button" id="' + donnee.abonne.id + '">Modifier</button></td>';
                        tab += '<td><button class="delete" type="button" id="' + donnee.abonne.id + '">Effacer</button></td>';
                        tab += '</tr>';
                        // j'insère ma ligne ainsi créée dans le DOM pour affichage
                        // et j'efface le message s'il est affiché
                        if ($('.vide').length > 0) { $('.insert').html(''); }
                        $('.insert').append(tab);
                    } else {
                        showResultat = '<div>une erreur est survenue lors de l\'ajout du véhicule !</div>';
                    }
                    // On insère le message de résultat dans le DOM
                    $('.msg').html(showResultat);
                }, 'json')
        } else {
            // Affichage des messages d'erreurs suivant les champs Input vides
            $('.msg').html(erreurForm);
        }
    }); //fin de l'event

    // SUPPRESSION D'UN ABONNE ****************************************************************************************
    $('.insert').on('click', '.delete', function (e) {
        e.preventDefault(); //j'annule l'envoie du formulaire
        $('.msg').html(); //j'efface tout dans la div msg

        let idToDelete = $(this).attr('id');
        let rowToDelete = $(this).closest('tr');
        let choix = confirm ('Voulez-vous supprimer l\'abonné n° ' + idToDelete + '?');

        if (choix){
            // Traitement Ajax de la suppression
            params = 'action=delete&id=' + idToDelete;
            $post('Traitements.php',
                params,
                function (deleteRow){
                    if (deleteRow){
                        rowToDelete.remove();
                    }
                }, 'json');
        }
    }); //fin de l'event de suppression


}) //fin du document ready