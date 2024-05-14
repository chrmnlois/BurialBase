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
$nid = $_GET['nid']?? '';

// Display data that will be updated to input boxes
$sql = "SELECT * FROM $del WHERE id = ?";
$stmt = mysqli_prepare($connection, $sql);
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    
    // Initialize variables to avoid accessing null indexes
    $room = $row['room'] ?? '';
    $nicheRow = $row['niche_row'] ?? '';
    $nicheColumn = $row['niche_column'] ?? '';
    $full_name = $row['full_name'] ?? '';
    $birth_date = $row['birth_date'] ?? '';
    $death_date = $row['death_date'] ?? '';
    $contact_person = $row['contact_person'] ?? '';
    $contact_number = $row['contact_number'] ?? '';
} else {
    // Handle case where no rows are fetched or an error occurs
    // For instance, set default values or display an error message
    $room = '';
    $nicheRow = '';
    $nicheColumn = '';
    $full_name = '';
    $birth_date = '';
    $death_date = '';
    $contact_person = '';
    $contact_number = '';
    // Optionally, display an error message or perform appropriate action
}

// If Update Button is Clicked
if (isset($_POST["update-button"])) {
    // Get niche row and column values from the form
    $nicheRow = $_POST['niche-row'];
    $nicheColumn = $_POST['niche-column'];
    $selectedRoom = $_POST['room']; // Added to capture the updated room selection

    // PHP Connection to Form
    $niche_ID = $nicheRow . $nicheColumn;
    $full_name = $_POST['full_name'];
    $birth_date = $_POST['birth_date'];
    $death_date = $_POST['death_date'];
    $age = $_POST['age'];
    $contact_person = $_POST['contact_person'];
    $contact_number = $_POST['contact_number'];

    // Check if the room selection has changed
    if ($selectedRoom !== $room) {
        // Update the room column in the current table with the new selected room value
        $updateRoomQuery = "UPDATE $del SET room = ? WHERE id = ?";
        $stmt_updateRoom = mysqli_prepare($connection, $updateRoomQuery);
        mysqli_stmt_bind_param($stmt_updateRoom, 'si', $selectedRoom, $id);
        $updateRoomSuccess = mysqli_stmt_execute($stmt_updateRoom);

        if ($updateRoomSuccess) {
            // Move the record to another table
            $move_query = "INSERT INTO $selectedRoom (niche_ID, full_name, birth_date, death_date, age, contact_person, contact_number, room, niche_row, niche_column) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt_move = mysqli_prepare($connection, $move_query);
            mysqli_stmt_bind_param($stmt_move, 'sssssssssi', $niche_ID, $full_name, $birth_date, $death_date, $age, $contact_person, $contact_number, $selectedRoom, $nicheRow, $nicheColumn);
            $move_success = mysqli_stmt_execute($stmt_move);

            if ($move_success) {
                // Delete the record from the current table
                $delete_query = "DELETE FROM $del WHERE id = ?";
                $stmt_delete = mysqli_prepare($connection, $delete_query);
                mysqli_stmt_bind_param($stmt_delete, 'i', $id);
                $delete_success = mysqli_stmt_execute($stmt_delete);

                if ($delete_success) {
                    
                    // Record successfully moved and deleted from the current table
                    $_SESSION['status'] = "Success!";
                    $_SESSION['text'] = "Record updated and moved to $selectedRoom";
                    $_SESSION['status_code'] = "success";
                    echo '<script>window.history.go(-2);</script>';
                    exit;
                }
            } else {
                $_SESSION['status'] = "Error!";
                $_SESSION['text'] = "Record could not be moved";
                $_SESSION['status_code'] = "error";
                echo '<script>window.history.go(-1);</script>';
                exit;
            }
        } else {
            $_SESSION['status'] = "Error!";
            $_SESSION['text'] = "Room update failed";
            $_SESSION['status_code'] = "error";
            echo '<script>window.history.go(-1);</script>';
            exit;
        }
    } 
    
    else {
        // Update the record in the current table
        $update_query = "UPDATE $del SET niche_ID = ?, full_name = ?, birth_date = ?, death_date = ?, age = ?, contact_person = ?, contact_number = ?, niche_row = ?, niche_column = ? WHERE id = ?";
        $stmt = mysqli_prepare($connection, $update_query);
        mysqli_stmt_bind_param($stmt, 'sssssssssi', $niche_ID, $full_name, $birth_date, $death_date, $age, $contact_person, $contact_number, $nicheRow, $nicheColumn, $id);
        $success = mysqli_stmt_execute($stmt);

        if ($success) {
            $_SESSION['status'] = "Success!";
            $_SESSION['text'] = "Record Updated Successfully";
            $_SESSION['status_code'] = "success";
            echo '<script>window.history.go(-2);</script>';
            exit;
        } else {
            $_SESSION['status'] = "Error!";
            $_SESSION['text'] = "Record Not Updated";
            $_SESSION['status_code'] = "error";
            echo '<script>window.history.go(-1);</script>';
            exit;
        }
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
        <title> Update Niche Records </title>

        <!-- CSS Link-->
        <link rel="stylesheet" href="../style/update.css?v=<?php echo time(); ?>">
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

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
                    <p> View Records </p>
                </div>

                <div class = "container"> <!-- Webpage Main Content Wrapper -->
                    <div class = "content-box"> <!-- Content Box Wrapper -->
                        <div class = "content"> <!-- Content Wrapper -->

                            <!-- Add Record Form -->
                            <form action = "#" method="post" onsubmit="validateContactNumber()">
                                <div class="header-container">
                                    <div class="back-btn">
                                        <a href="" title="Back to <?php echo "$table";?> Records"><i class='bx bx-arrow-back'></i> </a>
                                    </div>
                                    <div class="update-title-container">
                                        <?php
                                            $nid = $_GET['nid']?? '';
                                            echo "<h3 class='update-title'>Update the Records of $nid</h3>";
                                        ?>
                                    </div>
                                </div>

                                <!-- Add Record Form (Column 1) -->
                                <div class = "col1">
                                    <div class = "field input-field room">
                                        <label for="room">Room</label>
                                        <select name = "room" class="select-room" required>
                                            <option value = "room" disable selected hidden> Select Room </option>
                                            <option value = "st_john" <?php if ($room === 'st_john') echo 'selected'; ?>> 1A - St. John </option>
                                            <option value = "st_james"<?php if ($room === 'st_james') echo 'selected'; ?>> 1B - St. James </option>
                                            <option value = "st_andrew"<?php if ($room === 'st_andrew') echo 'selected'; ?>> 1C - St. Andrew </option>
                                            <option value = "st_peter"<?php if ($room === 'st_peter') echo 'selected'; ?>> 1D - St. Peter </option>
                                            <option value = "st_philip"<?php if ($room === 'st_philip') echo 'selected'; ?>> 2A - St. Philip </option>
                                            <option value = "st_bartolomew"<?php if ($room === 'st_bartolomew') echo 'selected'; ?>> 2B - St. Bartolomew </option>
                                            <option value = "st_thomas"<?php if ($room === 'st_thomas') echo 'selected'; ?>> 2C - St. Thomas </option>
                                            <option value = "st_matthew"<?php if ($room === 'st_matthew') echo 'selected'; ?>> 2D - St. Matthew </option>
                                            <option value = "st_james_alphaeus"<?php if ($room === 'st_james_alphaeus') echo 'selected'; ?>> 2E - St. James Son of Alphaeus </option>
                                            <option value = "st_thaddaeus"<?php if ($room === 'st_thaddaeus') echo 'selected'; ?>> 2F - St. Thaddaeus </option>
                                            <option value = "st_simon"<?php if ($room === 'st_simon') echo 'selected'; ?>> 2G - St. Simon </option>
                                        </select>
                                    </div>

                                    <div class = "field input-field niche_ID">
                                        <label for="nicheID">Niche ID</label>
                                        <!-- <input type = "Text" id = "niche_ID" name = "niche_ID" placeholder = "e.g. A9" class="input" required> -->
                                        <select name="niche-row" class="select-row" required>
                                        <?php
                                            $rowOptions = ['A', 'B', 'C', 'D', 'E', 'F', 'G'];
                                            foreach ($rowOptions as $rowOption) {
                                                echo "<option value='$rowOption'>$rowOption</option>";
                                            }
                                            ?>
                                        </select>


                                        <select name = "niche-column" class="select-column" required>
                                            <option value="" disabled hidden>Select Column</option>
                                        </select>
                                    </div>
                
                                    <div class = "field input-field">
                                        <label for="fullname">Full Name</label>
                                        <input type = "Text" id = "full_name" name = "full_name" placeholder = "e.g. Juan Dela Cruz Sr." class="input" value = "<?php echo "$full_name";?>" required>
                                    </div>
                
                                    <div class="field input-field date">
                                        <label for="birthdate">Date of Birth [dd/mm/yyyy]</label>
                                        <input type="date" id="birth_date" name="birth_date" class="input-date" oninput="computeAge()" 
                                            value="<?php echo $birth_date; ?>" max="<?php echo date('Y-m-d'); ?>" required>
                                    </div>

                                    <div class = "field button-field">
                                        <button type="submit" name="update-button" class="add-button">Update</button>
                                    </div>
                                </div>
                                
                                <!-- Add Record Form (Column 2) -->
                                <div class = "col2">
                                    <div class="field input-field date">
                                        <label for="deathdate">Date of Death [dd/mm/yyyy]</label>
                                        <input type="date" id="death_date" name="death_date" class="input-date" oninput="computeAge()" 
                                            value="<?php echo $death_date; ?>" max="<?php echo date('Y-m-d'); ?>" required>
                                    </div>

                                    <div class = "field input-field">
                                        <label for="age">Age Before Death [Years]</label>
                                        <input type = "number" min = "0" id ="age" name ="age" class="input" readonly>
                                    </div>

                                    <div class = "field input-field">
                                        <label for="contactname">Contact Person</label>
                                        <input type = "Text" id="contact_person" name="contact_person" placeholder = "e.g. Juan Dela Cruz Jr." class="input" value = "<?php echo "$contact_person";?>" required>
                                    </div>
                
                                    <div class = "field input-field">
                                        <label for="contactnum">Mobile No. of Contact Person</label>
                                        <input type = "Text" id="contact_number" name="contact_number" maxlength="12" placeholder = "639XXXXXXXXX" class="input" value = "<?php echo "$contact_number";?>" required>
                                    </div>

                                    <div class = "field button-field">
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
            <!-- Compute Age -->
            <script> 
                document.addEventListener('DOMContentLoaded', function() {
                // Function to compute age based on birth_date and death_date values
                function computeAge() {
                    var birthDateInput = document.getElementById("birth_date");
                    var deathDateInput = document.getElementById("death_date");
                    var ageInput = document.getElementById("age");

                    // Function to calculate age
                    function calculateAge(birthDate, deathDate) {
                        if (birthDate && deathDate) {
                            var age = deathDate.getFullYear() - birthDate.getFullYear();

                            if (
                                deathDate.getMonth() < birthDate.getMonth() ||
                                (deathDate.getMonth() === birthDate.getMonth() && deathDate.getDate() < birthDate.getDate())
                            ) {
                                age--;
                            }

                            // Return 0 if age is negative
                            return age >= 0 ? age : 0;
                        }
                        return "";
                    }

                    // Retrieve birth_date and death_date values
                    var birthDate = new Date(birthDateInput.value);
                    var deathDate = new Date(deathDateInput.value);

                    // Calculate and display the age
                    ageInput.value = calculateAge(birthDate, deathDate);
                }

                // Call the computeAge function when the page loads
                computeAge();

                // Add event listeners to birth_date and death_date inputs to trigger the computation on input change
                document.getElementById("birth_date").addEventListener("input", computeAge);
                document.getElementById("death_date").addEventListener("input", computeAge);
            });
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
                const initialBirthDate = '<?php echo $birth_date; ?>';
                const initialDeathDate = '<?php echo $death_date; ?>';
                const initialContactPerson = '<?php echo addslashes($contact_person); ?>';
                const initialContactNumber = '<?php echo $contact_number; ?>';
                const initialRoom = '<?php echo $room; ?>';
                const initialNicheRow = '<?php echo $nicheRow; ?>';
                const initialNicheColumn = '<?php echo $nicheColumn; ?>';
                // ... (add similar initializations for other fields you want to track)

                // Function to check if any field has been changed
                function hasFormChanged() {
                    const currentFullName = document.getElementById("full_name").value;
                    const currentBirthDate = document.getElementById("birth_date").value;
                    const currentDeathDate = document.getElementById("death_date").value;
                    const currentContactPerson = document.getElementById("contact_person").value;
                    const currentContactNumber = document.getElementById("contact_number").value;
                    const currentRoom = document.querySelector('.select-room').value;
                    const currentNicheRow = document.querySelector('.select-row').value;
                    const currentNicheColumn = document.querySelector('.select-column').value;
                    // ... (add similar current value retrievals for other fields)

                    // Compare the initial values with the current values
                    if (
                        currentFullName !== initialFullName ||
                        currentBirthDate !== initialBirthDate ||
                        currentDeathDate !== initialDeathDate ||
                        currentContactPerson !== initialContactPerson ||
                        currentContactNumber !== initialContactNumber ||
                        currentRoom !== initialRoom ||
                        currentNicheRow !== initialNicheRow ||
                        currentNicheColumn !== initialNicheColumn
                        // ... (add similar comparisons for other fields)
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

            <!-- Validate Contact Number -->
            <script>
            function validateContactNumber() {
            const contactNumberInput = document.getElementById('contact_number');
            const contactNumber = contactNumberInput.value.trim();

            // Regular expression to match the contact number format
            const numberPattern = /^639\d{9}$/;

                if (!numberPattern.test(contactNumber)) {
                    // Show SweetAlert error if the number is invalid
                    Swal.fire({
                        title: 'Error',
                        text: 'Please enter a valid mobile number in the format 639XXXXXXXXX.',
                        icon: 'error',
                        confirmButtonColor: '#0A633C'
                    });

                    // Prevent form submission
                    event.preventDefault();
                }
            }
            </script>

            <!-- Update Niche Rows and Columns based on Selected Room -->
            <script>
                const roomSelect = document.querySelector('.select-room');
                const rowSelect = document.querySelector('.select-row');
                const columnSelect = document.querySelector('.select-column');

                // Function to update niche row and column options based on the selected room
                function updateNicheOptions() {
                    const selectedRoom = roomSelect.value;

                    // Clear existing options
                    rowSelect.innerHTML = '';
                    columnSelect.innerHTML = '';

                    // Add niche rows from A to G
                    ['A', 'B', 'C', 'D', 'E', 'F', 'G'].forEach(rowOption => {
                        const row = document.createElement('option');
                        row.value = rowOption;
                        row.textContent = rowOption;
                        rowSelect.appendChild(row);
                    });

                    // Define column counts for each room
                    const roomColumnsCount = {
                        'st_john': 11,
                        'st_philip': 11, 
                        'st_thomas': 11, 
                        'st_bartolomew': 9,
                        'st_simon': 10 
                    };

                    // Add niche columns based on the selected room
                    const columnsCount = roomColumnsCount[selectedRoom] || 14; // Default to 14 if room count not specified
                    for (let i = 1; i <= columnsCount; i++) {
                        const column = document.createElement('option');
                        column.value = i;
                        column.textContent = i;
                        columnSelect.appendChild(column);
                    }

                    // Set the value of niche-column to $nicheColumn if it exists
                    if (columnSelect) {
                        const existingOption = columnSelect.querySelector(`option[value="${<?php echo $nicheColumn; ?>}"]`);
                        if (existingOption) {
                            existingOption.setAttribute('selected', 'selected');
                        }
                    }
                }

                // Event listener for room selection change
                roomSelect.addEventListener('change', updateNicheOptions);

                // Initial call to populate rows and columns based on the default selected room (if any)
                updateNicheOptions();
            </script>


             <!-- Display Row When Update -->
            <script>
                // Function to set the fetched niche row as selected
                function setSelectedRow() {
                    const fetchedNicheRow = '<?php echo $nicheRow; ?>';
                    const nicheRowSelect = document.querySelector('.select-row');

                    for (let i = 0; i < nicheRowSelect.options.length; i++) {
                        if (nicheRowSelect.options[i].value === fetchedNicheRow) {
                            nicheRowSelect.selectedIndex = i;
                            break;
                        }
                    }

                    // If 'A' is missing, add it to the niche row select
                    if (!Array.from(nicheRowSelect.options).some(option => option.value === 'A')) {
                        const optionA = document.createElement('option');
                        optionA.value = 'A';
                        optionA.textContent = 'A';
                        nicheRowSelect.insertBefore(optionA, nicheRowSelect.firstChild);
                    }
                }

                // Call the function when the page loads
                setSelectedRow();
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