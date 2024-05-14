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

    // Export to Excel
        if (isset($_POST['excel'])) {
            $selected_table = $_POST['report-table'];

            // Check if the selected table is not the default "Select Option"
            if ($selected_table !== '#' && $selected_table !== 'room') {
                $query = "SELECT * FROM $selected_table";
                $result = mysqli_query($connection, $query);

                // Create Excel content if data is available
                if ($result && mysqli_num_rows($result) > 0) {
                    header('Content-Type: application/vnd.ms-excel');
                    $file_name = $selected_table . '_' . date('Y-m-d') . '.xls'; // File name with table name and current date
                    header("Content-Disposition: attachment; filename=\"$file_name\"");

                    // Excel header row with bold and capitalized text
                    echo "Niche ID\tFull Name\tDate of Birth\tDate of Death\tAge\t<b>Contact Person\tMobile Number\n";

                    while ($row = mysqli_fetch_assoc($result)) {
                        // Escape tab characters and line breaks in the data
                        echo "{$row['niche_ID']}\t{$row['full_name']}\t{$row['birth_date']}\t{$row['death_date']}\t{$row['age']}\t{$row['contact_person']}\t'{$row['contact_number']}\n";
                    }
                    exit();
                } else {
                    echo "No records found for export.";
                }
            } else {
                echo "Please select a valid option for export.";
            }
        }

