<?php

require_once("start_session.php");
header('Content-Type: application/json');

if(!isset($_SESSION["Username"])){
    echo json_encode(['success' => false, 'message' => 'Utente non utenticato.']);
    exit();
}

//recupero i dati passati dal javascript
$utente = $_SESSION["Username"];
$tipoPost = $_POST["tipo"] ?? null;
$idPost = $_POST["id_post"] ?? null;

//verifico che i dati obbligatori ci siano
if(!isset($utente)){
    echo json_encode(['success' => false, 'message' => 'L\'utente non è specificato.']);
    exit();
}

require_once("dbaccess.php");
$connection = getDbConnection();

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
?>