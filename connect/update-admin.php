<!-- PHP -->
<?php 
require 'connect.php';

// Fetch session user's details based on session_id
$session_id = $_SESSION["session_id"] ?? null;
$sessionUsername = '';
if ($session_id) {
    $sessionResult = mysqli_query($connection, "SELECT * FROM admin_records WHERE admin_ID = $session_id");
    $sessionRow = mysqli_fetch_assoc($sessionResult);
    $sessionUsername = $sessionRow['username'] ?? '';
} else {
    // Redirect to login page if session variable is not set
    header("Location: ../index.php");
    exit();
}

// GLOBAL GET VARIABLES FROM URL
$id = $_GET['update_id'];
$table = $_GET['table'] ?? '';
$del = $_GET['del'] ?? '';
$updateIDUsername = '';

if ($id != 1) { // Check if $id is not 10 to proceed with the update logic

    // Display data that will be updated to input boxes
    $sql = "SELECT * FROM $del WHERE admin_ID = ?";
    $stmt = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // Initialize variables to avoid accessing null indexes
        $full_name = $row['full_name'] ?? '';
        $updateIDUsername = $row['username'] ?? '';
        $password = $row['pass'] ?? '';
    } else {
        // Handle case where no rows are fetched or an error occurs
        // For instance, set default values or display an error message
        $full_name = '';
        $updateIDUsername = '';
        $password = '';
    }
} else {
    $_SESSION['status'] = "Error!";
    $_SESSION['text'] = "Root Account cannot be updated";
    $_SESSION['status_code'] = "error";
    echo '<script>window.history.go(-1);</script>';
    exit;
}

