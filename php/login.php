<?php
$errore = false;
$errore_formato = false;
//verifico se è stata ricevuta una richiesta di login
if(isset($_POST['login']) && isset($_POST['username']) && isset($_POST['password'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    //controllo l'input anche lato server
    $regex_username = "/[A-Za-z0-9_]{3,16}/";
    $regex_psw = "/[A-Za-z0-9_$!%@]{4,}/";
    if(preg_match($regex_psw, $password) && preg_match($regex_username,$username)){
        //se entro in questo ramo devo controllare se le credenziali sono associate ad un utente esistente
        //per fare questo devo quindi accedere al database, quindi comincio con il collegarmi
        require_once("dbaccess.php");
        $connection = mysqli_connect(DBHOST,DBUSER,DBPASS,DBNAME);
        if(mysqli_connect_errno()){
            die(mysqli_connect_error());
            exit();
        }
        $sql = "select * from Users where Username=?";
        if($statement = $connection->prepare($sql)){
            $statement->bind_param("s", $username);
            $statement->execute();
            $result = $statement->get_result();
            if($result->num_rows == 0){
                //pulisco la memoria dal result set e chiudo la connessione con il database
                $result->free_result();
                $errore = true;
            } else {
                //l'username è corretto, ora controlliamo la password
                $row = $result->fetch_assoc();
                $hash = $row['Password'];
                if(password_verify($password, $hash)){
                    //le credenziali sono corrette, l'utente può accedere alla sua homepage
                    //in questo pezzo di codice dobbiamo utilizzare la sessione per salvare i dati dell'utente
                    //così facendo quando accedo alla homepage posso ricostruire tutte le sue informazioni
                    require_once("start_session.php");
                    //imposto le variabili di sessione
                    $_SESSION["UID"] = $row['Id'];
                    $_SESSION["Nome"] = $row['Nome'];
                    $_SESSION["Cognome"] = $row['Cognome'];
                    $_SESSION["Username"] = $row['Username'];
                    $_SESSION["PathFotoProfiloUtente"] = $row['PathFotoProfilo'];

                    //pulisco la memoria dal result set e chiudo la connessione con il database
                    $result->free_result();
                    //indirizzo l'utente alla sua homepage
                    header("location: ../index.php");
                } else {
                    //pulisco la memoria dal result set e chiudo la connessione con il database
                    $result->free_result();
                    $errore = true;
                } 
            }
        } else {
            die(mysqli_connect_error());
            exit();
        }
        $connection->close();
    } else {
        echo "<script>window.alert('Il formato inserito non è corretto')</script>";
    }

}
?>
<!DOCTYPE html>
<html lang="it">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Diario del tifoso-Login</title>
        <link rel="stylesheet" href="../css/login.css">
        <link rel="icon" href="../src/images/logo_sito.png" type="image/ico">
        <script src="../js/login.js"></script>
    </head>
    <body>
        <div id="form-container">
            <img src="../src/images/logo_sito.png" alt="logo_sito" id="logo_sito">
            <form action="login.php" method="POST">
                <div class="campo">
                    <label for="username"><img src="../src/icons/user.png" alt="logo_username"></label>
                    <input type="text" name="username" id="username" placeholder="Username" pattern="[A-Za-z0-9_]{3,16}">
                </div>
                <div class="campo">
                    <label for="password"><img src="../src/icons/key.png" alt="logo_password"></label>
                    <input type="text" name="password" id="password" placeholder="Password" pattern="[A-Za-z0-9_$!%@]{4,}">
                </div>
                <?php
                    if($errore)
                        echo '<p id="error-msg">Email o password non corretta.</p>';
                ?>
                <button type="submit" id="login" name="login">Login</button>
            </form>
            <p>Non hai un account? <a href="registration.php">Registrati</a></p>
        </div>
        <footer>
            <small>
            Progetto di Progettazione Web | Professore: Alessio Vecchio - Studente: Francesco Lombardo | Università di Pisa
            </small>
        </footer>
    </body>
</html>