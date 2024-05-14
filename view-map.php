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
        <title> View Map </title>

        <!-- CSS Link -->
        <link rel="stylesheet" href="style/view-map.css?v=<?php echo time(); ?>">
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
                    <li><a class="menu__item view-map" href="#"><i class='bx bx-map map'></i>View Map</a></li>
                    <li><a class="menu__item view-records" href="view-records.php"><i class='bx bx-folder record'></i></i>View Records</a></li>
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
                    <p> View Map </p>
                </div>
    
                <div class = "container"> <!-- Webpage Main Content Wrapper -->
                    <div class = "content-box"> <!-- Content Box Wrapper -->
                        <div class = "map-box"> <!-- Content Wrapper -->

                            <!-- Map Name & Address -->
                            <h4 class = "map-title"> Holy Family Parish Columbarium Map </h4>
                            <h6 class = "map-address"> Parang, Marikina City, Philippines </h6>

                            <div class = "map-content-wrapper"> <!-- Map Wrapper -->

                                <!-- Second Floor -->
                                <div class = "title-second"> 
                                    <p> Second Floor </p>
                                </div>

                                <div class = "map-second-floor">
                                    <a class = "st-philip-room" href="view-map/st-philip-map.php">
                                        <div class = "room-text-box">
                                            <h6> St. Philip </h6>
                                            <p> 2A </p>
                                        </div>
                                    </a>
    
                                    <a class = "st-bartolomew-room" href="view-map/st-bartolomew-map.php">
                                        <div class = "room-text-box">
                                            <h6> St. Bartolomew </h6>
                                            <p> 2B </p>
                                        </div>
                                    </a>

                                    <div class = "space-second-floor">

                                    </div>

                                    <a class = "st-thomas-room" href="view-map/st-thomas-map.php">
                                        <div class = "room-text-box">
                                            <h6> St. Thomas </h6>
                                            <p> 2C </p>

                                        </div>
                                    </a>

                                    <a class = "st-matthew-room" href="view-map/st-matthew-map.php">
                                        <div class = "room-text-box">
                                            <h6> St. Matthew </h6>
                                            <p> 2D </p>
                                        </div>
                                    </a>
                                    
                                    <a class = "st-james-alphaeus-room" href="view-map/st-james-alphaeus-map.php">
                                        <div class = "room-text-box">
                                            <h6> St. James Son of Alphaeus </h6>
                                            <!-- <h6> Son of Alphaeus </h6> -->
                                            <p> 2E </p>
                                        </div>
                                    </a>
                                    
                                    <a class = "st-thaddaeus-room" href="view-map/st-thaddaeus-map.php">
                                        <div class = "room-text-box">
                                            <h6> St. Thaddaeus </h6>
                                            <p> 2F </p>
                                        </div>
                                    </a>

                                    <a class = "st-simon-room" href="view-map/st-simon-map.php">
                                        <div class = "room-text-box">
                                            <h6> St. Simon </h6>
                                            <p> 2G </p>
                                        </div>
                                    </a>

                                    <div class = "stairs">

                                    </div>
                                </div> 

                                <!-- First Floor -->
                                <div class = "title-first"> 
                                    <p> First Floor </p>
                                </div>

                                <div class = "map-first-floor">

                                    <div class = "comfort-room" >
                                        <h6> Restroom </h6>
                                    </div>
    
                                    <div class = "space-first-floor" >
 
                                    </div>

                                    <a class = "st-john-room" href="view-map/st-john-map.php">
                                        <div class = "room-text-box">
                                            <h6> St. John </h6>
                                            <p> 1A </p>
                                        </div>
                                    </a>

                                    <a class = "st-james-room" href="view-map/st-james-map.php">
                                        <div class = "room-text-box">
                                            <h6> St. James </h6>
                                            <p> 1B </p>
                                        </div>
                                    </a>
                                    
                                    <a class = "st-andrew-room" href="view-map/st-andrew-map.php">
                                        <div class = "room-text-box">
                                            <h6> St. Andrew </h6>
                                            <p> 1C </p>
                                        </div>
                                    </a>
                                    
                                    <a class = "st-peter-room" href="view-map/st-peter-map.php">
                                        <div class = "room-text-box">
                                            <h6> St. Peter </h6>
                                            <p> 1D </p>
                                        </div>
                                    </a>

                                    <div class = "st-therese-chapel">
                                        <h6> St. Therese Chapel </h6>
                                    </div>
                                </div>
                        
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