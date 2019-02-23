<!DOCTYPE html>

<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- 	On inclut les librairies MDB Bootstrap -->

    <?php include_once("inc/lib.php"); ?>
    <style>
        html,body {
			height:105%;
			background-image: url("inc/img/livres.jpg");
			background-size: cover;
			background-repeat: no-repeat;
			color: white;
		}
		a{
			color: #528393!important;
		}
}
	</style>
    <link rel="shortcut icon" type="image/x-icon" href="inc/img/favicon.ico" />
    <title>Bibliotheque.com</title>
</head>

<body>

    <header>
        <!-- La barre de navigation -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark darken-4 darken-4 z-depth-2 mb-5">
            <a class="navbar-brand" href="index.php">
                <img src="inc/img/logo.png" height="30" class="d-inline-block align-top mx-3" alt="">Bibliotheque.com
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="nav nav-pills ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index_abonne.php">Abonnés</a>
                    </li>
					<li class="nav-item">
                        <a class="nav-link" href="index_livre.php">Livres</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index_emprunt.php">Emprunts</a>
                    </li>
                    <li class="nav-item dropdown mx-3">
				<a class="nav-link dropdown-toggle bg-dark" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          			Nouveau...
				</a>
				<div class="dropdown-menu bg-dark" aria-labelledby="navbarDropdown">
	                <a class="nav-link bg-dark" href="create_livre.php">Ajout d'un livre</a>
					<a class="nav-link bg-dark" href="create_abonne.php">Ajout d'un abonne</a>
					<a class="nav-link bg-dark" href="create_emprunt.php">Ajout d'un emprunt</a>
				</div>
	            </li>
                    <li class="nav-item mx-4">
                        <a class="nav-link active bg-default" href="index.php">Accueil</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>