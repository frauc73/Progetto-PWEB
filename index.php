<?php
	require_once("./php/start_session.php");
	if(!isset($_SESSION['Username'])){
		header("Location: ./php/login.php");
		exit;
	}
	$utente = $_SESSION['Username'] ?? null;
	$fotoProfiloUtenteLoggato = str_replace("../", "./", $_SESSION['PathFotoProfiloUtente']) ?? null;
?>
<!DOCTYPE html>
<html lang="it">
	<head>
	<meta charset="UTF-8">
        <title>Diario del tifoso-Homepage</title>
        <link rel="stylesheet" href="./css/shared.css">
		<link rel="stylesheet" href="./css/homepage.css">
        <link rel="stylesheet" href="./css/renderingPost.css">
        <link rel="icon" href="./src/images/logo_sito.png" type="image/ico">
        <script src="./js/homepage.js"></script>
		<script src="./js/renderingPost.js"></script>
	</head>
	<body data-utente-loggato = "<?php echo $utente?>">
		<header class="header_sito">
            <div class="high_left">
                <img src="./src/images/logo_sito.png" alt="Logo Sito" id="logo_sito_hl">
            </div>
            <h1>Diario del Tifoso</h1>
			<div id="contenitore_bottone_ricerca">
				<button id="ricerca">
					<img src="./src/icons/ricerca.png" alt="Icona di ricerca">
				</button>
				<div id="tendina_ricerca" class="hidden">
					<h2>Cerca</h2>
					<input type="text" id="barra_ricerca" class="barra_ricerca" placeholder="Cerca...">
					<div id="contenitore_ricerca">

					</div>
				</div>
			</div>
            <div class="high_right">
                <a href="./php/paginaUtente.php?username=<?php echo $_SESSION['Username']; ?>">
                    <img src="<?php echo $fotoProfiloUtenteLoggato?>" alt="Foto Profilo" class="profile-pic">
                </a>
            </div>
        </header>
		<main class="main_sito">
			<aside class="sidebar left-sidebar">
				<div id="icona_menu" class="icona_menu">
					<img src="./src/icons/menu-a-tendina.png" alt="Icona menù a tendina">
				</div>
				<div id="menu_tendina" class="menu_tendina">
					<button id="chiudi_menu" class="chiudi_menu">&times;</button>
					<div>
						<a href="./php/evento.php">
							<h2>Inserisci un evento</h2>
						</a>

						<hr class="separatore_menu">

						<a href="./php/recensione.php">
							<h2>Inserisci una recensione</h2>
						</a>
						
						<hr class="separatore_menu">

						<a href="./php/paginaUtente.php">
							<h2>Modifica il tuo profilo</h2>
						</a>
						
						<hr class="separatore_menu">

						<a href="./php/logout.php" id="ancora_logout">
							<h2>Logout</h2>
						</a>
						<a href="./html/manualeUtente.html" id="manuale_utente"> Manuale Utente</a>
					</div>
			</aside>
			<section class="bacheca">
				<div id="contenitore_post">

				</div>
			</section>
			<aside class="sidebar right-sidebar">
			</aside>
		</main>
		<footer>
            <small>
                Progetto di Progettazione Web | Professore: Alessio Vecchio - Studente: Francesco Lombardo | Università di Pisa
            </small>
        </footer>
	</body>
</html>
