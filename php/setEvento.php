<?php
require_once("start_session.php");

header('Content-Type: application/json');
require_once("dbaccess.php");

if(!isset($_SESSION["Username"])){
    echo json_encode(['success' => false, 'message' => 'Utente non loggato.']);
    exit();
}

$connection = mysqli_connect(DBHOST,DBUSER,DBPASS,DBNAME);
if(mysqli_connect_errno()){
    echo json_encode(['success' => false, 'message' => 'Errore di connessione al database']);
    die(mysqli_connect_error());
    exit();
}

$utente = $_SESSION["Username"];
$squadraCasa = $_POST['squadra_casa'];
$squadraOspite = $_POST['squadra_ospite'];
$punteggioCasa = intval($_POST['punteggio_casa']);
$punteggioOspite = intval($_POST['punteggio_ospite']);
$dataPartita = $_POST['data_partita'];
$caption = $_POST['caption'];

//gestisco la data
if (empty($dataPartita)) {
    echo json_encode(['success' => false, 'message' => 'Inserire la data della partita.']);
    $connection->close();
    exit();
}
//controllo che non sia futura
$oggi = date("Y-m-d");
if ($dataPartita > $oggi) {
     echo json_encode(['success' => false, 'message' => 'Non puoi inserire partite future.']);
     $connection->close();
     exit();
}

//Recupero il nome dello stadio, questa parte del codice va modificata se decido di inserire lo stadio come input
//In quel caso lo posso recuperare come variabile del campo POST
$queryStadio = "Select NomeStadio From dati_squadre Where Nome = ?";
$stmtStadio = $connection->prepare($queryStadio);
$stmtStadio->bind_param("s",$squadraCasa);
$stmtStadio->execute();
$resultStadio = $stmtStadio->get_result();

$nomeStadio = null;
if($row = $resultStadio->fetch_assoc()){
    $nomeStadio = $row['NomeStadio'];
}
$stmtStadio->close();

//costruiamo il path da inserire nel database
$pathFoto = null;

if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK){
    $nomeFile = basename($_FILES['foto']['name']);
    $estensione = strtolower(pathinfo($nomeFile, PATHINFO_EXTENSION));
    
    //accetto solo questi formati
    $estensioniAmmesse = ['jpg', 'jpeg', 'png', 'gif'];
    if (in_array($estensione, $estensioniAmmesse)) {
        //uniqid serve per dare ad ogni post un id unico, che comincia per "post_"
        //questo mi permette di accettare file con nomi uguali senza che si sovrascrivano
        $nuovoNomeFile = uniqid("post_") . "." . $estensione;
        
        // Path fisico per spostare il file 
        $pathFisico = dirname(__DIR__) . "/src/posts/"; 
        // Path da salvare nel DB
        $pathFoto = "src/posts/" . $nuovoNomeFile; 
        
        if (!is_dir($pathFisico)) {
            //creo la cartella se non esiste
            mkdir($pathFisico, 0777, true);
        }

        //la funzione move_uploaded_file mi permette l'effettivo salvataggio della foto caricata dentro la cartella /src/posts
        if (!move_uploaded_file($_FILES['foto']['tmp_name'], $pathFisico . $nuovoNomeFile)) {
            echo json_encode(['success' => false, 'message' => 'Errore upload immagine.']);
            $connection->close();
            exit();
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Formato immagine non valido.']);
        $connection->close();
        exit();
    }
}
//Struttura tabella : Eventi(IdPost,TimeStampPost,User, HomeTeam, GoalHT, AwayTeam, GoalAT, NomeStadio,DataMatch,PathFotoRicordo,DescrizionePost)
$sql = "INSERT INTO Eventi (User, HomeTeam, GoalHT, AwayTeam, GoalAT, NomeStadio, DataMatch, PathFotoRicordo, DescrizionePost)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $connection->prepare($sql);
$stmt->bind_param("ssisissss",$utente,$squadraCasa,$punteggioCasa,$squadraOspite,$punteggioOspite,$nomeStadio,$dataPartita,$pathFoto,$caption);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Evento salvato correttamente!']);
} else {
    echo json_encode(['success' => false, 'message' => 'Errore durante il salvataggio.']);
}

$stmt->close();
$connection->close();
?>