<!-- PHP -->
<?php
    require 'connect/connect.php';

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

<!-- HTML -->
<!DOCTYPE html>
<html lang="en">

    <head>
        <!-- Compatibility -->
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- Webpage Title -->
        <title> View Records </title>

        <!-- CSS Link -->
        <link rel="stylesheet" href="style/view-records.css?v=<?php echo time(); ?>">
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

        <!-- JavaScript Link -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="sweet-alert.js"></script>

         <!-- Icon -->
         <link rel="icon" href="icon-logo.png" type="image/png">
    </head>

    <body>
        <!-- Webpage Default Layout -->
        <div class = "wrapper"> <!-- Wrapper for the Whole Webpage -->

            <div class = "sidebar"> <!-- Sidebar -->
                <img src="images/parish-logo.jpg">
                <div class = "columbarium-name"><p> Holy Family Parish </p></div>
                <div class = "columbarium-address"><p> Parang, Marikina City, Philippines </p></div>
            
                <ul class = "menu__box"> <!-- Menu Box of Sidebar -->
                    <li><a class="menu__item dashboard" href="dashboard.php"><i class='bx bx-menu dashboard'></i>Dashboard</a></li>
                    <li><a class="menu__item add-deceased" href="add-deceased.php"><i class='bx bx-user-plus deceased'></i>Add Deceased Person</a></li>
                    <li><a class="menu__item view-map" href="view-map.php"><i class='bx bx-map map'></i>View Map</a></li>
                    <li><a class="menu__item view-records" href="#"><i class='bx bx-folder record'></i></i>View Records</a></li>
                    <li><a class="menu__item generate-reports" href="generate-reports.php"><i class='bx bx-spreadsheet report'></i>Generate Reports</a></li>
                    <li><a class="menu__item manage-users" href="manage-users.php"><i class='bx bx-user-circle users'></i>Manage Users</a></li>
                    <li><a class="menu__item log-out" href="logout.php" id = "logoutButton"><i class='bx bx-log-out'></i></i>Log Out</a></li>
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
                        <img src="images/admin-picture.png" alt="User Picture">
                    </div>
                </header>

                <div class = "webpage-title"> <!-- Webpage Title-->
                    <p> View Records </p>
                </div>
    
                <div class = "container"> <!-- Webpage Main Content Wrapper -->
                    <div class = "content-box"> <!-- Content Box Wrapper -->

                        <h4 class = "view-records-label"> Show the Deceased Records Table of </h4>
                        <div class = "content-wrapper"> <!-- Content Wrapper -->
                            <div class="row-one">
                                <a href="view-records/st-john-records.php" class = "st-john"> 
                                    <img src = "images/st-john.png">
                                </a>

                                <a href="view-records/st-james-records.php" class = "st-james">
                                <img src = "images/st-james.png">
                                </a>

                                <a href="view-records/st-andrew-records.php" class = "st-andrew">
                                <img src = "images/st-andrew.png">
                                </a>
                                    
                                <a href="view-records/st-peter-records.php" class = "st-peter">
                                <img src = "images/st-peter.png">
                                </a>

                                <a href="view-records/st-philip-records.php" class = "st-philip">
                                <img src = "images/st-philip.png">
                                </a>

                                <a href="view-records/st-bartolomew-records.php" class = "st-bartholomew">
                                <img src = "images/st-bartholomew.png">
                                </a>

                            </div>

                            <div class="row-two">
                                <a href="view-records/st-thomas-records.php" class = "st-thomas">
                                    <img src = "images/st-thomas.png">
                                </a>

                                <a href="view-records/st-matthew-records.php" class = "st-matthew">
                                <img src = "images/st-matthew.png">
                                </a>

                                <a href="view-records/st-james-alphaeus-records.php" class = "st-james-alphaeus">
                                <img src = "images/st-james-alphaeus.png">
                                </a>

                                <a href="view-records/st-thaddaeus-records.php" class = "st-thaddaeus">
                                <img src = "images/st-thaddaeus.png">
                                </a>

                                <a href="view-records/st-simon-records.php" class = "st-simon">
                                <img src = "images/st-simon.png">
                                </a>
                            </div>


                        </div>
                    </div>

                </div>
    
            </div> <!-- End of main content -->
        </div> <!-- End of Webpage Default Layout -->

        <!-- JAVASCRIPT -->
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
                                        imageUrl: 'images/logout.png',
                                        showConfirmButton: false
                                    });
                                    setTimeout(() => {
                                        window.location.href = 'logout.php';
                                    }, 1500); // Adjust the time as needed
                                }
                            });
                        });
            </script>

            <!-- PHP -->
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

    </body>
</html>