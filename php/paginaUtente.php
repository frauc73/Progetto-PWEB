<?php
    $nomeUtente = null;
    $congomeUtente = null;
    $descrizioneProfilo = null;
    $pathFotoProfilo = null;
    $squadraSupportata = null;
    $fotoProfiloUtenteLoggato = null;
    $isOwner = null;
    $loggedFollowUser = null;
    require_once("start_session.php");
    if(isset($_SESSION['Username'])){
        //recupero i dati sull'utente loggato;
        $loggedUser = $_SESSION['Username'];
        $profileUser = $_GET['username'] ?? $loggedUser;
        $isOwner = ($loggedUser === $profileUser);
        //mi connetto al database
        require_once("dbaccess.php");
        $connection = mysqli_connect(DBHOST,DBUSER,DBPASS,DBNAME);
        if(mysqli_connect_errno()){
            die(mysqli_connect_error());
        }
        if(!$isOwner){
            $fotoProfiloUtenteLoggato = $_SESSION['PathFotoProfiloUtente'] ?? null;
        }
        //recuperiamo i dati dell'utente per riempire la pagina iniziale, senza foto
        $sql = "SELECT Users.Nome, Users.Cognome, Users.PathFotoProfilo, 
               Users.NomeSquadraSupportata, Users.DescrizioneProfilo, 
               DS.Campionato, DS.Paese 
        FROM Users 
        LEFT JOIN dati_squadre DS ON Users.NomeSquadraSupportata = DS.Nome 
        WHERE Users.Username = ?";
        if($stmt = $connection->prepare($sql)){
            $stmt->bind_param("s", $profileUser);
            $stmt->execute();
            $result = $stmt->get_result();
            if($result->num_rows == 0){
                $result->free();
                $stmt->close();
                $connection->close();
                header("Location: index.php?error=utente_non_trovato");
                exit;
            } else {
                //qui possiamo usare il risultato della query
                $row = $result->fetch_assoc(); 
                $nomeUtente = $row['Nome'];
                $congomeUtente = $row['Cognome'];
                $pathFotoProfilo = $row['PathFotoProfilo'] ?? null;
                $descrizioneProfilo = $row['DescrizioneProfilo'] ?? null;
                $squadraSupportata = isset($row['NomeSquadraSupportata']) ? trim($row['NomeSquadraSupportata']) : null;
                if ($squadraSupportata === '')
                    $squadraSupportata = null;
                $campionatoSquadra = $row['Campionato'] ?? null;
                $paeseSquadra = $row['Paese'] ?? null;
                if ($squadraSupportata && $paeseSquadra && $campionatoSquadra) {
                    $pathLogoSquadra = "../src/loghi_squadre/" . 
                                       rawurlencode($paeseSquadra) . "-" . 
                                       rawurlencode($campionatoSquadra) . "/" . 
                                       rawurlencode($squadraSupportata) . ".png";
                } else {
                    $pathLogoSquadra = null;
                }
            }
        if(!$isOwner){
            //recuperiamo l'informazione relativa al follow
            $loggedFollowUser = false;
            $queryFollowing = "SELECT COUNT(*) as num FROM Following WHERE User = ? AND Followed = ?";
            $stmtQueryFollowing = $connection->prepare($queryFollowing);
            $stmtQueryFollowing->bind_param("ss", $loggedUser, $profileUser);
            if($stmtQueryFollowing->execute()){
                $resultFollowing = $stmtQueryFollowing->get_result();
                $rowFollowing = $resultFollowing->fetch_assoc();
                if($rowFollowing["num"] == 1){
                    //esiste una corrispondenza tra utente loggato e utente della pagina nella tabella Following
                    $loggedFollowUser = true;
                }
                $resultFollowing->free_result();
            } else {
                echo json_encode(['success' => false, 'message' => 'Errore nell\'esecuzione della query di controllo.']);
                die(mysqli_connect_error());
                exit();
            }
            $stmtQueryFollowing->close();
        }
        $stmt->close();
        $connection->close();
        } else {
            die(mysqli_connect_error());
        }
    }  
