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

    // If Add Button is Clicked
    if(isset($_POST["add-button"])) {   
        // Get niche row and column values from the form
        $nicheRow = $_POST['niche-row'];
        $nicheColumn = $_POST['niche-column'];

        // Concatenate
        $niche_ID = $nicheRow . $nicheColumn;

        $room = $_POST['room']; // Ensure that 'room' is properly fetched from the form

        // Check the count of records for the provided niche_ID
        $count_query = "SELECT COUNT(*) AS count FROM $room WHERE niche_ID = '$niche_ID'";
        $count_result = mysqli_query($connection, $count_query);
        $count_row = mysqli_fetch_assoc($count_result);
        $record_count = $count_row['count'];

        // Limit to 3 records for a niche_ID
        $max_records = 3;

        if ($record_count >= $max_records) {
            $_SESSION['status'] = "Error!";
            $_SESSION['text'] = "$niche_ID is already full";
            $_SESSION['status_code'] = "error";
        
            // Preserve form values in session variables
            $_SESSION['form_values'] = $_POST;
        
            header("location: add-deceased.php");
            die;
        } else {
            // Other form inputs
            $room = $_POST['room'];
            $full_name = $_POST['full_name'];
            $birth_date = $_POST['birth_date'];
            $death_date = $_POST['death_date'];
            $age = $_POST['age'];
            $contact_person = $_POST['contact_person'];
            $contact_number = $_POST['contact_number'];

            // MySQL Database Connection
            $insert_query = "INSERT INTO $room (niche_ID, full_name, birth_date, death_date, age, contact_person, contact_number, room, niche_row, niche_column) 
                            VALUES ('$niche_ID', '$full_name', '$birth_date', '$death_date', '$age', '$contact_person', '$contact_number', '$room', '$nicheRow', '$nicheColumn')";

            $insert_query_run = mysqli_query($connection, $insert_query);

            if($insert_query_run)
            {
                unset($_SESSION['form_values']);
                $_SESSION['status'] = "Success!";
                $_SESSION['text'] = "Record Added Successfully";
                $_SESSION['status_code'] = "success";
                header("location: add-deceased.php"); 
                die;
            }

            else 
            {
                $_SESSION['form_values'] = $_POST;
                $_SESSION['status'] = "Error!";
                $_SESSION['text'] = "Record Not Added";
                $_SESSION['status_code'] = "error";
                header("location: add-deceased.php"); 
                die;
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
        <title> Add Deceased Person </title>

        <!-- CSS Link-->
        <link rel="stylesheet" href="style/add-deceased.css?v=<?php echo time(); ?>">
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
                    <li><a class="menu__item add-deceased" href="#"><i class='bx bx-user-plus deceased'></i>Add Deceased Person</a></li>
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
                    <p> Add Deceased Person </p>
                </div>

                <div class = "container"> <!-- Webpage Main Content Wrapper -->
                    <div class = "content-box"> <!-- Content Box Wrapper -->
                        <div class = "content"> <!-- Content Wrapper -->

                            <!-- Add Record Form -->
                            <form action = "#" method="post" onsubmit="validateContactNumber()">

                                <!-- Add Record Form (Column 1) -->
                                <div class = "col1">
                                    <div class = "field input-field room">
                                        <label for="room">Room</label>
                                        <select name = "room" class="select-room" required>
                                            <option value = "room" disable selected hidden> Select Room </option>
                                            <option value="st_john" <?php if (isset($_SESSION['form_values']['room']) && $_SESSION['form_values']['room'] === 'st_john') echo 'selected'; ?>> 1A - St. John </option>
                                            <option value="st_james" <?php if (isset($_SESSION['form_values']['room']) && $_SESSION['form_values']['room'] === 'st_james') echo 'selected'; ?>> 1B - St. James </option>
                                            <option value="st_andrew" <?php if (isset($_SESSION['form_values']['room']) && $_SESSION['form_values']['room'] === 'st_andrew') echo 'selected'; ?>> 1C - St. Andrew </option>
                                            <option value="st_peter" <?php if (isset($_SESSION['form_values']['room']) && $_SESSION['form_values']['room'] === 'st_peter') echo 'selected'; ?>> 1D - St. Peter </option>
                                            <option value="st_philip" <?php if (isset($_SESSION['form_values']['room']) && $_SESSION['form_values']['room'] === 'st_philip') echo 'selected'; ?>> 2A - St. Philip </option>
                                            <option value="st_bartolomew" <?php if (isset($_SESSION['form_values']['room']) && $_SESSION['form_values']['room'] === 'st_bartolomew') echo 'selected'; ?>> 2B - St. Bartolomew </option>
                                            <option value="st_thomas" <?php if (isset($_SESSION['form_values']['room']) && $_SESSION['form_values']['room'] === 'st_thomas') echo 'selected'; ?>> 2C - St. Thomas </option>
                                            <option value="st_matthew" <?php if (isset($_SESSION['form_values']['room']) && $_SESSION['form_values']['room'] === 'st_matthew') echo 'selected'; ?>> 2D - St. Matthew </option>
                                            <option value="st_james_alphaeus" <?php if (isset($_SESSION['form_values']['room']) && $_SESSION['form_values']['room'] === 'st_james_alphaeus') echo 'selected'; ?>> 2E - St. James Son of Alphaeus </option>
                                            <option value="st_thaddaeus" <?php if (isset($_SESSION['form_values']['room']) && $_SESSION['form_values']['room'] === 'st_thaddaeus') echo 'selected'; ?>> 2F - St. Thaddaeus </option>
                                            <option value="st_simon" <?php if (isset($_SESSION['form_values']['room']) && $_SESSION['form_values']['room'] === 'st_simon') echo 'selected'; ?>> 2G - St. Simon </option>
                                        </select>
                                    </div>

                                    <div class = "field input-field niche_ID">
                                        <label for="nicheID">Niche ID</label>
                                        <!-- <input type = "Text" id = "niche_ID" name = "niche_ID" placeholder = "e.g. A9" class="input" required> -->
                                        <select name = "niche-row" class="select-row" required>
                                            <option value = "niche-row" disable selected hidden> Select Row </option>
                                            <option value = "A"> A </option>
                                            <option value = "B"> B </option>
                                            <option value = "C"> C</option>
                                            <option value = "D"> D</option>
                                            <option value = "E"> E </option>
                                            <option value = "F"> F </option>
                                            <option value = "G"> G </option>
                                        </select>

                                        <select name = "niche-column" class="select-column" required>
                                            <option value = "niche-column" disable selected hidden> Select Column </option>
                                        </select>
                                    </div>
                
                                    <div class = "field input-field">
                                        <label for="fullname">Full Name</label>
                                        <input type="text" id="full_name" name="full_name" placeholder="e.g. Juan Dela Cruz Sr." class="input" required value="<?php echo isset($_SESSION['form_values']['full_name']) ? htmlspecialchars($_SESSION['form_values']['full_name']) : ''; ?>">
                                    </div>
                
                                    <div class="field input-field date">
                                        <label for="birthdate">Date of Birth</label>
                                        <input type="date" id="birth_date" name="birth_date" class="input-date" required max="<?php echo date('Y-m-d'); ?>">
                                    </div>
                
                                    <div class = "field button-field">
                                        <button type="submit" name="add-button" class="add-button">Add Record</button>
                                    </div>
                                </div>
                                
                                <!-- Add Record Form (Column 2) -->
                                <div class = "col2">
                                <div class="field input-field date">
                                    <label for="deathdate">Date of Death</label>
                                    <input type="date" id="death_date" name="death_date" class="input-date" oninput="computeAge()" required max="<?php echo date('Y-m-d'); ?>">
                                        
                                </div>

                                    <div class = "field input-field">
                                        <label for="age">Age Before Death [Years]</label>
                                        <input type = "number" min = "0" id ="age" name ="age" class="input" readonly>
                                    </div>

                                    <div class = "field input-field">
                                        <label for="contactname">Contact Person</label>
                                        <input type="text" id="contact_person" name="contact_person" placeholder="e.g. Juan Dela Cruz Jr." class="input" required value="<?php echo isset($_SESSION['form_values']['contact_person']) ? htmlspecialchars($_SESSION['form_values']['contact_person']) : ''; ?>">
                                    </div>
                
                                    <div class = "field input-field">
                                        <label for="contactnum">Mobile No. of Contact Person</label>
                                        <input type="text" id="contact_number" name="contact_number" placeholder="639XXXXXXXXX" class="input" maxlength="12" required value="<?php echo isset($_SESSION['form_values']['contact_number']) ? $_SESSION['form_values']['contact_number'] : ''; ?>">
                                    </div>

                                    <div class = "field button-field">
                                        <button type="button" name="cancel-button" id="cancel-button" class="cancel-button">Reset</button>
                                    </div> 
                                </div> 
        
                            </form>

                        </div>
                    </div>
                </div>
    
            </div> <!-- End of main content -->
        </div> <!-- End of Webpage Default Layout -->

        <!-- JavaScript -->
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

            <!-- Cancel Button -->
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const cancelButton = document.getElementById('cancel-button');
                    cancelButton.addEventListener('click', function() {
                        // Select all input and select elements in the form
                        const inputElements = document.querySelectorAll('input, select');

                        // Loop through each input and select element and clear their values
                        inputElements.forEach(function(element) {
                            if (element.tagName === 'INPUT' || element.tagName === 'SELECT') {
                                element.value = '';
                            }
                        });
                    });
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
                    title: 'Error!',
                    text: 'Please enter a valid mobile number in the format 639XXXXXXXXX.',
                    icon: 'error',
                    confirmButtonColor: '#0A633C'
                });

                // Prevent form submission
                event.preventDefault();
            }
        }
        </script>

            <!-- Update Niche Columns based on Selected Room -->
            <script>
                
                // Get references to the room and niche column select elements
                const roomSelect = document.querySelector('.select-room');
                const columnSelectCol = document.querySelector('.select-column');
                const columnSelectRow = document.querySelector('.select-row');

                // Function to update niche column and row options based on the selected room
                function updateNicheColumns() {
                    const selectedRoom = roomSelect.value;

                    // Remove existing options except the first one ("Select Column")
                    while (columnSelectCol.options.length > 1) {
                        columnSelectCol.remove(1);
                    }

                    // Remove existing options except the first one ("Select Row")
                    while (columnSelectRow.options.length > 1) {
                        columnSelectRow.remove(1);
                    }

                    // Add default "Select Column" option
                    columnSelectCol.selectedIndex = 0;

                    // Add default "Select Row" option
                    columnSelectRow.selectedIndex = 0;

                    // Populate rows A to G for all rooms
                    const rowOptions = ['A', 'B', 'C', 'D', 'E', 'F', 'G'];
                    for (let i = 0; i < rowOptions.length; i++) {
                        const option = document.createElement('option');
                        option.value = rowOptions[i];
                        option.textContent = rowOptions[i];
                        columnSelectRow.appendChild(option);
                    }

                    if (selectedRoom === 'st_john') {
                        for (let i = 1; i <= 11; i++) {
                            const option = document.createElement('option');
                            option.value = i;
                            option.textContent = i;
                            columnSelectCol.appendChild(option);
                        }
                    } 
                    
                    else if (selectedRoom === 'st_philip') {
                        for (let i = 1; i <= 11; i++) {
                            const option = document.createElement('option');
                            option.value = i;
                            option.textContent = i;
                            columnSelectCol.appendChild(option);
                        }
                    } 

                    else if (selectedRoom === 'st_thomas') {
                        for (let i = 1; i <= 11; i++) {
                            const option = document.createElement('option');
                            option.value = i;
                            option.textContent = i;
                            columnSelectCol.appendChild(option);
                        }
                    } 

                    else if (selectedRoom === 'st_bartolomew') {
                        for (let i = 1; i <= 9; i++) {
                            const option = document.createElement('option');
                            option.value = i;
                            option.textContent = i;
                            columnSelectCol.appendChild(option);
                        }
                    } 

                    else if (selectedRoom === 'st_simon') {
                        for (let i = 1; i <= 10; i++) {
                            const option = document.createElement('option');
                            option.value = i;
                            option.textContent = i;
                            columnSelectCol.appendChild(option);
                        }
                    } 
                    
                    else {
                        // Add default options for other rooms
                        // Replace this section with other room column configurations as needed
                        for (let i = 1; i <= 14; i++) {
                            const option = document.createElement('option');
                            option.value = i;
                            option.textContent = i;
                            columnSelectCol.appendChild(option);
                        }
                    }
                }

                // Event listener for room selection change
                roomSelect.addEventListener('change', updateNicheColumns);

                // Initial call to populate columns based on the default selected room (if any)
                updateNicheColumns();
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
                    
                    <!-- Display Rows and Columns -->
                    <script>
                    // Set the selected row and column based on stored session values
                    const selectedRow = '<?php echo isset($_SESSION['form_values']['niche-row']) ? $_SESSION['form_values']['niche-row'] : ''; ?>';
                    const selectedColumn = '<?php echo isset($_SESSION['form_values']['niche-column']) ? $_SESSION['form_values']['niche-column'] : ''; ?>';

                    // Select the row
                    const rowSelect = document.querySelector('.select-row');
                    if (selectedRow) {
                        const rowOption = rowSelect.querySelector(`option[value="${selectedRow}"]`);
                        if (rowOption) {
                            rowOption.selected = true;
                        }
                    }

                    // Select the column
                    const columnSelect = document.querySelector('.select-column');
                    if (selectedColumn) {
                        const columnOption = columnSelect.querySelector(`option[value="${selectedColumn}"]`);
                        if (columnOption) {
                            columnOption.selected = true;
                        }
                    }
                </script>

        <script>
            function updateDeathDateConstraints() {
                const birthDateInput = document.getElementById('birth_date');
                const deathDateInput = document.getElementById('death_date');

                const today = new Date().toISOString().split('T')[0];

                // Set max date for birth_date input to the current date
                birthDateInput.max = today;

                // Set min date for death_date input as birth_date and max date to current date
                if (birthDateInput.value) {
                    deathDateInput.min = birthDateInput.value;
                    deathDateInput.max = today;
                } else {
                    deathDateInput.min = ''; // Reset the minimum if birth date is empty
                    deathDateInput.max = today;
                }
            }

            // Call the function initially to set the constraints
            updateDeathDateConstraints();
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