<?php
require_once("start_session.php");

header('Content-Type: application/json');
require_once("dbaccess.php");

if(!isset($_SESSION["Username"])){
    echo json_encode(['success' => false, 'message' => 'Utente non utenticato.']);
    exit();
}


$connection = mysqli_connect(DBHOST,DBUSER,DBPASS,DBNAME);
if(mysqli_connect_errno()){
    echo json_encode(['success' => false, 'message' => 'Errore di connessione al database']);
    die(mysqli_connect_error());
    exit();
}

//facciamo il doppio controllo sugli input dell'utente, nel caso disabiliti javascript e riesca a mandare il form
if(empty($_POST['stadio']) || empty($_POST['settore'] || empty($_POST['data'])) || !isset($_POST['visibilita']) || !isset($_POST['copertura']) || !isset($_POST['distanza_campo']) || !isset($_POST['accessibilita']) || !isset($_POST['gestione_ingressi'])){
    echo json_encode(['success' => false, 'message' => 'Compila tutti i campi prima di inviare il form.']);
    exit();
}

//formato della tabella nel database:
//Recensioni(IdRecensione,TimeStampRecensione,Username,Stadio,Settore,DataRecensione,$votoVisibilita,Copertura,VotoDistanzaCampo,VotoAccessibilita,VotoParcheggio,VotoGestioneIngressi,VotoServiziIgenici,VotoRistorazione,Descrizione)
//recupero gli input dell'utente e i parametri facoltativi se mancano li metto a null
$utente = $_SESSION["Username"];
$stadio = $_POST['stadio'];
$settore = $_POST['settore'];
$votoVisibilita = intval($_POST['visibilita']);
$copertura =$_POST['copertura'];
$votoDistanzaCampo = intval($_POST['distanza_campo']);
$votoAccessibilita = intval($_POST['accessibilita']);
$votoParcheggio = isset($_POST['parcheggio']) ? intval($_POST['parcheggio']): null;
$votoGestioneIngressi = intval($_POST['gestione_ingressi']);
$votoServiziIgenici = isset($_POST['servizi_igenici']) ? intval($_POST['servizi_igenici']): null;
$votoRistorazione = isset($_POST['ristorazione']) ? intval($_POST['ristorazione']): null;
$descrizione = isset($_POST['descrizione']) ? trim($_POST['descrizione']): null;

$data = $_POST['data'];
$sql = "INSERT INTO Recensioni(Username,Stadio,Settore,DataRecensione,VotoVisibilita,Copertura,VotoDistanzaCampo,VotoAccessibilita,VotoParcheggio,VotoGestioneIngressi,VotoServiziIgenici,VotoRistorazione,Descrizione) 
        VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)";
$stmt = $connection->prepare($sql);
$stmt->bind_param("ssssisiiiiiis", $utente,$stadio,$settore,$data,$votoVisibilita,$copertura,$votoDistanzaCampo,$votoAccessibilita,$votoParcheggio,$votoGestioneIngressi,$votoServiziIgenici,$votoRistorazione,$descrizione);
if($stmt->execute()){
    echo json_encode(['success' => true, 'message' => 'Recensione salvata correttamente!']);
} else {
    echo json_encode(['success' => false, 'message' => 'Errore durante il salvataggio.']);
}
?>