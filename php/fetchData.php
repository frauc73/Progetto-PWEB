<?php
header('Content-Type: application/json');

require_once("dbaccess.php");
$connection = getDbConnection();


// Determina il tipo di richiesta
$action = isset($_GET['action']) ? trim($_GET['action']) : '';
$paese  = isset($_GET['paese'])  ? trim($_GET['paese'])  : '';

if ($action === 'get_squadre' && $paese != '') {
    $sql = "SELECT Nome FROM dati_squadre WHERE Paese = ? ORDER BY Nome ASC";
    if($statement = $connection->prepare($sql)){
        $statement->bind_param("s", $paese);
        $statement->execute();
        $result = $statement->get_result();
        $squadre = [];
        while ($row = $result->fetch_assoc()) {
            $squadre[] = $row;
        }
        echo json_encode($squadre);
    } else {
        //La query è scritta male
        echo json_encode(['error' => 'Errore preparazione query: ' . mysqli_error($connection)]);
    }
} elseif ($action === 'get_info_squadra') {
    if (!isset($_GET['Nome'])) {
        //interrompo lo script in caso di parametro non passato
        echo json_encode(['error' => 'Parametro Nome mancante']);
        $connection->close();
        exit();
    }
    //recupero la squadra selezionata
    $nome = trim($_GET['Nome']);
    $sql = "SELECT Nome, Campionato, Paese, NomeStadio FROM dati_squadre WHERE Nome = ?";
    if($statement = $connection->prepare($sql)){
        $statement->bind_param("s", $nome);
        $statement->execute();
        $result = $statement->get_result();
        if ($row = $result->fetch_assoc()){
            //ricostruisco il path dove è contenuto il logo
            $paeseSquadra = rawurlencode($row['Paese']);
            $campionatoSquadra = rawurlencode($row['Campionato']);
            $nomeSquadra = rawurlencode($row['Nome']);
            $row['logo_path'] = "../src/loghi_squadre/" . $paeseSquadra . "-" . $campionatoSquadra . "/" . $nomeSquadra . ".png";
            echo json_encode($row);
            //così il file json avrà la seguente forma:
            /*
                {
                    "Nome": "Napoli",
                    "Campionato": "Serie A",
                    "Paese": "Italia",
                    "NomeStadio": "Stadio Diego Armando Maradona",
                    "logo_path": "../src/loghi_squadre/Italia-Serie%20A/SSC%20Napoli.png"
                }
            */


        } else {
            echo json_encode(['error' => 'Squadra non trovata']);
        }
    } else {
        //La query è scritta male
        echo json_encode(['error' => 'Errore preparazione query: ' . mysqli_error($connection)]);
    }
} elseif ($action === 'get_stadi' && $paese != ''){
    $sql = "SELECT DISTINCT Stadium FROM datistadi2025 WHERE Country = ? ORDER BY Stadium ASC";
    if($statement = $connection->prepare($sql)){
        $statement->bind_param("s", $paese);
        $statement->execute();
        $result = $statement->get_result();
        $stadi = [];
        while ($row = $result->fetch_assoc()) {
            $stadi[] = $row;
        }
        echo json_encode($stadi);
    } else {
        //La query è scritta male
        echo json_encode(['error' => 'Errore preparazione query: ' . mysqli_error($connection)]);
    }
} else {
    echo json_encode(['error' => 'Azione non valida']);
}

$result->free_result();
$statement->close();
$connection->close();