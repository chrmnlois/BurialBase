<!-- PHP -->
<?php
    if (!empty($_SESSION["session_id"])) {
        header("location: dashboard.php");
        exit;
    }
    require 'connect/connect.php';
    
    if (isset($_POST["login-button"])) {
        $username = $_POST['username'];
        $pass = $_POST['pass'];
        $result = mysqli_query($connection, "SELECT * FROM admin_records WHERE username = '$username'");
        $row = mysqli_fetch_assoc($result);
    
        if (mysqli_num_rows($result) > 0) {
            if ($pass == $row["pass"]) {
                $_SESSION["login"] = true;
                $_SESSION["session_id"] = $row["admin_ID"];
    
                // Update last login time
                $admin_id = $row["admin_ID"];
                $update_query = "UPDATE admin_records SET last_login = NOW() WHERE admin_ID = '$admin_id'";
                mysqli_query($connection, $update_query);
    
                echo '
                <!DOCTYPE html>
                <html lang="en">
                <head>
                    <title>Loading...</title>
                    <style>
                        #loadingOverlay {
                            position: fixed;
                            top: 0;
                            left: 0;
                            width: 100%;
                            height: 100%;
                            background-image: linear-gradient(#13934a, #0A633C);
                            z-index: 9999;
                            display: flex;
                            justify-content: center;
                            align-items: center;
                            color: #fff;
                            font-size: 24px;
                        }

                        /* Apply shining animation to the image */
                        #loadingOverlay img {
                            animation: shine 2s infinite linear; /* Adjust duration or animation type as needed */
                        }

                        @keyframes shine {
                            0% {
                                filter: brightness(100%);
                            }
                            50% {
                                filter: brightness(150%);
                            }
                            100% {
                                filter: brightness(100%);
                            }
                        }
                    </style>
                </head>
                <body>
                    <div id="loadingOverlay"><img src="images/parish-logo-load.png"></div>
                    <script>
                        setTimeout(function() {
                            window.location.href = "dashboard.php";
                        }, 2300);
                    </script>
                </body>
                </html>
            ';
            exit;
                            
            } else {
                $_SESSION['status'] = "Error!";
                $_SESSION['text'] = "Wrong Password";
                $_SESSION['status_code'] = "error";
                header("location: index.php?username=" . urlencode($username));
                exit;
            }
        } else {
            $_SESSION['status'] = "Error!";
            $_SESSION['text'] = "User Not Registered";
            $_SESSION['status_code'] = "error";
            header("location: index.php?username=" . urlencode($username));
            exit;
        }
    }
    ?>

<!-- HTML -->
<!DOCTYPE html>
<html lang = "en">

    <head>
        <!-- Compatibility -->
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- Webpage Title -->
        <title> HFP CMIS - Log In </title>

        <!-- CSS Link-->
        <link rel="stylesheet" href="style/index.css?v=<?php echo time(); ?>">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

        <!-- JavaScript Link -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="sweet-alert.js"></script>

         <!-- Icon -->
         <link rel="icon" href="icon-logo.png" type="image/png">
    </head>

    <body>
        <!-- Admin Log-In  -->
        <section class = "container forms"> <!-- Form Container -->
            <div class = "form login"> 
                <div class = "form-content">

                    <header> <!-- Login Header -->
                        <div class = "header">
                            <img src="images/parish-logo.jpg">
                            <h3> Holy Family Parish </h3>
                            <p> Columbarium Mapping Information System </p>
                        </div>
                    </header>

                    <div class = "desc-login"> 
                        <p> Log-in to start your session </p>
                    </div>
                    
                    <!-- Login Form -->
                    <form method="POST" autocomplete="off">
                        <div class = "field input-field">
                        <input type="text" placeholder="Username" class="input" name="username" required value="<?php echo isset($_GET['username']) ? htmlspecialchars($_GET['username']) : ''; ?>">
                        </div>

                        <div class = "field input-field">
                            <input type="password" placeholder="Password" id="password" class="password" name="pass" required value="">
                           <!-- <i class='bx bx-hide eye-icon'></i> -->
                            <i class="fa-solid fa-eye" id="show-password"></i>
                            
                        </div>
                        
                        <div class = "field button-field">
                            <button type = "submit" name = "login-button" value="Login"> Log In </button>
                        </div>
                    </form>

                    <div class = "form-link">
                        <span> Not yet a member? <a href = "signup.php" class = "signup-link"> Sign-Up </a> </span>
                    </div>

                </div>
            </div>
        </section>  

        <!-- JavaScript  -->
        <script> // Show / Hide Password
            const showPassword = document.querySelector
            ("#show-password");

            const passwordField = document.querySelector
            ("#password");

            showPassword.addEventListener("click", function() {
                this.classList.toggle("fa-eye-slash");
                const type = passwordField.getAttribute("type") === "password" ? "text" : "password";
                passwordField.setAttribute("type", type);
            })
        </script>

        <script> // Redirecting you to Login
            window.onload = function() {
                <?php
                if (isset($_SESSION['status']) && $_SESSION['status'] === "Success!") {
                    ?>
                    Swal.fire({
                        title: '<?php echo $_SESSION['status']; ?>',
                        text: '<?php echo $_SESSION['text']; ?>',
                        icon: '<?php echo $_SESSION['status_code']; ?>',
                        position: 'center',
                        showConfirmButton: false,
                        timer: 2000 // 2 seconds
                    });
                    <?php
                    unset($_SESSION['status']);
                    unset($_SESSION['text']);
                    unset($_SESSION['status_code']);
                }
                ?>
            }
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
                            // button: "OK",
                            // confirmButtonColor: '#0A633C',
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