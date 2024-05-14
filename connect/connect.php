<?php
    session_start();

    // LOCAL HOST
    if(!$connection = mysqli_connect("localhost", "root", "", "columbarium_db")) {

       die("Failed to connect!". mysqli_connect_error());
    }

    // ONLINE CONNECTION
    //if(!$connection = mysqli_connect("sql211.infinityfree.com", "if0_35463471", "5FM33kCw2MQXY4", "if0_35463471_columbarium_db")) {
    //    die("Failed to connect!". mysqli_connect_error());
    //}

?>