// Export to PDF using FPDF
if (isset($_POST['pdf'])) {
    $selected_table = $_POST['report-table'];

    if ($selected_table !== '#' && $selected_table !== 'room') {
        require('fpdf186/fpdf.php'); // Include FPDF library

        $query = "SELECT * FROM $selected_table";
        $result = mysqli_query($connection, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $pdf = new FPDF('L'); // Create instance of FPDF in landscape mode
            $pdf->AddPage();
            $pdf->SetFont('Arial', 'B', 16);

            // Table name formatting
            $table_display_name = ucwords(str_replace("_", " ", $selected_table)); // Converts to title case and replaces underscore with space

            // Title
            $pdf->Cell(0, 10, 'Holy Family Parish Columbarium', 0, 1, 'C');
            $pdf->SetFont('Arial', 'B', 14);
            $pdf->Cell(0, 10, 'Deceased Records', 0, 1, 'C');
            $pdf->Ln(10); // Line break

            // Report date
            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(0, 10, 'Report Generated on: ' . date('Y-m-d'), 0, 1, 'C');
            $pdf->Ln(10); // Line break

            // Display formatted table name
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Cell(0, 10, $table_display_name, 0, 1, 'C');
            $pdf->Ln(5); // Line break

            // Header columns
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->Cell(30, 10, 'Niche ID', 1, 0, 'C');
            $pdf->Cell(40, 10, 'Full Name', 1, 0, 'C');
            $pdf->Cell(30, 10, 'Date of Birth', 1, 0, 'C');
            $pdf->Cell(30, 10, 'Date of Death', 1, 0, 'C');
            $pdf->Cell(15, 10, 'Age', 1, 0, 'C');
            $pdf->Cell(40, 10, 'Contact Person', 1, 0, 'C');
            $pdf->Cell(50, 10, 'Mobile Number', 1, 1, 'C'); // Increased width for Mobile Number cell

            // Fetch and add rows
            while ($row = mysqli_fetch_assoc($result)) {
                $pdf->Cell(30, 10, $row['niche_ID'], 1, 0, 'C');
                $pdf->Cell(40, 10, $row['full_name'], 1, 0, 'C');
                $pdf->Cell(30, 10, $row['birth_date'], 1, 0, 'C');
                $pdf->Cell(30, 10, $row['death_date'], 1, 0, 'C');
                $pdf->Cell(15, 10, $row['age'], 1, 0, 'C');
                $pdf->Cell(40, 10, $row['contact_person'], 1, 0, 'C');
                $pdf->Cell(50, 10, $row['contact_number'], 1, 1, 'C'); // Increased width for Mobile Number cell
            }

            // Output PDF
            $file_name = $selected_table . '_' . date('Y-m-d') . '.pdf';
            $pdf->Output($file_name, 'D'); // 'D' to force download

            exit();
        } else {
            echo "No records found for export.";
        }
    } else {
        echo "Please select a valid option for export.";
    }
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
        <title> Generate Reports </title>

        <!-- CSS Link-->
        <link rel="stylesheet" href="style/generate-reports.css?v=<?php echo time(); ?>">
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

         <!-- JS -->
         <script defer src="https://code.jquery.com/jquery-3.7.0.js"></script>
        <script defer src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
        <script defer src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
        <script defer src="js/table.js"></script> 
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="js/sweet-alert.js"></script>

         <!-- Icon -->
         <link rel="icon" href="icon-logo.png" type="image/png">
    </head>

    <body>
        <!-- Webpage Default Layout -->
        <div class = "wrapper">

            <div class = "sidebar">
                <img src="images/parish-logo.jpg">
                <div class = "columbarium-name"><p> Holy Family Parish </p></div>
                <div class = "columbarium-address"><p> Parang, Marikina City, Philippines </p></div>
            
                <ul class = "menu__box">
                    <li><a class="menu__item dashboard" href="dashboard.php"><i class='bx bx-menu dashboard'></i>Dashboard</a></li>
                    <li><a class="menu__item add-deceased" href="add-deceased.php"><i class='bx bx-user-plus deceased'></i>Add Deceased Person</a></li>
                    <li><a class="menu__item view-map" href="view-map.php"><i class='bx bx-map map'></i>View Map</a></li>
                    <li><a class="menu__item view-records" href="view-records.php"><i class='bx bx-folder record'></i></i>View Records</a></li>
                    <li><a class="menu__item generate-reports" href="#"><i class='bx bx-spreadsheet report'></i>Generate Reports</a></li>
                    <li><a class="menu__item manage-users" href="manage-users.php"><i class='bx bx-user-circle users'></i>Manage Users</a></li>
                    <li><a class="menu__item log-out" href="logout.php" id = "logoutButton"><i class='bx bx-log-out'></i></i>Log Out</a></li>
                </ul>

                <footer class = "watermark">
                    <p>Powered by BurialBase © 2023</p>
                </footer>
            </div>
    
            <div class = "main-content">

                <header class="cmis-header"> 
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

                <div class = "webpage-title">
                    <p> Generate Reports </p>
                </div>
    
                <div class = "container">
                    <div class = "content-box">
                        <div class = "content">
                            <div class = "report-header">
                                <form action="#" method="post" class="reports-form">
                                    <div class = "report-selection">
                                        <h3> Generate Reports for </h3>
                                        <select name = "report-table" class="select-report" required>
                                            <option value="st_john" <?php if(isset($_POST['report-table']) && $_POST['report-table'] == 'st_john') echo 'selected'; ?>> 1A - St. John </option>
                                            <option value="st_james" <?php if(isset($_POST['report-table']) && $_POST['report-table'] == 'st_james') echo 'selected'; ?>> 1B - St. James </option>
                                            <option value="st_andrew" <?php if(isset($_POST['report-table']) && $_POST['report-table'] == 'st_andrew') echo 'selected'; ?>> 1C - St. Andrew </option>
                                            <option value="st_peter" <?php if(isset($_POST['report-table']) && $_POST['report-table'] == 'st_peter') echo 'selected'; ?>> 1D - St. Peter </option>
                                            <option value="st_philip" <?php if(isset($_POST['report-table']) && $_POST['report-table'] == 'st_philip') echo 'selected'; ?>> 2A - St. Philip </option>
                                            <option value="st_bartolomew" <?php if(isset($_POST['report-table']) && $_POST['report-table'] == 'st_bartolomew') echo 'selected'; ?>> 2B - St. Bartolomew </option>
                                            <option value="st_thomas" <?php if(isset($_POST['report-table']) && $_POST['report-table'] == 'st_thomas') echo 'selected'; ?>> 2C - St. Thomas </option>
                                            <option value="st_matthew" <?php if(isset($_POST['report-table']) && $_POST['report-table'] == 'st_matthew') echo 'selected'; ?>> 2D - St. Matthew </option>
                                            <option value="st_james_alphaeus" <?php if(isset($_POST['report-table']) && $_POST['report-table'] == 'st_james_alphaeus') echo 'selected'; ?>> 2E - St. James Son of Alphaeus </option>
                                            <option value="st_thaddaeus" <?php if(isset($_POST['report-table']) && $_POST['report-table'] == 'st_thaddaeus') echo 'selected'; ?>> 2F - St. Thaddaeus </option>
                                            <option value="st_simon" <?php if(isset($_POST['report-table']) && $_POST['report-table'] == 'st_simon') echo 'selected'; ?>> 2G - St. Simon </option>
                                        </select>

                                        <button type="submit" name="report-btn" class="generate-btn"> Generate </button>
                                    </div>

                                    <div class = "export-buttons">
                                        <h3> Export to </h3>
                                        <button type="submit" name="excel" class="excel"> <i class='bx bxl-microsoft-teams'></i> <p class = "excel-label">Excel</p> </button> 
                                        <button type="submit" name="pdf" class="pdf"> <i class='bx bxs-file-pdf'></i></i> <p class = "pdf-label">PDF</p> </button> 
                                    </div>
                                </form>
                                
                                <div class="display-records">
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
                                        </tr>
                                    </thead>   

                                        <tbody>
                                            <?php
                                            // Check if form is submitted
                                            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                                // Retrieve selected table name
                                                $selected_table = $_POST['report-table'];

                                                // Perform query based on the selected table
                                                $result = mysqli_query($connection, "SELECT * FROM $selected_table");

                                                // Mapping of table names to user-friendly names
                                                $table_names = array(
                                                    "st_john" => "St. John - 1A",
                                                    "st_james" => "St. James - 1B",
                                                    "st_andrew" => "St. Andrew - 1C",
                                                    "st_peter" => "St. Peter - 1D",
                                                    "st_philip" => "St. Philip - 2A",
                                                    "st_bartolomew" => "St. Bartolomew - 2B",
                                                    "st_thomas" => "St. Thomas - 2C",
                                                    "st_matthew" => "St. Matthew - 2D",
                                                    "st_james_alphaeus" => "St. James Son of Alphaeus - 2E",
                                                    "st_thaddaeus" => "St. Thaddaeus - 2F",
                                                    "st_simon" => "St. Simon - 2G",
                                                );

                                                // Display fetched records
                                                if (array_key_exists($selected_table, $table_names)) {
                                                    $display_table_name = $table_names[$selected_table];
                                                    echo "<h3 class='table-name-display'>Records from $display_table_name</h3>";
                                        
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        echo "<tr>";
                                                        echo "<td>" . $row["niche_ID"] . "</td>"; 
                                                        echo "<td>" . $row["full_name"] . "</td>"; 
                                                        echo "<td>" . $row["birth_date"] . "</td>"; 
                                                        echo "<td>" . $row["death_date"] . "</td>"; 
                                                        echo "<td>" . $row["age"] . "</td>"; 
                                                        echo "<td>" . $row["contact_person"] . "</td>"; 
                                                        echo "<td>" . $row["contact_number"] . "</td>"; 
                                                        echo "</tr>";
                                                    }
                                                } else {
                                                    echo "<h3>No records found for this selection.</h3>";
                                                }
                                            }

                                        
                                            ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    
            </div>

        </div>
        <!-- End of Webpage Default Layout -->

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