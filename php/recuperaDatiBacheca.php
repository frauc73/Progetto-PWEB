<?php
header('Content-Type: application/json');

require_once("dbaccess.php");
$connection = mysqli_connect(DBHOST,DBUSER,DBPASS,DBNAME);
if(mysqli_connect_errno()){
    echo json_encode(['error' => 'Connessione fallita']);
    echo json_encode(die(mysqli_connect_error()));
    exit();
}

$username = $_GET['username'] ?? '';
if(isset($username)){
    $post = [];
    $numeroPost = 0;
    //recupero i post dell'utente
    //prima recupero gli eventi
    $recuperoEventi = "SELECT 
        E.*, 
        SH.Paese AS PaeseHome, SH.Campionato AS CampionatoHome,
        SA.Paese AS PaeseAway, SA.Campionato AS CampionatoAway
    FROM Eventi E
    LEFT JOIN dati_squadre SH ON E.HomeTeam = SH.Nome
    LEFT JOIN dati_squadre SA ON E.AwayTeam = SA.Nome
    WHERE E.User = ?";
    if($stmtRecuperoEventi = $connection->prepare($recuperoEventi)){
        $stmtRecuperoEventi->bind_param("s", $username);
        $stmtRecuperoEventi->execute();
        $resultEventi = $stmtRecuperoEventi->get_result();
        $numeroPost = $resultEventi->num_rows;
        while($rowEventi = $resultEventi->fetch_assoc()){
            //inizio riempiendo il vettore post con gli eventi
            //specifico il tipo
            $rowEventi['type'] = 'evento';
            //creo i path per recuperare il logo delle squadre
            $pathSquadraCasa = "../src/loghi_squadre/" . $rowEventi['PaeseHome'] . "-" . $rowEventi['CampionatoHome'] . "/" . $rowEventi['HomeTeam'] . ".png";
            $rowEventi['pathSquadraCasa'] = str_replace(" ", "%20",$pathSquadraCasa);
            $pathSquadraOspite = "../src/loghi_squadre/" . $rowEventi['PaeseAway'] . "-" . $rowEventi['CampionatoAway'] . "/" . $rowEventi['AwayTeam'] . ".png";
            $rowEventi['pathSquadraOspite'] = str_replace(" ", "%20",$pathSquadraOspite);
            $post[] = $rowEventi;
        }
        $resultEventi->free_result();
        $stmtRecuperoEventi->close();  
    } else {
        echo json_encode(['error' => 'Non ci sono post che corrispondono all \'username richiesto']);
    }
    $recuperoRecensioni = "SELECT * FROM Recensioni Where Username = ?";
    if($stmtRecuperoRecensioni = $connection->prepare($recuperoRecensioni)){
        $stmtRecuperoRecensioni->bind_param("s", $username);
        $stmtRecuperoRecensioni->execute();
        $resultRecensioni = $stmtRecuperoRecensioni->get_result();
        $numeroPost += $resultRecensioni->num_rows;
        while($rowRecensioni = $resultRecensioni->fetch_assoc()){
            //ora concateno le recensioni
            $rowRecensioni['type'] = 'recensione';
            $post[] = $rowRecensioni;
        }
        $resultRecensioni->free_result();
        $stmtRecuperoRecensioni->close();
    }
    usort($post, function($a, $b){
        $ta = strtotime($a['TimeStampPost']);
        $tb = strtotime($b['TimeStampPost']);
        //ordine decrescente
        return $tb - $ta;
    });
    //do la risposta sottoforma di json
    echo json_encode($post);
}
?>