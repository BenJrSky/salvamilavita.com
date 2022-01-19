<?php

    session_start();

    $status = $_SESSION["status"];

    if($status=="expired"){
        header("Location: https://www.salvamilavita.com/pricing.php");
    }

?>