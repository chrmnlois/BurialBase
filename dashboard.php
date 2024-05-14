<!-- PHP -->
<?php
require 'connect/connect.php';

    if(!empty($_SESSION["session_id"])) {
        $session_id = $_SESSION["session_id"];
        $result = mysqli_query($connection, "SELECT * FROM admin_records WHERE admin_ID = $session_id");
        $row = mysqli_fetch_assoc($result);

        // ST. JOHN
        $occupiedJohnQuery = "SELECT COUNT(DISTINCT niche_ID) AS occupied_john_count FROM st_john";
        $occupiedJohnResult = mysqli_query($connection, $occupiedJohnQuery);
        $occupiedJohnRow = mysqli_fetch_assoc($occupiedJohnResult);
        $occupiedJohnNicheCount = $occupiedJohnRow['occupied_john_count'];

        $totalJohnNicheCount = 77; 
        $availableJohnNicheCount = $totalJohnNicheCount - $occupiedJohnNicheCount;

        // ST. JAMES
        $occupiedJamesQuery = "SELECT COUNT(DISTINCT niche_ID) AS occupied_james_count FROM st_james";
        $occupiedJamesResult = mysqli_query($connection, $occupiedJamesQuery);
        $occupiedJamesRow = mysqli_fetch_assoc($occupiedJamesResult);
        $occupiedJamesNicheCount = $occupiedJamesRow['occupied_james_count'];

        $totalJamesNicheCount = 98;
        $availableJamesNicheCount = $totalJamesNicheCount - $occupiedJamesNicheCount;

        // ST. ANDREW
        $occupiedAndrewQuery = "SELECT COUNT(DISTINCT niche_ID) AS occupied_andrew_count FROM st_andrew";
        $occupiedAndrewResult = mysqli_query($connection, $occupiedAndrewQuery);
        $occupiedAndrewRow = mysqli_fetch_assoc($occupiedAndrewResult);
        $occupiedAndrewNicheCount = $occupiedAndrewRow['occupied_andrew_count'];

        $totalAndrewNicheCount = 98;
        $availableAndrewNicheCount = $totalAndrewNicheCount - $occupiedAndrewNicheCount;

        // ST. PETER
        $occupiedPeterQuery = "SELECT COUNT(DISTINCT niche_ID) AS occupied_peter_count FROM st_peter";
        $occupiedPeterResult = mysqli_query($connection, $occupiedPeterQuery);
        $occupiedPeterRow = mysqli_fetch_assoc($occupiedPeterResult);
        $occupiedPeterNicheCount = $occupiedPeterRow['occupied_peter_count'];

        $totalPeterNicheCount = 98;
        $availablePeterNicheCount = $totalPeterNicheCount - $occupiedPeterNicheCount;

        // ST. PHILIP
        $occupiedPhilipQuery = "SELECT COUNT(DISTINCT niche_ID) AS occupied_philip_count FROM st_philip";
        $occupiedPhilipResult = mysqli_query($connection, $occupiedPhilipQuery);
        $occupiedPhilipRow = mysqli_fetch_assoc($occupiedPhilipResult);
        $occupiedPhilipNicheCount = $occupiedPhilipRow['occupied_philip_count'];

        $totalPhilipNicheCount = 77;
        $availablePhilipNicheCount = $totalPhilipNicheCount - $occupiedPhilipNicheCount;

        // ST. BARTOLOMEW
        $occupiedBartolomewQuery = "SELECT COUNT(DISTINCT niche_ID) AS occupied_bartolomew_count FROM st_bartolomew";
        $occupiedBartolomewResult = mysqli_query($connection, $occupiedBartolomewQuery);
        $occupiedBartolomewRow = mysqli_fetch_assoc($occupiedBartolomewResult);
        $occupiedBartolomewNicheCount = $occupiedBartolomewRow['occupied_bartolomew_count'];

        $totalBartolomewNicheCount = 63;
        $availableBartolomewNicheCount = $totalBartolomewNicheCount - $occupiedBartolomewNicheCount;

        // ST. THOMAS
        $occupiedThomasQuery = "SELECT COUNT(DISTINCT niche_ID) AS occupied_thomas_count FROM st_thomas";
        $occupiedThomasResult = mysqli_query($connection, $occupiedThomasQuery);
        $occupiedThomasRow = mysqli_fetch_assoc($occupiedThomasResult);
        $occupiedThomasNicheCount = $occupiedThomasRow['occupied_thomas_count'];

        $totalThomasNicheCount = 77;
        $availableThomasNicheCount = $totalThomasNicheCount - $occupiedThomasNicheCount;

        // ST. MATTHEW
        $occupiedMatthewQuery = "SELECT COUNT(DISTINCT niche_ID) AS occupied_matthew_count FROM st_matthew";
        $occupiedMatthewResult = mysqli_query($connection, $occupiedMatthewQuery);
        $occupiedMatthewRow = mysqli_fetch_assoc($occupiedMatthewResult);
        $occupiedMatthewNicheCount = $occupiedMatthewRow['occupied_matthew_count'];

        $totalMatthewNicheCount = 98;
        $availableMatthewNicheCount = $totalMatthewNicheCount - $occupiedMatthewNicheCount;

        // ST. JAMES ALPHAUES
        $occupiedJamesAlphaeusQuery = "SELECT COUNT(DISTINCT niche_ID) AS occupied_james_alphaeus_count FROM st_james_alphaeus";
        $occupiedJamesAlphaeusResult = mysqli_query($connection, $occupiedJamesAlphaeusQuery);
        $occupiedJamesAlphaeusRow = mysqli_fetch_assoc($occupiedJamesAlphaeusResult);
        $occupiedJamesAlphaeusNicheCount = $occupiedJamesAlphaeusRow['occupied_james_alphaeus_count'];

        $totalJamesAlphaeusNicheCount = 98;
        $availableJamesAlphaeusNicheCount = $totalJamesAlphaeusNicheCount - $occupiedJamesAlphaeusNicheCount;

        // ST. THADDAEUS
        $occupiedThaddaeusQuery = "SELECT COUNT(DISTINCT niche_ID) AS occupied_thaddaeus_count FROM st_thaddaeus";
        $occupiedThaddaeusResult = mysqli_query($connection, $occupiedThaddaeusQuery);
        $occupiedThaddaeusRow = mysqli_fetch_assoc($occupiedThaddaeusResult);
        $occupiedThaddaeusNicheCount = $occupiedThaddaeusRow['occupied_thaddaeus_count'];

        $totalThaddaeusNicheCount = 98;
        $availableThaddaeusNicheCount = $totalThaddaeusNicheCount - $occupiedThaddaeusNicheCount;

        // ST. SIMON
        $occupiedSimonQuery = "SELECT COUNT(DISTINCT niche_ID) AS occupied_simon_count FROM st_simon";
        $occupiedSimonResult = mysqli_query($connection, $occupiedSimonQuery);
        $occupiedSimonRow = mysqli_fetch_assoc($occupiedSimonResult);
        $occupiedSimonNicheCount = $occupiedSimonRow['occupied_simon_count'];

        $totalSimonNicheCount = 70;
        $availableSimonNicheCount = $totalSimonNicheCount - $occupiedSimonNicheCount;
        
        // OVERALL COMPUTATION
        $overallTotalNiche = $totalJohnNicheCount + $totalJamesNicheCount + $totalAndrewNicheCount + $totalPeterNicheCount + $totalPhilipNicheCount + $totalBartolomewNicheCount + $totalThomasNicheCount + $totalMatthewNicheCount + $totalJamesAlphaeusNicheCount + $totalThaddaeusNicheCount + $totalSimonNicheCount;
        $overallAvailableNiche = $availableJohnNicheCount + $availableJamesNicheCount + $availableAndrewNicheCount + $availablePeterNicheCount + $availablePhilipNicheCount + $availableBartolomewNicheCount + $availableThomasNicheCount + $availableMatthewNicheCount + $availableJamesAlphaeusNicheCount + $availableThaddaeusNicheCount + $availableSimonNicheCount;
        $overallOccupiedNiche = $occupiedJohnNicheCount + $occupiedJamesNicheCount + $occupiedAndrewNicheCount + $occupiedPeterNicheCount + $occupiedPhilipNicheCount + $occupiedBartolomewNicheCount + $occupiedThomasNicheCount + $occupiedMatthewNicheCount + $occupiedJamesAlphaeusNicheCount + $occupiedThaddaeusNicheCount + $occupiedSimonNicheCount;


        } else {
        echo "Error Logging In!";
        header("Location: index.php");
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
        <title> Dashboard </title>

        <!-- CSS Link -->
        <link rel="stylesheet" href="style/dashboard.css?v=<?php echo time(); ?>">
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
                    <li><a class="menu__item dashboard" href="#"><i class='bx bx-menu dashboard'></i>Dashboard</a></li>
                    <li><a class="menu__item add-deceased" href="add-deceased.php"><i class='bx bx-user-plus deceased'></i>Add Deceased Person</a></li>
                    <li><a class="menu__item view-map" href="view-map.php"><i class='bx bx-map map'></i>View Map</a></li>
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

                <div class="cmis-header"> <!-- Webpage Header -->
                    <div class = "cmis-name"><p> Columbarium Mapping Information System </p></div>

                    <div class="user-profile">
                        <p>Hello, <?php echo $row["username"]?>!</p>
                        <img src="images/admin-picture.png" alt="User Picture">
                        
                    </div>
                </div>

                <div class = "webpage-title"> <!-- Webpage Title-->
                    <p> Dashboard </p>
                </div>
    
                <div class = "container"> <!-- Webpage Main Content Wrapper -->
                    <div class = "content-box"> <!-- Content Box Wrapper -->
                        <div class = "content"> <!-- Content Wrapper -->

                            <h4 class = "columbarium-statistics-label"> Columbarium Statistics </h4>
                    
                            <div class="stats">
                                <div class="total">
                                    <h4>Total Niche</h4>
                                    <p class="total-num"><?php echo $overallTotalNiche; ?></p>
                                </div>
                    
                                <div class="occupied">
                                    <h4>Occupied Niche</h4>
                                    <p class="available-num"><?php echo $overallOccupiedNiche; ?></p>
                                </div>
                                    
                                <div class="available">
                                    <h4>Available Niche</h4>
                                    <p class="available-num"><?php echo $overallAvailableNiche; ?></p>
                                </div>   
                            </div>

                            <h4 class = "room-statistics-label"> Room Statistics </h4>

                            <table class = "room-statistics">
                                <thead>
                                    <tr>
                                        <th class = "stat-room"> Room </th>
                                        <th class = "stat-available"> Available Niche </th>
                                        <th class = "stat-occupied"> Occupied Niche </th>
                                        <th class = "stat-total"> Total Niche</th>
                                    </tr>
                                </thead>  

                                <tbody>
                                    <tr>
                                        <td class="stat-room-name">St. John - 1A</td>
                                        <td class="available-john"><?php echo $availableJohnNicheCount;?></td>
                                        <td class="occupied-john"><?php echo $occupiedJohnNicheCount; ?></td>
                                        <td class="total-john"><?php echo $totalJohnNicheCount; ?></td>
                                    </tr>

                                    <tr>
                                        <td class = "stat-room-name"> St. James - 1B</td>
                                        <td> <?php echo $availableJamesNicheCount;?> </td>
                                        <td> <?php echo $occupiedJamesNicheCount; ?> </td>
                                        <td> <?php echo $totalJamesNicheCount; ?> </td>
                                    </tr>

                                    <tr>
                                        <td class = "stat-room-name"> St. Andrew - 1C</td>
                                        <td> <?php echo $availableAndrewNicheCount;?>  </td>
                                        <td> <?php echo $occupiedAndrewNicheCount; ?>   </td>
                                        <td> <?php echo $totalAndrewNicheCount; ?>  </td>
                                    </tr>

                                    <tr>
                                        <td class = "stat-room-name"> St. Peter - 1D</td>
                                        <td> <?php echo $availablePeterNicheCount;?>  </td>
                                        <td> <?php echo $occupiedPeterNicheCount; ?>  </td>
                                        <td> <?php echo $totalPeterNicheCount; ?>  </td>
                                    </tr>

                                    <tr>
                                        <td class = "stat-room-name"> St. Philip - 2A </td>
                                        <td> <?php echo $availablePhilipNicheCount;?>  </td>
                                        <td> <?php echo $occupiedPhilipNicheCount; ?> </td>
                                        <td> <?php echo $totalPhilipNicheCount; ?> </td>
                                    </tr>
                                    
                                    <tr>
                                        <td class = "stat-room-name"> St. Bartolomew - 2B </td>
                                        <td> <?php echo $availableBartolomewNicheCount;?> </td>
                                        <td> <?php echo $occupiedBartolomewNicheCount; ?>  </td>
                                        <td> <?php echo $totalBartolomewNicheCount; ?> </td>
                                    </tr>
                                    
                                    <tr>
                                        <td class="stat-room-name"> St. Thomas - 2C </td>
                                        <td> <?php echo $availableThomasNicheCount; ?> </td>
                                        <td> <?php echo $occupiedThomasNicheCount; ?> </td>
                                        <td> <?php echo $totalThomasNicheCount; ?> </td>
                                    </tr>

                                    <tr>
                                        <td class="stat-room-name"> St. Matthew - 2D </td>
                                        <td> <?php echo $availableMatthewNicheCount; ?> </td>
                                        <td> <?php echo $occupiedMatthewNicheCount; ?> </td>
                                        <td> <?php echo $totalMatthewNicheCount; ?> </td>
                                    </tr>

                                    <tr>
                                        <td class="stat-room-name"> St. James Son of Alphaeus - 2E </td>
                                        <td> <?php echo $availableJamesAlphaeusNicheCount; ?> </td>
                                        <td> <?php echo $occupiedJamesAlphaeusNicheCount; ?> </td>
                                        <td> <?php echo $totalJamesAlphaeusNicheCount; ?> </td>
                                    </tr>

                                    <tr>
                                        <td class="stat-room-name"> St. Thaddaeus - 2F </td>
                                        <td> <?php echo $availableThaddaeusNicheCount; ?> </td>
                                        <td> <?php echo $occupiedThaddaeusNicheCount; ?> </td>
                                        <td> <?php echo $totalThaddaeusNicheCount; ?> </td>
                                    </tr>

                                    <tr>
                                        <td class="stat-room-name"> St. Simon - 2G </td>
                                        <td> <?php echo $availableSimonNicheCount; ?> </td>
                                        <td> <?php echo $occupiedSimonNicheCount; ?> </td>
                                        <td> <?php echo $totalSimonNicheCount; ?> </td>
                                    </tr>
                            </table>

                        </div> <!-- End of Content Wrapper -->
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



    </body>
</html>