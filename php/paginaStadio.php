<?php
    require_once("start_session.php");
    if(!isset($_SESSION['Username']) || !isset($_GET['stadio'])){
		header("Location: ./php/login.php");
		exit;
	}
    $utente = $_SESSION['Username'] ?? null;
    $fotoProfiloUtenteLoggato = $_SESSION['PathFotoProfiloUtente'] ?? null;
    $nomeStadio = $_GET['stadio'] ?? null;
?>
<!DOCTYPE html>
<html lang="it">
    <head>
        <title>Diario del tifoso-Pagina Stadio</title>
        <link rel="stylesheet" href="../css/shared.css">
        <link rel="stylesheet" href="../css/paginaStadio.css">
        <link rel="icon" href="./src/images/logo_sito.png" type="image/ico">
    </head>
    <body data-nome-stadio = "<?php echo $nomeStadio?>">
        <header class="header_sito">
            <div class="high_left">
                <a href="../index.php">
                    <img src="../src/images/logo_sito.png" alt="Logo Sito" id="logo_sito_hl">
                </a>
            </div>
            <h1>Diario del Tifoso</h1>
            <div class="high_right">
                <a href="paginaUtente.php?username=<?php echo $_SESSION['Username']; ?>">
                    <img src="<?php echo $fotoProfiloUtenteLoggato?>" alt="Foto Profilo" class="profile-pic">
                </a>
            </div>
        </header>
        <div id="contenitore_nome_stadio">
                <h1><?php echo $nomeStadio?></h1>
        </div>
        <main class="main_sito">
            <aside class="sidebar left-sidebar">
                <h2>Valutazioni</h2>
            </aside>
            <section class="bacheca">
                <h2>Recensioni</h2>
                <div id="contenitore_post">

                </div>
            </section>
        </main>
    </body>
</html>