// If Update Button is Clicked
if (isset($_POST["update-button"])) {
    $full_name = $_POST['full_name'];
    $username = $_POST['username'];
    $password = $_POST['pass'];

        // Update the record in the current table
        $update_query = "UPDATE $del SET full_name = ?, username = ?, pass = ? WHERE admin_ID = ?";
        $stmt = mysqli_prepare($connection, $update_query);
        mysqli_stmt_bind_param($stmt, 'sssi', $full_name, $username, $password, $id);
        $success = mysqli_stmt_execute($stmt);

        if ($success) {
            $_SESSION['status'] = "Success!";
            $_SESSION['text'] = "Record Updated Successfully";
            $_SESSION['status_code'] = "success";
            echo '<script>window.history.go(-1);</script>';
            exit;
        } else {
            $_SESSION['status'] = "Error!";
            $_SESSION['text'] = "Record Not Updated";
            $_SESSION['status_code'] = "error";
            echo '<script>window.history.go(-1);</script>';
            exit;
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
        <title> Update Admin Records </title>

        <!-- CSS Link-->
        <link rel="stylesheet" href="../style/update-admin.css?v=<?php echo time(); ?>">
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

        <!-- JavaScript Link -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="sweet-alert.js"></script> 

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
                    <li><a class="menu__item view-map" href="../view-map.php"><i class='bx bx-map map'></i>View Map</a></li>
                    <li><a class="menu__item view-records" href="../view-records.php"><i class='bx bx-folder record'></i></i>View Records</a></li>
                    <li><a class="menu__item generate-reports" href="../generate-reports.php"><i class='bx bx-spreadsheet report'></i>Generate Reports</a></li>
                    <li><a class="menu__item manage-users" href="../manage-users.php"><i class='bx bx-user-circle users'></i>Manage Users</a></li>
                    <li><a class="menu__item log-out" href="../logout.php" id="logoutButton"><i class='bx bx-log-out'></i></i>Log Out</a></li>
                </ul>

                <footer class = "watermark"> <!-- Footer -->
                    <p>Powered by BurialBase © 2023</p>
                </footer>
            </div>

            <div class = "main-content"> <!-- Webpage Main Content Section -->

                <header class="cmis-header"> <!-- Webpage Header -->
                    <div class = "cmis-name"><p> Columbarium Mapping Information System </p></div>

                    <div class="user-profile">
                    <p>Hello, <?php echo !empty($sessionUsername) ? htmlspecialchars($sessionUsername) : 'Unknown User'; ?>!</p>
                        <img src="../images/admin-picture.png" alt="User Picture">
                    </div>
                </header>

                <div class = "webpage-title"> <!-- Webpage Title-->
                    <p> Manage Users </p>
                </div>

                <div class = "container"> <!-- Webpage Main Content Wrapper -->
                    <div class = "content-box"> <!-- Content Box Wrapper -->
                        <div class = "content"> <!-- Content Wrapper -->

                            <!-- Add Record Form -->
                            <form method="POST" autocomplete="off">
                                <div class="header-container">
                                    <div class="back-btn">
                                        <a href="" title="Back to <?php echo "$table";?>"><i class='bx bx-arrow-back'></i> </a>
                                    </div>
                                    <div class="update-title-container">
                                        <?php
                                            // Retrieve the table name from the URL parameter
                                            $table = $_GET['table'] ?? '';

                                            // Now you can use $table in your code
                                            echo "<h3 class='update-title'>Update $table</h3>";
                                        ?>
                                    </div>
                                </div>
                                
                                <div class="col1">
                                    <div class="field input-field">
                                        <label for="fullname">Full Name</label>
                                        <input type="text" placeholder="Full Name" name="full_name" class="input" id="full_name" required value = "<?php echo "$full_name";?>">
                                    </div>

                                    <div class="field input-field">
                                        <label for="username">Username</label>
                                        <input type="text" placeholder="Username" name="username" class="input" id="username" required value="<?php echo htmlspecialchars($updateIDUsername); ?>">

                                    </div>

                                    <div class="field input-field" style="position: relative;"> <!-- Added position: relative -->
                                        <label for="password">Password</label>
                                        <input type="password" placeholder="Password" name="pass" class="password" id="password" required value = "<?php echo "$password";?>">
                                        <i class="fa-solid fa-eye" id="show-password" style="position: absolute; top: 69%; right: 95px; transform: translateY(-50%); font-size: 18px; cursor: pointer; padding: 5px; color: #8b8b8b;"></i>
                                    </div>

                                    <div class="field button-field">
                                        <button type="submit" name="update-button" class="add-button">Update</button>
                                    </div>

                                    <div class="field button-field">
                                        <button type="button" name="reset-button" id="reset-button" class="cancel-button">Reset</button>
                                    </div> 
                                </div>


                            </form>

                        </div>
                    </div>
                </div>
    
            </div> <!-- End of main content -->
        </div> <!-- End of Webpage Default Layout -->

        <!-- JAVASCRIPT -->
            <script> // Show / Hide Password
                const showPassword = document.querySelector
                ("#show-password");

                const passwordField = document.querySelector
                ("#password");

                // Event Listeners
                showPassword.addEventListener("click", function() {
                    this.classList.toggle("fa-eye-slash");
                    const type = passwordField.getAttribute("type") === "password" ? "text" : "password";
                    passwordField.setAttribute("type", type);              
                })

            </script>

                <!-- Reset Button -->
                <script>
                    // Function to handle cancel button click
                    document.getElementById('reset-button').addEventListener('click', function() {
                        // Display a confirmation dialog using SweetAlert
                        Swal.fire({
                            title: 'Are you sure?',
                            text: 'This will reset ALL of the details of your record',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#0A633C',
                            cancelButtonColor: 'gray',
                            confirmButtonText: 'Yes, reset!',
                            cancelButtonText: 'No'
                        }).then((result) => {
                            // If confirmed, reset the input boxes
                            if (result.isConfirmed) {
                                const inputElements = document.querySelectorAll('input, select');

                                inputElements.forEach(function(element) {
                                    element.value = ''; // Clear the value of each input/select element
                                });
                            }
                        });
                    });
                </script>

            <!-- Back -->
            <script>
                // Store the initial values fetched from PHP
                const initialFullName = '<?php echo addslashes($full_name); ?>';
                const initialUsername = '<?php echo addslashes($updateIDUsername); ?>';
                const initialPassword = '<?php echo addslashes($password); ?>';

                // Function to check if any field has been changed
                function hasFormChanged() {
                    const currentFullName = document.getElementById("full_name").value;
                    const currentUsername = document.getElementById("username").value;
                    const currentPassword = document.getElementById("password").value;
            
                    // Compare the initial values with the current values
                    if (
                        currentFullName !== initialFullName ||
                        currentUsername !== initialUsername ||
                        currentPassword !== initialPassword
                    ) {
                        return true; // Form has changed
                    }
                    return false; // Form has not changed
                }

                // Event listener for back button click
                document.querySelector('.back-btn a').addEventListener('click', function(event) {
                    event.preventDefault(); // Prevent the default behavior of the anchor tag

                    if (hasFormChanged()) {
                        // Display a confirmation dialog using SweetAlert
                        Swal.fire({
                            title: 'Are you sure?',
                            text: 'Your changes will not be saved',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#0A633C',
                            cancelButtonColor: 'gray',
                            confirmButtonText: 'Yes, go back!',
                            cancelButtonText: 'No'
                        }).then((result) => {
                            // If confirmed, navigate back to the previous page
                            if (result.isConfirmed) {
                                window.history.back();
                            }
                        });
                    } else {
                        // If no changes, go back without confirmation
                        window.history.back();
                    }
                });
            </script>

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