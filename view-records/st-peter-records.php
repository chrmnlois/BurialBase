<?php
    require '../connect/connect.php';

    // Check Log In Credentials
    if(!empty($_SESSION["session_id"])) {
        $session_id = $_SESSION["session_id"];
        $result = mysqli_query($connection, "SELECT * FROM admin_records WHERE admin_ID = $session_id");
        $row = mysqli_fetch_assoc($result);
    } else {
        // Redirect to login page if session variable is not set
        header("Location: index.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <!-- Compatibility -->
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- Webpage Title -->
        <title> View Records - St. Peter </title>

        <!-- CSS Link -->
        <link rel="stylesheet" href="../style/st-peter-records.css?v=<?php echo time(); ?>">
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

        <!-- Bootstrap 5 -->
        <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css"> -->
        <!-- <link rel="stylesheet" href="https://toert.github.io/Isolated-Bootstrap/versions/4.0.0-beta/iso_bootstrap4.0.0min.css"> -->
        <!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css"> -->
        
        <!-- JS -->
        <script defer src="https://code.jquery.com/jquery-3.7.0.js"></script>
        <script defer src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
        <script defer src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
        <script defer src="../js/table.js"></script> 
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="../js/sweet-alert.js"></script>

         <!-- Icon -->
         <link rel="icon" href="../icon-logo.png" type="image/png">
    </head>

    <body>
        <!-- Webpage Default Layout -->
        <div class = "wrapper custom-section"> <!-- Wrapper for the Whole Webpage -->

            <div class = "sidebar"> <!-- Sidebar -->
                <img src="../images/parish-logo.jpg">
                <div class = "columbarium-name"><p> Holy Family Parish </p></div>
                <div class = "columbarium-address"><p> Parang, Marikina City, Philippines </p></div>
            
                <ul class = "menu__box"> <!-- Menu Box of Sidebar -->
                    <li><a class="menu__item dashboard" href="../dashboard.php"><i class='bx bx-menu dashboard'></i>Dashboard</a></li>
                    <li><a class="menu__item add-deceased" href="../add-deceased.php"><i class='bx bx-user-plus deceased'></i>Add Deceased Person</a></li>
                    <li><a class="menu__item view-map" href="../view-map.php"><i class='bx bx-map map'></i>View Map</a></li>
                    <li><a class="menu__item view-records" href="#"><i class='bx bx-folder record'></i></i>View Records</a></li>
                    <li><a class="menu__item generate-reports" href="../generate-reports.php"><i class='bx bx-spreadsheet report'></i>Generate Reports</a></li>
                    <li><a class="menu__item manage-users" href="../manage-users.php"><i class='bx bx-user-circle users'></i>Manage Users</a></li>
                    <li><a class="menu__item log-out" href="../logout.php" id = "logoutButton"><i class='bx bx-log-out'></i></i>Log Out</a></li>
                </ul>

                <footer class = "watermark"> <!-- Footer -->
                    <p>Powered by BurialBase © 2023</p>
                </footer>
            </div>
    
            <div class = "main-content"> <!-- Webpage Main Content Section -->

                <header class="cmis-header"> <!-- Webpage Header -->
                    <div class = "cmis-name"><p> Columbarium Mapping Information System </p></div>

                    <div class="user-profile">
                    <p>Hello, <?php if (!empty($row['username'])) {
                                                echo "" . $row['username'] . "!";
                                                // Other code related to the username
                                            } else {
                                                // Handle the case where 'username' is not found in the row
                                                echo "Unknown User";
                                            }?></p>
                        <img src="../images/admin-picture.png" alt="User Picture">
                    </div>
                </header>

                <div class = "webpage-title"> <!-- Webpage Title-->
                    <p> View Records </p>
                </div>
    
                <div class = "container"> <!-- Webpage Main Content Wrapper -->
                    <div class = "content-box"> <!-- Content Box Wrapper -->
                    <div class = "map-header-with-bck">
                                <div class = "back-btn">
                                    <a href = "../view-records.php" title = "Back to View Records"><i class='bx bx-arrow-back'></i> </a>
                                </div>

                                <div class = "map-name-add">
                                    <h2 class = "map-title"> St. Peter - 1D</h2>
                                    <h6 class = "map-detail"> Deceased Records </h6>
                                </div>
                        </div>
                        
                        <div class = "bootstrap"> <!-- Content Wrapper -->
                            <!-- Records Table -->
                            <table id = "example" class = "table table-striped">
                                <thead>
                                    <tr>
                                        <th class = "niche-header-ID"> Niche ID </th>
                                        <th class = "niche-header-name"> Full Name </th>
                                        <th class = "niche-header-birth"> Date of Birth </th>
                                        <th class = "niche-header-death"> Date of Death </th>
                                        <th class = "niche-header-age"> Age </th>
                                        <th class = "niche-header-contact"> Contact Person </th>
                                        <th class = "niche-header-mobile"> Mobile Number </th>
                                        <th class = "niche-header-action"> Action </th>
                                    </tr>
                                </thead>   
                                
                                <tbody>
                                    <!-- PHP Connection -->
                                    <?php // View St. Peter Records
                                    
                                    // Check Connection
                                    if ($connection->connect_error) {
                                        die("Connection failed: " . $connection->connect_error);
                                    }

                                    // Read All Row From Database Table
                                    $sql = "SELECT * FROM st_peter";
                                    $result = $connection->query($sql);

                                    if (!$result) {
                                        die("Invalid query : " . $connection->error);
                                    }

                                    // Read Data of Each Row
                                    while($row = $result->fetch_assoc()) {
                                        $table = "St. Peter";
                                        $del = 'st_peter';
                                        $id = $row["id"];
                                        $niche_ID = $row["niche_ID"];
                                        $full_name = $row["full_name"];
                                        $birth_date = $row["birth_date"];
                                        $death_date = $row["death_date"];
                                        $age = $row["age"];
                                        $contact_person = $row["contact_person"];
                                        $contact_number = $row["contact_number"];

                                        echo "<tr>
                                            <td> " . $row["niche_ID"] . " </td>
                                            <td> " . $row["full_name"] . " </td>
                                            <td> " . $row["birth_date"] . " </td>
                                            <td> " . $row["death_date"] . " </td>
                                            <td> " . $row["age"] . " </td>
                                            <td> " . $row["contact_person"] . " </td>
                                            <td> " . $row["contact_number"] . " </td>
                                            <td> 
                                                <div class = \"action-wrapper\">
                                                    <a href = \"../connect/update.php?update_id=$id&table=$table&del=$del&nid=$niche_ID\"title=\"Update\"><i class='bx bx-edit' name = \"update\"></i></a>
                                                    <a href=\"javascript:void(0);\" onclick=\"confirmDelete($id, '$del')\" title=\"Delete\"><i class='bx bx-trash' name = \"delete\"></i>  </a>
                                                </div>
                                             </td> 
                                            </tr>";
                                        }

                                        echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>';

                                        // Add JavaScript function to handle the SweetAlert confirmation
                                        echo "<script>
                                            function confirmDelete(id, del, file) {
                                                Swal.fire({
                                                    title: 'Are you sure?',
                                                    text: 'You will not be able to recover this record!',
                                                    icon: 'warning',
                                                    showCancelButton: true,
                                                    confirmButtonColor: '#0A633C',
                                                    cancelButtonColor: 'gray',
                                                    confirmButtonText: 'Yes, delete it!'
                                                }).then((result) => {
                                                    if (result.isConfirmed) {
                                                        window.location.href = '../connect/delete.php?delete_id=' + id + '&del=' + del;
                                                    }
                                                });
                                            }
                                        </script>";
                                        ?>   
                                </tbody>
                            </table>
                            <?php 
                                // Alert (Record Added or Not)
                                if (isset($_SESSION['status']) && $_SESSION['status'] !='') 
                                {
                                    ?>
                                        <script> 
                                            Swal.fire({
                                                title: '<?php echo $_SESSION['status']; ?>',
                                                text: '<?php echo $_SESSION['text']; ?>',
                                                icon: '<?php echo $_SESSION['status_code']; ?>',
                                                button: "OK",
                                                confirmButtonColor: '#0A633C',
                                            });
                                        </script>
                                    <?php
                                        unset($_SESSION['status']);
                                }
                            ?> 
                        </div>
                    </div>

                </div>
    
            </div> <!-- End of main content -->
        </div> <!-- End of Webpage Default Layout -->

        <!-- Log Out -->
        <script> 
            document.getElementById('logoutButton').addEventListener('click', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Are you sure?',
                        text: 'You will be logged out!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#0A633C',
                        cancelButtonColor: '',
                        confirmButtonText: 'Yes, logout!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // If confirmed, redirect to logout.php after the SweetAlert closes
                            Swal.fire({
                                title: 'Logging out...',
                                // icon: 'info',
                                imageUrl: '../images/logout.png',
                                showConfirmButton: false
                            });
                            setTimeout(() => {
                                window.location.href = '../logout.php';
                            }, 1500); // Adjust the time as needed
                        }
                    });
                });
        </script>

    </body>
</html>