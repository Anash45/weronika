<?php
require_once './includes/db_conn.php';

$info = '';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Define variables and initialize with empty values
    $code = $password = "";

    // Process form data when form is submitted
    $code = $conn->real_escape_string($_POST['code']);
    $password = $conn->real_escape_string($_POST['password']);

    // Retrieve email from session
    if (isset($_SESSION['reset_email'])) {
        $email = $_SESSION['reset_email'];

        // Verify the code
        $query = "SELECT otp FROM users WHERE Email = '$email'";
        $result = $conn->query($query);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $stored_code = $row['otp'];

            if ($code == $stored_code) {
                // Code matches, update the password
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $update_query = "UPDATE users SET Password = '$hashed_password', otp = NULL WHERE Email = '$email'";
                if ($conn->query($update_query) === TRUE) {
                    // Password updated successfully
                    $info = "<p class='alert alert-success'>Password reset successfully.</p>";
                    header('refresh:2,url=login.php');
                    // Unset session variables
                    unset($_SESSION['reset_email']);
                } else {
                    // Error updating password
                    $info = "<p class='alert alert-danger'>Error updating password. Please try again later.</p>";
                }
            } else {
                // Incorrect code
                $info = "<p class='alert alert-danger'>Incorrect code. Please try again.</p>";
            }
        } else {
            // User not found
            $info = "<p class='alert alert-danger'>User not found.</p>";
        }
    } else {
        // Session variable not set
        $info = "<p class='alert alert-danger'>Session variable not set. Please try again.</p>";
        header('refresh:2,url=reset-form.php');
    }
}

// Close connection
$conn->close();
?>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Northeast Xpress Inc</title>
        <!-- Fonts -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
            integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
            crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Work+Sans:ital,wght@0,100..900;1,100..900&display=swap"
            rel="stylesheet">
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
            integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="assets/css/style.css">
        <!-- Deferred script -->
        <script defer src="assets/js/script.js"></script>
    </head>

    <body>
        <!-- Skip to content link -->
        <a href="#home" class="skip-to-content"> Skip to main content </a>
        <!-- NAVIGATION -->
        <?php include './includes/navbar.php'; ?>
        <!-- LOG IN FORM -->
        <div id="home" class="container-fluid login-form">
            <div class="row">
                <div class="col-12 col-sm-10 col-lg-5 m-auto">
                    <h2>Reset your password</h2>
                    <?php echo $info; ?>
                    <!-- FORM STARTS -->
                    <form id="loginForm" class="form" method="POST"
                        action="">
                        <div class="row">
                            <!-- email -->
                            <div class="col">
                                <div class="input-control">
                                    <label for="code">6 digit code</label>
                                    <input id="code" name="code" type="number">
                                    <div class="error"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="input-control">
                                    <label for="password3">New Password</label>
                                    <input id="password3" name="password" type="password">
                                    <div class="error"></div>
                                </div>
                            </div>
                        </div>
                        <!-- login button -->
                        <div class="row">
                            <div class="col">
                                <button id="login-btn" type="submit">Reset Password</button>
                            </div>
                        </div>
                    </form>
                    <!-- new user -->
                    <div class="row user-help">
                        <div class="col text-left">
                            <div class="new-user">
                                <p> New user? <a href="signup.php"> Register here </a>
                                </p>
                            </div>
                        </div>
                        <div class="col text-right">
                            <div class="forgot-password">
                                <p>
                                    <a href="login.php"> Login </a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
            integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
            crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"
            integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
            crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"
            integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
            crossorigin="anonymous"></script>
    </body>

</html>