?>
<!DOCTYPE html>
<html lang="it">
    <head>
        <meta charset="UTF-8">
        <title>Diario del tifoso-Pagina Utente</title>
        <link rel="stylesheet" href="../css/shared.css">
        <link rel="stylesheet" href="../css/paginaUtente.css">
        <link rel="stylesheet" href="../css/renderingPost.css">
        <link rel="icon" href="../src/images/logo_sito.png" type="image/ico">
        <script src="../js/renderingPost.js"></script>
        <script src="../js/paginaUtente.js"></script>
    </head>
    <body data-is-owner="<?php echo $isOwner ? 'true' : 'false'; ?>" data-current-profile-user="<?php echo htmlspecialchars($profileUser); ?>" data-following = "<?php echo $loggedFollowUser ? 'true' : 'false'; ?>">
        <header class="header_sito">
            <div class="high_left">
                <a href="../index.php">
                    <img src="../src/images/logo_sito.png" alt="Logo Sito" id="logo_sito_hl">
                </a>
            </div>
            <h1>Diario del Tifoso</h1>
            <div class="high_right">
                <?php if (!$isOwner): ?>
                    <a href="paginaUtente.php?username=<?php echo $_SESSION['Username']; ?>">
                        <img src="<?php echo $fotoProfiloUtenteLoggato?>" alt="Foto Profilo" class="profile-pic">
                    </a>
                <?php else: ?>
                    <a href="../index.php">
                        <button>
                            <img src = "../src/icons/icons8-home-page-64.png" alt="Icona Home" class="logo_back_home">
                        </button>
                    </a>
                <?php endif; ?>
            </div>
        </header>
        <main class="main_sito">
            <aside class="sidebar left-sidebar">
                <div id="contenitore_foto_profilo">
                    <img src="<?php echo $pathFotoProfilo ?>" alt="Foto Profilo" id="foto_profilo">
                    <div id="contenitore_azioni_utente">
                        <?php if($isOwner): ?>
                            <button id="modifica_foto_profilo" class="bottone_pagina_utente">Modifica</button>
                        <?php elseif($loggedFollowUser !== null): ?>
                            <?php if(!$loggedFollowUser): ?>
                                <button id="follow_utente" class="bottone_pagina_utente">Segui</button>
                            <?php else: ?>
                                <button id="unfollow_utente" class="bottone_pagina_utente">Smetti di seguire</button>
                            <?php endif;?>
                        <?php endif;?>
                    </div>
                </div>
                <h1 class="usernameUtente"><?php echo ($profileUser) ?></h1>
                <h2 class="nomeCognomeUtente"><?php echo ($nomeUtente . ' ' . $congomeUtente) ?></h2>
                <div id="contenitore_notifiche">
                    
                </div>
            </aside>
            <section class="bacheca">
                <div id="contenitore_filtro_post" class="contenitore_filtro_post">
                    <div class="filtro_post">
                        <input type="radio" id="filtro_tutti" name="filtro_post" value="tutti" checked>
                        <label for="filtro_tutti">Tutti</label>

                        <input type="radio" id="filtro_eventi" name="filtro_post" value="eventi">
                        <label for="filtro_eventi">Eventi</label>

                        <input type="radio" id="filtro_recensioni" name="filtro_post" value="recensioni">
                        <label for="filtro_recensioni">Recensioni</label>
                    </div>
                </div>
                <div id="contenitore_post">
                                
                </div>
            </section>
            <aside class="sidebar right-sidebar">
                <div>
                    <h2>Descrizione Profilo</h2>
                    <p id="testo_descrizione"><?php echo $descrizioneProfilo ? $descrizioneProfilo : "Nessuna descrizione presente" ?></p>
                    <?php if($isOwner): ?>
                        <button id="modifica_descrizione" class="bottone_pagina_utente">Modifica</button>
                    <?php endif;?>
                </div>
                <div>
                    <h2>Squadra Supportata</h2>
                    <div id="contenitore_squadra_supportata">
                        <p id="testo_squadra_supportata"><?php echo $squadraSupportata ? $squadraSupportata : "Nessuna squadra supportata" ?></p>
                        <img src="<?php echo $pathLogoSquadra ? $pathLogoSquadra : "../src/posts/default.png" ?>" alt="Logo squadra supportata" class="logo_squadra_supportata <?php echo $pathLogoSquadra ? "" : "hidden" ?>">
                    </div>
                    <?php if($isOwner): ?>
                        <button id="modifica_squadra" class="bottone_pagina_utente">Modifica</button>
                    <?php endif;?>
                </div>
                <div id="contenitore_statistiche_utente">
                    <div class="statistica">
                        <h3>Eventi</h3>
                        <p id="num_eventi"></p>
                    </div>
                    <div class="statistica">
                        <h3>Recensioni</h3>
                        <p id="num_recensioni_scritte"></p>
                    </div>
                    <div class="statistica">
                        <h3>Stadi visitati</h3>
                        <p id="num_stadi_visitati"></p>
                    </div>
                    <div class="statistica">
                        <h3>Squadra più vista</h3>
                        <div>
                            <p id="squadra_piu_vista"></p>
                            <img src="../src/posts/Default.png" alt="Logo squadra più vista" class="logo_squadra_statitstiche hidden" id="logo_squadra_statitstiche">
                        </div>
                    </div>
                </div>
            </aside>
            <?php if($isOwner): ?>
                <dialog id="dialog_modifiche">
                    <div id="contenuto_dialog"></div>
                    <div id="bottoni_dialog">
                        <button id="annulla_dialog" class="bottone_dialog">Annulla</button>
                        <button id="conferma_modifiche" class="bottone_dialog" disabled>Conferma</button>
                    </div>
                </dialog>
            <?php endif;?>
        </main>
        <footer>
            <small>
                Progetto di Progettazione Web | Professore: Alessio Vecchio - Studente: Francesco Lombardo | Università di Pisa
            </small>
        </footer>
    </body>
</html>