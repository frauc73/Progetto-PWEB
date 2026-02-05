<?php
require_once("start_session.php");
header('Content-Type: application/json');
require_once("dbaccess.php");

if(!isset($_SESSION["Username"])){
    echo json_encode(['success' => false, 'message' => 'Utente non utenticato.']);
    exit();
}

//recupero i dati passati dal javascript
$utente = $_SESSION["Username"];
$azione = $_POST["azione"] ?? null;
$fotoProfilo = $_POST["foto_profilo"] ?? null;
$descrizione = $_POST["descrizione"] ?? null;
$squadra = $_POST["squadra"] ?? null;
$tipoPost = $_POST["tipo"] ?? null;
$idPost = $_POST["id_post"] ?? null;

//verifico che i dati obbligatori ci siano
if(!isset($utente) || !isset($azione)){
    echo json_encode(['success' => false, 'message' => 'Non sono specificati utente o azione']);
    exit();
}

$connection = mysqli_connect(DBHOST,DBUSER,DBPASS,DBNAME);
if(mysqli_connect_errno()){
    echo json_encode(['success' => false, 'message' => 'Errore di connessione al database']);
    die(mysqli_connect_error());
    exit();
}

if($azione == "foto_profilo"){
    if (isset($_FILES['foto_profilo']) && $_FILES['foto_profilo']['error'] === UPLOAD_ERR_OK){
        $nomeFile = basename($_FILES['foto_profilo']['name']);
        $estensione = strtolower(pathinfo($nomeFile, PATHINFO_EXTENSION));
        
        //accetto solo questi formati
        $estensioniAmmesse = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array($estensione, $estensioniAmmesse)) {
            //cancelliamo la foto profilo precedente
            $eliminaFotoProfilo = "SELECT PathFotoProfilo FROM Users WHERE Username = ?";
            if($stmtEliminaFotoProfilo = $connection->prepare($eliminaFotoProfilo)){
                $stmtEliminaFotoProfilo->bind_param("s", $utente);
                if($stmtEliminaFotoProfilo->execute()){
                    $resultElimina = $stmtEliminaFotoProfilo->get_result();
                    if($rowVecchia = $resultElimina->fetch_assoc()){
                        $vecchiaFoto = $rowVecchia['PathFotoProfilo'];
                        if ($vecchiaFoto && file_exists($vecchiaFoto)) {
                            //Cancello il file fisico
                            unlink($vecchiaFoto);
                        }
                    }
                    $resultElimina->free_result();
                } else {
                    echo json_encode(['success' => false, 'message' => 'Errore nell\'esecuzione della query.']);
                    die(mysqli_connect_error());
                    exit();
                }
                $stmtEliminaFotoProfilo->close();
            } else {
                echo json_encode(['success' => false, 'message' => 'Errore nella preparazione della query.']);
                die(mysqli_connect_error());
                exit();
            }
            //uniqid serve per dare ad ogni foto profilo un id unico, che comincia per "profile_pic_"
            //questo mi permette di accettare file con nomi uguali senza che si sovrascrivano
            $nuovoNomeFile = uniqid("profile_pic_") . "." . $estensione;
            
            // Path fisico per spostare il file 
            $pathFisico = dirname(__DIR__) . "/src/profile_pic/"; 
            // Path da salvare nel DB
            $pathFotoDB = "../src/profile_pic/" . $nuovoNomeFile; 
            
            if (!is_dir($pathFisico)) {
                //creo la cartella se non esiste
                mkdir($pathFisico, 0777, true);
            }
    
            //la funzione move_uploaded_file mi permette l'effettivo salvataggio della foto caricata dentro la cartella /src/profile_pic
            if (!move_uploaded_file($_FILES['foto_profilo']['tmp_name'], $pathFisico . $nuovoNomeFile)) {
                echo json_encode(['success' => false, 'message' => 'Errore upload immagine.']);
                $connection->close();
                exit();
            }

            //salvo il percorso nel database
            $salvaFotoProfilo = "UPDATE Users SET PathFotoProfilo = ? WHERE Username = ?";
            if($stmtFotoProfilo = $connection->prepare($salvaFotoProfilo)){
                $stmtFotoProfilo->bind_param("ss", $pathFotoDB, $utente);
                if($stmtFotoProfilo->execute()){
                    echo json_encode(['success' => true, 'message' => 'Foto profilo aggiornata correttamente!']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Errore nell\'esecuzione della query.']);
                    die(mysqli_connect_error());
                    exit();
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Errore nella preparazione della query.']);
                die(mysqli_connect_error());
                exit();
            }
            $stmtFotoProfilo->close();
        } else {
            echo json_encode(['success' => false, 'message' => 'Formato immagine non valido.']);
            die(mysqli_connect_error());
            exit();
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Inserisci una foto valida']);
        die(mysqli_connect_error());
        exit();
    }
} else if ($azione == "descrizione") {
    if(!isset($descrizione) || trim($descrizione) === ''){
        echo json_encode(['success' => false, 'message' => 'Inserisci una descrizione valida']);
        die(mysqli_connect_error());
        exit();
    }
    $aggiornaDescrizione = "UPDATE Users SET DescrizioneProfilo = ? WHERE Username = ?";
    if($stmtAggiornaDescrizione = $connection->prepare($aggiornaDescrizione)){
        $stmtAggiornaDescrizione->bind_param("ss", $descrizione ,$utente);
        if($stmtAggiornaDescrizione->execute()){
            echo json_encode(['success' => true, 'message' => 'Descrizione aggiornata correttamente!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Errore nell\'esecuzione della query.']);
            die(mysqli_connect_error());
            exit();
        }
        $stmtAggiornaDescrizione->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Errore nella preparazione della query.']);
        die(mysqli_connect_error());
        exit();
    }
} else if ($azione == "squadra") {
    if(!isset($squadra) || trim($squadra) === ''){
        echo json_encode(['success' => false, 'message' => 'Inserisci una squadra valida']);
        die(mysqli_connect_error());
        exit();
    }
    $aggiornaSquadra = "UPDATE Users SET NomeSquadraSupportata = ? WHERE Username = ?";
    if($stmtAggiornaSquadra = $connection->prepare($aggiornaSquadra)){
        $stmtAggiornaSquadra->bind_param("ss", $squadra, $utente);
        if($stmtAggiornaSquadra->execute()){
            echo json_encode(['success' => true, 'message' => 'Squadra aggiornata correttamente!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Errore nell\'esecuzione della query.', 'squadra' => $squadra]);
            die(mysqli_connect_error());
            exit();
        }
        $stmtAggiornaSquadra->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Errore nella preparazione della query.']);
        die(mysqli_connect_error());
        exit();
    }
} else if ($azione === "elimina_post"){
    if(($tipoPost !== "evento" && $tipoPost !== "recensione") || !isset($idPost)){
        echo json_encode(['success' => false, 'message' => 'Impossibile eliminare il post.']);
        die(mysqli_connect_error());
        exit();
    }
    if($tipoPost === "evento"){
        $queryEliminaPost = "DELETE FROM Eventi WHERE User = ? AND IdPost = ?";
    } else {
        $queryEliminaPost = "DELETE FROM Recensioni WHERE Username = ? AND IdRecensione = ?";
    }
    if($stmtEliminaPost = $connection->prepare($queryEliminaPost)){
        $idPostIntero = intval($idPost);
        $stmtEliminaPost->bind_param("si", $utente, $idPostIntero);
        if($stmtEliminaPost->execute()){
            if($stmtEliminaPost->affected_rows > 0){
                echo json_encode(['success' => true, 'message' => 'Post eliminato correttamente']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Non esiste un post con quell\' id.']);
                die(mysqli_connect_error());
                exit();
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Errore nell\' esecuzione della query.']);
            die(mysqli_connect_error());
            exit();
        }
        $stmtEliminaPost->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Errore nella preparazione della query.']);
        die(mysqli_connect_error());
        exit();
    }
}
$connection->close();
?>