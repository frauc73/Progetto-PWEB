<?php
    header('Content-Type: application/json');

    $azione = $_GET['azione'] ?? null;
    $stadio = $_GET['stadio'] ?? null;

    if(!isset($stadio)){
        echo json_encode(['success' => false, 'message' => 'Stadio non specificato']);
        exit();
    }

    require_once("dbaccess.php");
    $connection = mysqli_connect(DBHOST,DBUSER,DBPASS,DBNAME);
    if(mysqli_connect_errno()){
        echo json_encode(['error' => 'Connessione fallita']);
        echo json_encode(die(mysqli_connect_error()));
        exit();
    }

    if($azione === "riempi_bacheca"){
        $query = "SELECT * 
        FROM Recensioni R INNER JOIN 
        (SELECT Username as Utente,PathFotoProfilo
        FROM Users U
        ) as RecuperoFotoProfilo 
        WHERE R.Username = RecuperoFotoProfilo.Utente AND R.Stadio = ?";
        if($stmt = $connection->prepare($query)){
            $stmt->bind_param("s",$stadio);
            $stmt->execute();
            $result = $stmt->get_result();
            $recensioni = array();
            while($row = $result->fetch_assoc()){
                $recensioni[] = $row;
            }
            echo json_encode($recensioni);
            $result->free_result();
            $stmt->close();
        } else {
            echo json_encode(['success' => false, 'message' => 'Preparazione della query fallita.']);
            exit();
        }
    } else if($azione === "riempi_statistiche"){

    }
    $connection->close();
?>