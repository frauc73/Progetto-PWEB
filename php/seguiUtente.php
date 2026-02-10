<?php
require_once("start_session.php");
header('Content-Type: application/json');

if(!isset($_SESSION["Username"])){
    echo json_encode(['success' => false, 'message' => 'Utente non utenticato.']);
    exit();
}


//recupero i dati passati dal javascript
$loggedUser = $_SESSION["Username"];
$followedUser = $_GET["followed"] ?? null;
$azione = $_GET["azione"] ?? null;

if ($loggedUser === $followedUser) {
    echo json_encode(['success' => false, 'message' => 'Non puoi seguire te stesso.']);
    exit();
}

require_once("dbaccess.php");
$connection = mysqli_connect(DBHOST,DBUSER,DBPASS,DBNAME);
if(mysqli_connect_errno()){
    echo json_encode(['error' => 'Connessione fallita']);
    echo json_encode(die(mysqli_connect_error()));
    exit();
}

if(isset($followedUser) && isset($azione)){
    if($azione === "follow"){
        //controlliamo se gli utenti esistono e se l'utente non sta cercando di seguirsi da solo
        $queryControllo = "SELECT COUNT(*) as num FROM Users WHERE Username = ? OR Username = ?";
        if($stmtQueryControllo = $connection->prepare($queryControllo)){
            $stmtQueryControllo->bind_param("ss", $loggedUser, $followedUser);
            if($stmtQueryControllo->execute()){
                $resultControllo = $stmtQueryControllo->get_result();
                $rowControllo = $resultControllo->fetch_assoc();
                if($rowControllo["num"] != 2){
                    echo json_encode(['success' => false, 'message' => 'Ops, qualcosa è andato storto! Assicurati che l\'utente esista.']);
                    die(mysqli_connect_error());
                    exit();
                }
                $resultControllo->free_result();
            } else {
                echo json_encode(['success' => false, 'message' => 'Errore nell\'esecuzione della query di controllo.']);
                die(mysqli_connect_error());
                exit();
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Errore nella preparazione della query di controllo.']);
            die(mysqli_connect_error());
            exit();
        }
        $stmtQueryControllo->close();
        //se sono arrivato qui ho passato il controllo
        $followingQuery = "INSERT INTO Following (User,Followed) VALUES (?,?)";
        if($stmtFollowingQuery = $connection->prepare($followingQuery)){
            $stmtFollowingQuery->bind_param("ss", $loggedUser, $followedUser);
            if($stmtFollowingQuery->execute()){
                echo json_encode(['success' => true, 'message' => 'Utente seguito!']);
                //mi occupo di inserire la notifica nel database
                $queryNotifica = "INSERT INTO Notifiche (Mittente,Destinatario,TipoNotifica) VALUES (?,?,?)";
                if($stmtQueryNotifica = $connection->prepare($queryNotifica)){
                    $tipo = "follow";
                    $stmtQueryNotifica->bind_param("sss", $loggedUser, $followedUser, $tipo);
                    if(!$stmtQueryNotifica->execute()){
                        echo json_encode(['success' => false, 'message' => 'Errore nel salvataggio della notifica.']);
                        die(mysqli_connect_error());
                        exit();
                    };
                    $stmtQueryNotifica->close();
                } else {
                    echo json_encode(['success' => false, 'message' => 'Errore nella preparazione della query.']);
                    die(mysqli_connect_error());
                    exit();
                }
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
        $stmtFollowingQuery->close();
        
    } else if ($azione === "unfollow") {
        //qui il controllo è effettuato dalla funzione affected_rows, che mi dice quante righe della tabella sono state modificate
        //0? allora l'utente loggato non lo seguiva
        //Altrimenti la query ha effettivamente funzionato
        $unfollowingQuery = "DELETE FROM Following WHERE User = ? AND Followed = ?";
        if($stmtUnfollowingQuery = $connection->prepare($unfollowingQuery)){
            $stmtUnfollowingQuery->bind_param("ss", $loggedUser, $followedUser);
            if($stmtUnfollowingQuery->execute()){
                if($stmtUnfollowingQuery->affected_rows > 0){
                    echo json_encode(['success' => true, 'message' => 'Hai smesso di seguire l\'utente.']);
                    //mi occupo di inserire la notifica nel database
                    $queryNotifica = "INSERT INTO Notifiche (Mittente,Destinatario,TipoNotifica) VALUES (?,?,?)";
                    if($stmtQueryNotifica = $connection->prepare($queryNotifica)){
                        $tipo = "unfollow";
                        $stmtQueryNotifica->bind_param("sss", $loggedUser, $followedUser, $tipo);
                        if(!$stmtQueryNotifica->execute()){
                            echo json_encode(['success' => false, 'message' => 'Errore nel salvataggio della notifica.']);
                            die(mysqli_connect_error());
                            exit();
                        };
                        $stmtQueryNotifica->close();
                    } else {
                        echo json_encode(['success' => false, 'message' => 'Errore nella preparazione della query.']);
                        die(mysqli_connect_error());
                        exit();
                    }
                } else {
                    echo json_encode(['success' => true, 'message' => 'Non seguivi l\'utente.']);
                }
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
        $stmtUnfollowingQuery->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Azione non valida.']);
        exit();
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Link alla pagina non corretto.']);
    exit();
}
$connection->close();
?>