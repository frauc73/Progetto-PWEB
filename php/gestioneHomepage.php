<?php
header('Content-Type: application/json');

$getAzione = $_GET['azione'] ?? null;
$getStringa = $_GET['stringa'] ?? null;
$getUsername = $_GET['username'] ?? null;


require_once("dbaccess.php");
$connection = mysqli_connect(DBHOST,DBUSER,DBPASS,DBNAME);
if(mysqli_connect_errno()){
    echo json_encode(['error' => 'Connessione fallita']);
    echo json_encode(die(mysqli_connect_error()));
    exit();
}

if($getAzione === "ricerca"){
    if(!isset($getStringa)){
        echo json_encode(['success' => false, 'message' => 'Ricerca non valida']);
        $connection->close();
        exit();
    }
    //creo una nuova stringa per usare il LIKE
    $searchString = "%" . $getStringa . "%";
    //il risultato di questa ricerca è ordinato per percentale di matching rispetto alla stringa
    //uso il limit 10 per una questione di ottimizzazione e limitare il numero massimo di elementi che fanno match
    $queryRicerca = "SELECT * FROM (
        (SELECT 'utente' AS type, Username AS NomeElemento, PathFotoProfilo 
         FROM Users 
         WHERE Username LIKE ?)
        UNION
        (SELECT 'stadio' AS type, Stadium AS NomeElemento, NULL AS PathFotoProfilo 
         FROM datistadi2025 
         WHERE Stadium LIKE ?)
    ) AS Risultati
    ORDER BY 
        LOCATE(?, NomeElemento) ASC, 
        LENGTH(NomeElemento) ASC
    LIMIT 10";
    if($stmtRicerca = $connection->prepare($queryRicerca)){
        $stmtRicerca->bind_param("sss", $searchString, $searchString, $getStringa);
        $stmtRicerca->execute();
        $result = $stmtRicerca->get_result();

        $elementi = array();
        while($row = $result->fetch_assoc()){
            $elementi[] = $row;
        }

        echo json_encode($elementi);
        $result->free_result();
        $stmtRicerca->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Preparazione della query fallita.']);
        $connection->close();
        exit();
    }
} else if ($getAzione === "riempi") {
    if(!isset($getUsername)){
        echo json_encode(['success' => false, 'message' => 'Username non valido']);
        $connection->close();
        exit();
    }
    $post = [];
    //cominciamo recuperando gli eventi
    $queryEventi = "SELECT * FROM 
        (SELECT User as UtenteLoggato, Followed, PathFotoProfilo as FotoProfiloFollowed 
         FROM Following F INNER JOIN Users U 
         ON F.Followed = U.Username
         WHERE F.User = ?) as Parziale 
         INNER JOIN (SELECT E.*, SH.Paese AS PaeseHome, SH.Campionato AS CampionatoHome, SA.Paese AS PaeseAway, SA.Campionato AS CampionatoAway
                     FROM Eventi E
                     LEFT JOIN dati_squadre SH ON E.HomeTeam = SH.Nome
                     LEFT JOIN dati_squadre SA ON E.AwayTeam = SA.Nome) as EventiCompleti
         ON Followed = EventiCompleti.User";
    if($stmtEventi = $connection->prepare($queryEventi)){
        $stmtEventi->bind_param("s", $getUsername);
        $stmtEventi->execute();
        $resultEventi = $stmtEventi->get_result();
        while($rowEventi = $resultEventi->fetch_assoc()){
            $rowEventi['type'] = 'evento';
            //creo i path per recuperare il logo delle squadre
            $pathSquadraCasa = "./src/loghi_squadre/" . $rowEventi['PaeseHome'] . "-" . $rowEventi['CampionatoHome'] . "/" . $rowEventi['HomeTeam'] . ".png";
            $rowEventi['pathSquadraCasa'] = str_replace(" ", "%20",$pathSquadraCasa);
            $pathSquadraOspite = "./src/loghi_squadre/" . $rowEventi['PaeseAway'] . "-" . $rowEventi['CampionatoAway'] . "/" . $rowEventi['AwayTeam'] . ".png";
            $rowEventi['pathSquadraOspite'] = str_replace(" ", "%20",$pathSquadraOspite);
            $post[] = $rowEventi;
        }
        $resultEventi->free_result();
        $stmtEventi->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Errore nella preparazione della query sugli eventi']);
        $connection->close();
        exit();
    }
    //recuperiamo poi le recensioni
    $queryRecensioni = "SELECT * FROM 
        (SELECT User as UtenteLoggato, Followed, PathFotoProfilo as FotoProfiloFollowed 
         FROM Following F INNER JOIN Users U 
         ON F.Followed = U.Username
         WHERE F.User = ?) as Parziale 
         INNER JOIN Recensioni R ON Followed = R.Username";
    if($stmtRecensioni = $connection->prepare($queryRecensioni)){
        $stmtRecensioni->bind_param("s", $getUsername);
        $stmtRecensioni->execute();
        $resultRecensioni = $stmtRecensioni->get_result();
        while($rowRecensioni = $resultRecensioni->fetch_assoc()){
            $rowRecensioni['type'] = 'recensione';
            $post[] = $rowRecensioni;
        }
        $resultRecensioni->free_result();
        $stmtRecensioni->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Errore nella preparazione della query sulle recensioni']);
        $connection->close();
        exit();
    }     

    //termino ordinando il vettore in base al timestamp
    usort($post, function($a, $b){
        $ta = strtotime($a['TimeStampPost']);
        $tb = strtotime($b['TimeStampPost']);
        //ordine decrescente
        return $tb - $ta;
    });

    //do la risposta sottoforma di json
    echo json_encode($post);
}
$connection->close();
?>