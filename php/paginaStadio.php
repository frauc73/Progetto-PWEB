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
        <link rel="stylesheet" href="../css/renderingPost.css">
        <link rel="icon" href="../src/images/logo_sito.png" type="image/ico">
        <script src="../js/renderingPost.js"></script>
        <script src="../js/paginaStadio.js"></script>
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
                <div id="contenitore_valutazioni">
                    
                </div>
            </aside>
            <section class="bacheca">
                <h1>Recensioni</h1>
                <div id="contenitore_filtro_recensione" class="contenitore_filtro_recensione">
                    <div class="filtro_recensione">
                        <input type="radio" id="filtro_tutti" name="filtro_recensione" value="tutti" checked>
                        <label for="filtro_tutti">Tutti</label>

                        <input type="radio" id="filtro_curva" name="filtro_recensione" value="Curva">
                        <label for="filtro_curva">Curva</label>

                        <input type="radio" id="filtro_distinti" name="filtro_recensione" value="Distinti">
                        <label for="filtro_distinti">Distinti</label>

                        <input type="radio" id="filtro_tribuna" name="filtro_recensione" value="Tribuna">
                        <label for="filtro_tribuna">Tribuna</label>

                        <input type="radio" id="filtro_tribuna_autorita" name="filtro_recensione" value="Tribuna Autorità">
                        <label for="filtro_tribuna_autorita">Tribuna Autorità</label>

                        <input type="radio" id="filtro_settore_ospiti" name="filtro_recensione" value="Settore Ospiti">
                        <label for="filtro_settore_ospiti">Settore Ospiti</label>
                    </div>
                </div>
                <div id="contenitore_post">

                </div>
            </section>
        </main>
    </body>
</html>