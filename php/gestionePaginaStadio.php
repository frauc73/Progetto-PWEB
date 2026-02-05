<?php
    header('Content-Type: application/json');

    require_once("dbaccess.php");
    $connection = mysqli_connect(DBHOST,DBUSER,DBPASS,DBNAME);
    if(mysqli_connect_errno()){
        echo json_encode(['error' => 'Connessione fallita']);
        echo json_encode(die(mysqli_connect_error()));
        exit();
    }
    
?>