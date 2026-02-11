<?php
    define('DBHOST', 'localhost');
    define('DBNAME', 'lombardo_654330');
    define('DBUSER', 'root');
    define('DBPASS', '');

    function getDbConnection() {
        $connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
        if(mysqli_connect_errno()){
            die("Errore di connessione al database: " . mysqli_connect_error());
        }
        return $connection;
    }

?>
