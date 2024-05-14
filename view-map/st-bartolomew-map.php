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

    function fetchAllDataFromDatabase($connection) {
        // Query to fetch all data for all niche IDs
        $sql = "SELECT niche_ID, full_name, birth_date, death_date FROM st_bartolomew";
        $result = $connection->query($sql);
    
        // Create an associative array to store data for each niche ID
        $data = array();
    
        // Fetching data for all niche IDs and storing them in the associative array
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $nicheID = $row['niche_ID'];
    
                // Check if the niche_ID already exists in the array
                if (!isset($data[$nicheID])) {
                    $data[$nicheID] = array();
                }
    
                // Add the current record to the niche_ID's array
                $data[$nicheID][] = array(
                    'full_name' => $row['full_name'],
                    'birth_date' => $row['birth_date'],
                    'death_date' => $row['death_date']
                );
            }
        }
    
        return $data;
    }
    

    // Fetch all data for all niche IDs
    $allData = fetchAllDataFromDatabase($connection);

    // Close the database connection
    $connection->close();

    ?>






<!DOCTYPE html>
<html lang="en">

    <head>
        <!-- Compatibility -->
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- Webpage Title -->
        <title> View Map - St. Bartolomew </title>

        <!-- CSS Link -->
        <link rel="stylesheet" href="../style/st-bartolomew-map.css?v=<?php echo time(); ?>">
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

        <!-- JS -->
        <script defer src="https://code.jquery.com/jquery-3.7.0.js"></script>
        <script defer src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
        <script defer src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
        <script defer src="js/table.js"></script> 
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="js/sweet-alert.js"></script>

         <!-- Icon -->
         <link rel="icon" href="../icon-logo.png" type="image/png">
    </head>

    <body>
        <!-- Webpage Default Layout -->
        <div class = "wrapper"> <!-- Wrapper for the Whole Webpage -->

            <div class = "sidebar"> <!-- Sidebar -->
                <img src="../images/parish-logo.jpg">
                <div class = "columbarium-name"><p> Holy Family Parish </p></div>
                <div class = "columbarium-address"><p> Parang, Marikina City, Philippines </p></div>
            
                <ul class = "menu__box"> <!-- Menu Box of Sidebar -->
                    <li><a class="menu__item dashboard" href="../dashboard.php"><i class='bx bx-menu dashboard'></i>Dashboard</a></li>
                    <li><a class="menu__item add-deceased" href="../add-deceased.php"><i class='bx bx-user-plus deceased'></i>Add Deceased Person</a></li>
                    <li><a class="menu__item view-map" href="#"><i class='bx bx-map map'></i>View Map</a></li>
                    <li><a class="menu__item view-records" href="../view-records.php"><i class='bx bx-folder record'></i></i>View Records</a></li>
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
                    <p> View Map </p>
                </div>
    
                <div class = "container"> <!-- Webpage Main Content Wrapper -->
                    <div class = "content-box"> <!-- Content Box Wrapper -->
                        <div class = "map-box"> <!-- Content Wrapper -->

                            <!-- Map Name & Address -->
                            <div class = "map-header-with-bck">
                                <div class = "back-btn">
                                    <a href = "../view-map.php" title = "Back to Map"><i class='bx bx-arrow-back'></i> </a>
                                </div>

                                <div class = "map-name-add">
                                    <h2 class = "map-title"> St. Bartolomew - 2B</h2>
                                    <h6 class = "map-detail"> Niche Layout </h6>
                                </div>
                            </div>

                            <div class = "map-content-wrapper"> <!-- St bartolomew Map Wrapper -->

                                <!-- St. bartolomew Map -->
                                <div class = "st-bartolomew-map"> 
                                    <div class = "letter-headers">
                                        <h4 class = "letter-G"> G </h4>
                                        <br> 
                                        <h4 class = "letter-F"> F </h4>
                                        <br> 
                                        <h4 class = "letter-E"> E </h4>
                                        <br> 
                                        <h4 class = "letter-D"> D </h4>
                                        <br>
                                        <h4 class = "letter-C"> C </h4>
                                        <br>
                                        <h4 class = "letter-B"> B </h4>
                                        <br>
                                        <h4 class = "letter-A"> A </h4>
                                    </div>
                         
                                    <table class = "st-bartolomew-columns">
                                    <thead>
                                            <tr>
                                                <th class = "column-one"> 1 </th>
                                                <th class = "column-two"> 2 </th>
                                                <th class = "ocolumn-three"> 3 </th>
                                                <th class = "column-four"> 4 </th>
                                                <th class = "column-five"> 5 </th>
                                                <th class = "column-six"> 6 </th>
                                                <th class = "column-seven"> 7 </th>
                                                <th class = "column-eight"> 8 </th>
                                                <th class = "column-nine"> 9 </th>
                                              
                                                
                                            </tr>
                                        </thead>  

                                    <tbody>
                                    <?php

for ($row = ord('G'); $row >= ord('A'); $row--) {
    echo '<tr>';
    for ($col = 1; $col <= 9; $col++) {
        $cellName = chr($row) . $col; // Generate cell name (e.g., A1, A2, etc.)

        // Check if data exists for this cell's niche ID
        $cellDataExists = isset($allData[$cellName]);

        // Apply styles for cells with data
        $style = '';
        if ($cellDataExists) {
            $style = 'background-image: linear-gradient(to right, #998938, #665f20); color: white;';
        }

        // Apply the style to the table cell
        echo '<td name="' . $cellName . '" style="' . $style . '">';

        // Check if data exists for this cell's niche ID and display it
        if ($cellDataExists) {
            // Display up to 3 records for the same niche ID
            $count = 0;
            foreach ($allData[$cellName] as $data) {
                // Displaying initials of the first name and the last name
                $nameParts = explode(' ', $data['full_name']);

                if (count($nameParts) === 2) {
                    // Two-part name (e.g., Juan Cruz)
                    $firstNameInitial = $nameParts[0][0];
                    $lastName = end($nameParts);
                } else {
                    // Multiple-part name (e.g., James Justine De Guzman)
                    $firstNameInitial = $nameParts[0][0];
                    $lastName = end($nameParts);
                    if (count($nameParts) > 2) {
                        if (strpos($data['full_name'], '.') !== false) {
                            // Handle exception for 'T. Dela Paz'
                            $firstNameInitial = $nameParts[0][0];
                            $lastName = $nameParts[count($nameParts) - 1];
                        } else {
                            // Handle multiple-part names
                            $middleInitial = $nameParts[count($nameParts) - 1][0]; // Get the last part's initial
                            $lastName = $middleInitial . '. ' . $lastName;
                        }
                    }
                }

                echo '<strong>' . $firstNameInitial . '. ' . $lastName . "</strong><br>";

                if (!empty($data['birth_date'])) {
                    $birthYear = (new DateTime($data['birth_date']))->format('Y');
                } else {
                    $birthYear = 'N/A';
                }

                if (!empty($data['death_date'])) {
                    $deathYear = (new DateTime($data['death_date']))->format('Y');
                } else {
                    $deathYear = 'N/A';
                }

                echo $birthYear . '-' . $deathYear . '<br>';

                $count++;
                if ($count < 3) {
                    echo '<br>'; // Add space if it's not the last record
                } elseif ($count >= 3) {
                    break; // Limit reached, exit the loop
                }
            }
        } else {
            echo "Available";
        }
        echo '</td>';
    }
    echo '</tr>';
}
?>


                                    </tbody>
                                    </table> 
                    
                                </div>
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