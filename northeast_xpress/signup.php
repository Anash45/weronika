<?php
require './includes/db_conn.php';

$info = '';
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Define variables and initialize with empty values
    $fname = $lname = $email = $phone = $password = "";

    // Process form data when form is submitted
    $fname = $conn->real_escape_string($_POST['fname']);
    $lname = $conn->real_escape_string($_POST['lname']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $password = $_POST['password'];

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Check if email already exists
    $email_check_query = "SELECT UserID FROM users WHERE Email = '$email'";
    $email_result = $conn->query($email_check_query);

    if ($email_result->num_rows > 0) {
        // Email already exists
        $info = "<p class='alert alert-danger'>Error: Email already exists.</p>";
    } else {
        // Insert data into database with hashed password
        $insert_query = "INSERT INTO users (FirstName, LastName, Email, Phone, Password) VALUES ('$fname', '$lname', '$email', '$phone', '$hashed_password')";
        if ($conn->query($insert_query) === TRUE) {
            // Success
            $info = "<p class='alert alert-success'>User registered successfully.</p>";


            $book_url = 'https://portfolio.f4futuretech.com/northeast/northeast_xpress/vehicles.php'; // Replace with the actual profile URL
            // Send welcome email to the user
            $templateFile = 'signup-template.html';
            $htmlContent = file_get_contents($templateFile);

            // Replace placeholder with OTP
            $htmlContent = str_replace('{book_url}', $book_url, $htmlContent);

            // Send email to the user
            $to = $email;
            $subject = 'Welcome to Our Website';
            $headers = 'From: Northeast Xpress Inc. <info@northeastxpressinc.com>' . "\r\n";
            $headers .= 'Reply-To: info@northeastxpressinc.com' . "\r\n" .
                'X-Mailer: PHP/' . phpversion() . "\r\n" .
                'MIME-Version: 1.0' . "\r\n" .
                'Content-type:text/html;charset=UTF-8';

            if (mail($to, $subject, $htmlContent, $headers)) {
                // $info .= "<div class='alert alert-success'>Success to send welcome email.</div>";
                // Email sent successfully
            } else {
                // Failed to send email
                $info .= "<div class='alert alert-danger'>Failed to send welcome email.</div>";
            }
            header('location:login.php');
        } else {
            // Error
            $info = "<p class='alert alert-danger'>Error: " . $conn->error . "</p>";
        }
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
        <?php include 'includes/navbar.php'; ?>
        <!-- SIGN UP FORM -->
        <div id="home" class="container-fluid signup-form">
            <div class="row">
                <div class="col-12 col-sm-10 col-lg-6 m-auto">
                    <h2>Create account</h2>
                    <!-- FORM STARTS -->
                    <?php echo $info; ?>
                    <form id="signupForm" class="form" method="POST" action="">
                        <div class="row">
                            <!-- fname -->
                            <div class="col-md-6">
                                <div class="input-control">
                                    <label for="fname">First Name</label>
                                    <input id="fname" name="fname" type="text">
                                    <div class="error"></div>
                                </div>
                            </div>
                            <!-- lname -->
                            <div class="col-md-6">
                                <div class="input-control">
                                    <label for="lname">Last Name</label>
                                    <input id="lname" name="lname" type="text">
                                    <div class="error"></div>
                                </div>
                            </div>
                        </div>
                        <!-- email -->
                        <div class="row">
                            <div class="col">
                                <div class="input-control">
                                    <label for="email">Email</label>
                                    <input id="email" name="email" type="text">
                                    <div class="error"></div>
                                </div>
                            </div>
                        </div>
                        <!-- phone -->
                        <div class="row">
                            <div class="col">
                                <div class="input-control">
                                    <label for="phone">Phone</label>
                                    <input id="phone" name="phone" type="tel">
                                    <div class="error"></div>
                                </div>
                            </div>
                        </div>
                        <!-- password -->
                        <div class="row">
                            <div class="col">
                                <div class="input-control">
                                    <label for="password">Password</label>
                                    <input id="password" name="password" type="password">
                                    <div class="error"></div>
                                </div>
                            </div>
                        </div>
                        <!-- conf password -->
                        <div class="row">
                            <div class="col">
                                <div class="input-control">
                                    <label for="password2">Confirm Password</label>
                                    <input id="password2" name="password2" type="password">
                                    <div class="error"></div>
                                </div>
                            </div>
                        </div>
                        <!-- checkbox -->
                        <div class="input-control">
                            <div class="row tos">
                                <div class="col-1">
                                    <label for="checkbox">
                                        <input id="checkbox" name="checkbox" type="checkbox" aria-checked="false">
                                        <span class="agree-hidden">I Agree</span>
                                    </label>
                                </div>
                                <div class="col-11">
                                    <p> By signing up, you agree to the <a href="termsofservice.php"> Terms & Conditions
                                        </a> of Northeast Xpress Inc. </p>
                                </div>
                            </div>
                            <div class="error"></div>
                        </div>
                        <!-- submit btn -->
                        <div class="row">
                            <div class="col">
                                <button type="submit">Sign up</button>
                            </div>
                        </div>
                    </form>
                    <!-- existing user -->
                    <div class="row">
                        <div class="col existing-user">
                            <p> Already have an account? <a href="login.php"> Log in here </a>
                            </p>
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