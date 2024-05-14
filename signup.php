<!-- PHP -->
<?php
require 'connect/connect.php';

// Initialize variables for inputs
$full_name_input = isset($_GET['full_name']) ? htmlspecialchars($_GET['full_name']) : '';
$username_input = isset($_GET['username']) ? htmlspecialchars($_GET['username']) : '';

// Connect to Form
if (isset($_POST["signup-button"])) {
    $full_name = $_POST['full_name'];
    $username = $_POST['username'];
    $pass = $_POST['pass'];
    $confirm_pass = $_POST['confirm_pass'];
    $admin_pass = $_POST['admin_pass'];
    $admin_pin = '!HFPCMISADMIN032510!'; // Define the constant Admin PIN

    // Check if the provided Admin PIN matches the constant Admin PIN
    if ($admin_pass !== $admin_pin) {
        // Admin PIN incorrect error
        $_SESSION['status'] = "Error!";
        $_SESSION['text'] = "Incorrect Admin PIN";
        $_SESSION['status_code'] = "error";
        header("location: signup.php?full_name=" . urlencode($full_name) . "&username=" . urlencode($username));
        exit;
    }

    $duplicate = mysqli_query($connection, "SELECT * FROM admin_records WHERE username = '$username'");

    // Duplicate Username Check
    if (mysqli_num_rows($duplicate) > 0) {
        // Username Duplicate Warning
        $_SESSION['status'] = "Error!";
        $_SESSION['text'] = "Username Has Already Been Taken";
        $_SESSION['status_code'] = "error";
        header("location: signup.php?full_name=" . urlencode($full_name) . "&username=" . urlencode($username));
        exit;
    } else {
        if ($pass != $confirm_pass) {
            // Passwords don't match error
            $_SESSION['status'] = "Error!";
            $_SESSION['text'] = "Passwords do not match";
            $_SESSION['status_code'] = "error";
            header("location: signup.php?full_name=" . urlencode($full_name) . "&username=" . urlencode($username));
            exit;
        } else {
            // Passwords match, proceed with sign-up
            $query = "INSERT INTO admin_records (full_name, username, pass) VALUES ('$full_name', '$username', '$pass')";
            mysqli_query($connection, $query);

            // Alert Signed Up Successfully and redirect to index.php
            $_SESSION['status'] = "Success!";
            $_SESSION['text'] = "Signed Up Successfully";
            $_SESSION['status_code'] = "success";
            header("location: index.php");
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
        <title> HFP CMIS - Sign Up</title>

        <!-- CSS Link -->
        <link rel="stylesheet" href="style/signup.css?v=<?php echo time(); ?>">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

        <!-- JavaScript Link -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="sweet-alert.js"></script>        

         <!-- Icon -->
         <link rel="icon" href="icon-logo.png" type="image/png">
    </head>

    <body>
        <!-- Admin Sign-Up  -->
        <section class = "container forms"> <!-- Form Container -->
            <div class = "form signup">
                <div class = "form-content">

                    <header> <!-- Signup Header -->
                        <div class = "header">
                            <img src="images/parish-logo.jpg">
                            <h3> Holy Family Parish </h3>
                            <p> Columbarium Mapping Information System </p>
                        </div>
                    </header>

                    <div class = "desc-signup"> 
                        <p> Create an admin account </p>
                    </div>
                    
                    <!-- Signup Form -->
                    <form method="POST" autocomplete="off">
                        <div class = "field input-field">
                        <input type="text" placeholder="Full Name" class="input" name="full_name" required value="<?php echo $full_name_input; ?>">
                        </div>

                        <div class = "field input-field">
                        <input type="text" placeholder="Username" class="input" name="username" required value="<?php echo $username_input; ?>">
                        </div>

                        <div class = "field input-field">
                            <input type = "password" placeholder = "Password" name = "pass" class="password" id = "password" required value="">
                            <i class="fa-solid fa-eye" id="show-password"></i>
                        </div>

                        <div class = "field input-field">
                            <input type = "password" placeholder = "Confirm Password" name = "confirm_pass" class="password" id = "confirm_password" required value="">
                            <i class="fa-solid fa-eye" id="confirm_show-password"></i>
                        </div>

                        <div class = "field input-field">
                            <input type = "password" placeholder = "Admin PIN (Upon Request)" name = "admin_pass" class="password" id = "admin_password" required value="">
                            <i class="fa-solid fa-eye" id="admin_show-password"></i>
                        </div>

                        <div class = "field button-field">
                            <button type="submit" name="signup-button"> Sign Up </button>
                        </div>
                    </form>

                    <div class = "back-login">
                        <a href = "index.php" class = "signup-link"> Back to Log In </a> </span>
                    </div>

                </div>
            </div>
        </section>  

        <!-- JavaScript  -->
        <script> // Show / Hide Password
            const showPassword = document.querySelector
            ("#show-password");

            const confirmShowPassword = document.querySelector
            ("#confirm_show-password");

            const adminShowPassword = document.querySelector
            ("#admin_show-password");

            const passwordField = document.querySelector
            ("#password");

            const confirm_passwordField = document.querySelector
            ("#confirm_password");

            const admin_passwordField = document.querySelector
            ("#admin_password");

            // Event Listeners
            showPassword.addEventListener("click", function() {
                this.classList.toggle("fa-eye-slash");
                const type = passwordField.getAttribute("type") === "password" ? "text" : "password";
                passwordField.setAttribute("type", type);              
            })

            confirmShowPassword.addEventListener("click", function() {
                this.classList.toggle("fa-eye-slash");
                const type = confirm_passwordField.getAttribute("type") === "password" ? "text" : "password";
                confirm_passwordField.setAttribute("type", type);
            })

            adminShowPassword.addEventListener("click", function() {
                this.classList.toggle("fa-eye-slash");
                const type = admin_passwordField.getAttribute("type") === "password" ? "text" : "password";
                admin_passwordField.setAttribute("type", type);
            })
        </script>

        <!-- PHP -->
        <?php
            // Alert
            if (isset($_SESSION['status']) && $_SESSION['status'] !='') 
            {
                ?>
                    <script>
                        Swal.fire({
                            title: '<?php echo $_SESSION['status']; ?>',
                            text: '<?php echo $_SESSION['text']; ?>',
                            icon: '<?php echo $_SESSION['status_code']; ?>',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    </script>
                <?php
                    unset($_SESSION['status']);
            }
        ?> 
    </body>
</html>