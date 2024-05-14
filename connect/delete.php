<?php
include 'connect.php';

// Check Log In Credentials
if(!empty($_SESSION["session_id"])) {
    $session_id = $_SESSION["session_id"];
    $result = mysqli_query($connection, "SELECT * FROM admin_records WHERE admin_ID = $session_id");
    $row = mysqli_fetch_assoc($result);
}

else {
    echo "Error Logging In!";
    header("Location: ../index.php");
}

// If User Confirms to Delete the Record
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    $del = $_GET['del'] ?? '';

    // MySQL Query
    $delete_query = "DELETE FROM `$del` WHERE id = $id";
    $delete_query_run = mysqli_query($connection, $delete_query);

    if ($delete_query_run) {
        $previousPage = $_SERVER['HTTP_REFERER'] ?? '../default_page.php';
        header("location: $previousPage");
        exit; // Use exit() instead of die() after header redirect
    } 
    
    else {
        $previousPage = $_SERVER['HTTP_REFERER'] ?? '../default_page.php';
        header("location: $previousPage");
        exit; // Use exit() instead of die() after header redirect
    }
}
?>