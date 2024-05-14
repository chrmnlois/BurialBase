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

    if ($id != 1) { // Check if $id is not 1 to allow deletion
        // MySQL Query
        $delete_query = "DELETE FROM `$del` WHERE admin_ID = $id";
        $delete_query_run = mysqli_query($connection, $delete_query);

        if ($delete_query_run) {
            $previousPage = $_SERVER['HTTP_REFERER'] ?? '../default_page.php';
            header("location: $previousPage");
            exit;
        } else {
            $previousPage = $_SERVER['HTTP_REFERER'] ?? '../default_page.php';
            header("location: $previousPage");
            exit;
        }
    } else {
        // If $id is 1, prevent deletion
        $_SESSION['status'] = "Error!";
        $_SESSION['text'] = "Record cannot be deleted";
        $_SESSION['status_code'] = "error";
        header("Location: ../default_page.php"); // Redirect to a default page
        exit;
    }
}
?>