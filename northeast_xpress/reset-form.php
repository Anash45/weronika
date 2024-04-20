<?php
require_once './includes/db_conn.php';

$info = '';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Define variables and initialize with empty values
    $email = "";

    // Process form data when form is submitted
    $email = $conn->real_escape_string($_POST['email']);

    // Check if email exists
    $email_check_query = "SELECT UserID FROM Users WHERE Email = '$email'";
    $email_result = $conn->query($email_check_query);

    if ($email_result->num_rows > 0) {
        // Email exists, generate OTP
        $otp = mt_rand(100000, 999999); // Generate 6-digit OTP

        // Update OTP in the database
        $update_query = "UPDATE Users SET otp = '$otp' WHERE Email = '$email'";
        if ($conn->query($update_query) === TRUE) {
            // Send OTP to the email address
            $to = $email;
            $subject = 'Reset Password OTP';
            $message = 'Your OTP for resetting the password is: ' . $otp;
            $headers = 'From: webmaster@f4futuretech.com' . "\r\n" .
                       'Reply-To: info@f4futuretech.com' . "\r\n" .
                       'X-Mailer: PHP/' . phpversion();

            // if (mail($to, $subject, $message, $headers)) {
                
            if (true) {
                // Email sent successfully
                $_SESSION['reset_email'] = $email;
                header("Location: reset-password.php");
                exit();
            } else {
                // Failed to send email
                $info = "<p class='alert alert-danger'>Failed to send OTP. Please try again later.</p>";
            }
        } else {
            // Error updating OTP in the database
            $info = "<p class='alert alert-danger'>Error updating OTP. Please try again later.</p>";
        }
    } else {
        // Email does not exist
        $info = "<p class='alert alert-danger'>Email does not exist.</p>";
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
                    <form id="loginForm" class="form" method="POST" action="">
                        <div class="row">
                            <!-- email -->
                            <div class="col">
                                <div class="input-control">
                                    <label for="email">Email</label>
                                    <input id="email" name="email" type="email">
                                    <div class="error"></div>
                                </div>
                            </div>
                        </div>
                        <!-- login button -->
                        <div class="row">
                            <div class="col">
                                <button id="login-btn" type="submit">Send OTP</button>
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