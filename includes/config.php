<?php

    ob_start();

    session_start();

    $timezone = date_default_timezone_set("Europe/Rome");

    $con = mysqli_connect("localhost", "root", "", "momeer");

    if(mysqli_connect_errno()) {
        echo "Failed to connect: " . mysqli_connect_errno();
    }

?>