<?php

    include("config.php");


    $sqlDelete="DROP TABLE users";

    if ($dataApp->sql($sqlDelete) === TRUE) {
        echo "TABLE USERS DELETED \r\n";
    } else {
        echo "ERROR DELETING TABLE USERS ".$conn->error." \r\n";
    }//END if 


?>