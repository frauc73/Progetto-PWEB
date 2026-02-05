<?php
$errore = false;
$username_utilizzato = false;
$mail_utilizzata = false;
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(isset($_POST['registration']) && isset($_POST['nome']) && isset($_POST['cognome']) && isset($_POST['username']) && isset($_POST['password']) && isset($_POST['email'])){
        $nome = $_POST['nome'];
        $cognome = $_POST['cognome'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];
    
        //controlliamo gli input anche lato server
        $regex_nome_cognome = "/^[\p{L}\s'-]{2,50}$/u";
        $regex_username = "/[A-Za-z0-9_]{3,16}$/";
        $regex_psw = "/[A-Za-z0-9_$!%@]{4,10}$/";
        $regex_email = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";
        if(!preg_match($regex_nome_cognome, $nome) || !preg_match($regex_nome_cognome, $cognome) || !preg_match($regex_username, $username) || !preg_match($regex_psw, $password) || !preg_match($regex_email, $email)){
            $errore = true;
        } else {
            //qui i dati hanno il formato richiesto, posso quindi andare avanti
            //mi connetto al db
            require_once("dbaccess.php");
            $connection = mysqli_connect(DBHOST,DBUSER,DBPASS,DBNAME);
            if(mysqli_connect_errno()){
                die(mysqli_connect_error());
            }
    
            //ora devo controllare se l'username è già esistente, ed eventualmente bloccare la creazione dell'utente
            $controllo_username = "select * from Users where Username=?";
            if($statement1 = mysqli_prepare($connection, $controllo_username)){
                //preparo ed eseguo la query
                mysqli_stmt_bind_param($statement1, 's', $username);
                mysqli_stmt_execute($statement1);
                //controllo il risultato
                $result1 = mysqli_stmt_get_result($statement1);
                if(mysqli_num_rows($result1) != 0){
                    //in questo caso esiste un utente con quell'username
                    $username_utilizzato = true;
                    //pulisco la memoria dal result set e chiudo la connessione con il database
                    mysqli_free_result($result1);
                    mysqli_close($connection);
                } else {
                    //ora dobbiamo controllare se la mail inserita non è associata a qualcun altro utente, e anche qui in caso contrario bloccare la creazione dell'utente
                    $controllo_mail = "select * from Users where Email=?";
                    if($statement_mail = mysqli_prepare($connection, $controllo_mail)){
                        //preparo ed eseguo la query
                        mysqli_stmt_bind_param($statement_mail, 's', $email);
                        mysqli_stmt_execute($statement_mail);
                        //controllo il risultato
                        $result_mail = mysqli_stmt_get_result($statement_mail);
                        if(mysqli_num_rows($result_mail) != 0){
                            //in questo caso esiste un utente con quell'username
                            $mail_utilizzata = true;
                            //pulisco la memoria dal result set e chiudo la connessione con il database
                            mysqli_free_result($result_mail);
                            mysqli_close($connection);
                        } else {
                            //arrivati qui dobbiamo inserire l'utente nel database
                            //per una questione di sicurezza scelgo di utilizzare le transazioni 
                            //disabilito l'autocommit
                            mysqli_begin_transaction($connection);
                            $inserisci_utente = "insert into Users (Username, Password, Nome, Cognome, Email, PathFotoProfilo) values (?, ?, ?, ?, ?, ?)";
                            if($statement2 = mysqli_prepare($connection, $inserisci_utente)){
                                //genero la password
                                $hash = password_hash($password,PASSWORD_BCRYPT);
                                //preparo la foto di default
                                $pathFotoProfilo = "../src/profile_pic/default.png";
                                //preparo la query 
                                mysqli_stmt_bind_param($statement2, 'ssssss', $username, $hash, $nome, $cognome, $email,$pathFotoProfilo);
                                //eseguo la query
                                if(mysqli_stmt_execute($statement2)){
                                    //confermo la transazione
                                    mysqli_commit($connection); 
                                    //pulisco la memoria dal result set e chiudo la connessione con il database
                                    mysqli_close($connection);
                                    //indirizzo l'utente verso la pagina per accedere
                                    header("location: login.php");
                                } else {
                                    //annullo tutto in caso di errore
                                    mysqli_rollback($connection);
                                    echo "<script>alert('Errore durante la registrazione.')</script>";
                                    //pulisco la memoria dal result set e chiudo la connessione con il database
                                    mysqli_close($connection);
                                }
                            }
                        }
                    }
                }
            }
        }
    } else {
        echo "<script>window.alert('Riempi tutti i campi richiesti')</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="it">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Diario del tifoso-Registrazione</title>
        <link rel="stylesheet" href="../css/login.css">
        <link rel="icon" href="../src/images/logo_sito.png" type="image/ico">
        <script src="../js/registration.js"></script>
    </head>
    <body onload="init()">
        <div id="form-container">
            <img src="../src/images/logo_sito.png" alt="logo_sito" id="logo_sito">
            <form action="registration.php" method="POST">
                <h3>Riempi i campi con i tuoi dati per registrarti</h3>
                <table>
                    <tr>
                        <td><input type="text" name="nome" id="nome" placeholder="Nome" required pattern="^[\p{L}\s'-]{2,50}$"></td>
                    </tr>
                    <tr>
                        <td><input type="text" name="cognome" id="cognome" placeholder="Cognome" required pattern="^[\p{L}\s'-]{2,50}$"></td>
                    </tr>
                    <tr>
                        <td><input type="email" name="email" id="email" placeholder="Email" required pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$"></td>
                    </tr>
                    <tr>
                        <td>
                            <input type="text" name="username" id="username" placeholder="Username" required pattern="[A-Za-z0-9_]{3,16}">
                            <small>Da 3 a 16 caratteri, solo lettere, numeri e underscore</small>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="text" name="password" id="password" placeholder="Password" required pattern="[A-Za-z0-9_$!%@]{4,10}">
                            <small>Da 4 a 10 caratteri, ammessi lettere, numeri e i simboli _$!%@</small>
                        </td>    
                    </tr>
                    <?php
                        if($errore)
                            echo '<p id="error-msg">Inserisci i dati nel giusto formato.</p>';
                        if($username_utilizzato)
                            echo '<p id="error-msg">Hai scelto un username che appartiene già a qualcuno.</p>';
                        if($mail_utilizzata)
                            echo '<p id="error-msg">Hai scelto un mail che appartiene già a qualcuno.</p>';
                    ?>
                </table>
                <button type="submit" id="registration" name="registration">Registrati</button>
            </form>
            <p>Hai un account? <a href="login.php">Accedi</a></p>
        </div>
        <footer>
            <small>
            Progetto di Progettazione Web | Professore: Alessio Vecchio - Studente: Francesco Lombardo | Università di Pisa
            </small>
        </footer>
    </body>
</html>