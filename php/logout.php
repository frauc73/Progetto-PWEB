<?php
require_once("start_session.php");
$_SESSION = array();
session_destroy();
header("location: ../index.php");
exit();
?>