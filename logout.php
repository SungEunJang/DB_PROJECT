<?php
	include('dbcon.php');    
    include('logincheck.php');

    if (is_login()){

        unset($_SESSION['usernick']);
        session_destroy();
    }

    header("Location: index.php");
?>