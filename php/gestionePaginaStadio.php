<?php
    header('Content-Type: application/json');

    $azione = $_GET['azione'] ?? null;
    $stadio = $_GET['stadio'] ?? null;
    $settore = $_GET['settore'] ?? null;

    if(!isset($stadio)){
        echo json_encode(['success' => false, 'message' => 'Stadio non specificato']);
        exit();
    }

    if(!isset($settore)){
        echo json_encode(['success' => false, 'message' => 'Settore non specificato']);
        exit();
    }

    require_once("dbaccess.php");
    $connection = getDbConnection();

    if($azione === "riempi_bacheca"){
        $query = "SELECT * 
        FROM Recensioni R INNER JOIN 
        (SELECT Username as Utente,PathFotoProfilo
        FROM Users U
        ) as RecuperoFotoProfilo 
        WHERE R.Username = RecuperoFotoProfilo.Utente AND R.Stadio = ?";
        $params = [$stadio];
        $types = "s";
        //se la pagina ha un filtro modifico la query, l'array params e la stringa types
        //per adattare l'esecuzione con i prepared statements
        if($settore != "tutti"){
            //concateno la parte della query che manca
            $query .= " AND R.Settore = ?";
            //modifico le variabili da usare in bind_param
            $params[] = $settore;
            $types .= "s";
        }
        //ordino in base alla data della recensione
        $query .= " ORDER BY DataRecensione DESC";
        if($stmt = $connection->prepare($query)){
            //uso l'operatore splat (...) per usare l'array dentro bind param
            $stmt->bind_param($types,...$params);
            $stmt->execute();
            $result = $stmt->get_result();
            $recensioni = array();
            while($row = $result->fetch_assoc()){
                $recensioni[] = $row;
            }
            $result->free_result();
            $stmt->close();
        } else {
            echo json_encode(['success' => false, 'message' => 'Preparazione della query fallita.']);
            exit();
        }
        
        echo json_encode($recensioni);
    } else if($azione === "calcola_statistiche"){
        //Tabella Recensioni(IdRecensione,TimeStampPost,Username,Stadio,Settore,DataRecensione,VotoVisibilita,Copertura,VotoDistanzaCampo,VotoAccessibilita,VotoParcheggio,VotoGestioneIngressi,VotoServiziIgenici,VotoRistorazione,Descrizione)
        $query = "SELECT 
        -- Calcolo la valutazione dei singoli campi con una semplice media --
        AVG(R.VotoVisibilita) as MediaVisibilita, 
        AVG(R.VotoDistanzaCampo) as MediaDistanzaCampo,
        AVG(R.VotoAccessibilita) as MediaAccessibilita,
        AVG(R.VotoParcheggio) as MediaParcheggio,
        AVG(R.VotoGestioneIngressi) as MediaGestioneIngressi,
        AVG(R.VotoServiziIgenici) as MediaServiziIgenici,
        AVG(R.VotoRistorazione) as MediaRistorazione,
        -- Calcolo la valutazione sui macrocampi, facendo la media tra le singole medie risultanti dalle singole recensioni --
        AVG( (R.VotoVisibilita + R.VotoDistanzaCampo) / 2.0 ) as MediaImpianto,
        -- Qui arriva la parte delicata, gestire i campi che possono contenere valori NULL --
        -- Per gestirli trasformo il valore NULL in 0, con la funzione COALESCE, e poi divido il valore totale per il numero di righe che non contengo NULL --
        AVG( (R.VotoAccessibilita + R.VotoGestioneIngressi + COALESCE(R.VotoParcheggio, 0)) / (2.0 + CASE WHEN R.VotoParcheggio IS NOT NULL THEN 1 ELSE 0 END)) as MediaLogistica,
        AVG(
            CASE
                -- Se entrambi sono NULL allora il risultato è NULL, quindi il record verrà scartato dalla media dalla AVG
                WHEN (R.VotoServiziIgenici IS NULL AND R.VotoRistorazione IS NULL) THEN NULL
                -- Altrimenti come sopra calcolo la valutazione media di ogni singola recensione e con AVG faccio la media
                ELSE 
                    (COALESCE(R.VotoServiziIgenici, 0) + COALESCE(R.VotoRistorazione, 0)) / 
                    (
                        (CASE WHEN R.VotoServiziIgenici IS NOT NULL THEN 1 ELSE 0 END) + 
                        (CASE WHEN R.VotoRistorazione IS NOT NULL THEN 1 ELSE 0 END)
                    )
            END
        ) as MediaServizi,
        -- Infine calcolo la valutazione generale, calcolata come la media tra le valutazioni generali di ogni recensione --
        AVG( 
            (R.VotoVisibilita + R.VotoDistanzaCampo + R.VotoAccessibilita + R.VotoGestioneIngressi + COALESCE(R.VotoParcheggio, 0) + COALESCE(R.VotoServiziIgenici, 0) + COALESCE(R.VotoRistorazione, 0))
            -- Calcolo il numero di parametri diversi da NULL, sicuramente 4, gli altri poi aggiungono 1 se diversi da NULL
            /(4.0 + (CASE WHEN R.VotoParcheggio IS NOT NULL THEN 1 ELSE 0 END) +(CASE WHEN R.VotoServiziIgenici IS NOT NULL THEN 1 ELSE 0 END) + (CASE WHEN R.VotoRistorazione IS NOT NULL THEN 1 ELSE 0 END))
            ) as ValutazioneGenerale
        FROM Recensioni R Where R.Stadio = ?";
        //adotto la stessa soluzione di sopra
        $params = [$stadio];
        $types = "s";
        if($settore != "tutti"){
            $query .= " AND R.Settore = ?";
            $params[] = $settore;
            $types .= "s";
        }
        //dopo aver scritto la query procediamo ad eseguirla
        if($stmt = $connection->prepare($query)){
            $stmt->bind_param($types,...$params);
            $stmt->execute();
            $result = $stmt->get_result();
            echo json_encode($result->fetch_assoc());
            $result->free_result();
            $stmt->close();
        } else {
            echo json_encode(['success' => false, 'message' => 'Preparazione della query fallita.']);
            exit();
        }

    }
    $connection->close();
?>