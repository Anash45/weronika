<?php
require './includes/db_conn.php';

$info = '';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Define variables and initialize with empty values
    $email = $password = "";

    // Process form data when form is submitted
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    // Retrieve user data from the database
    $query = "SELECT UserID, FirstName, Role, Password FROM users WHERE Email = '$email'";
    $result = $conn->query($query);

    if ($result->num_rows == 1) {
        // User found, verify password
        $row = $result->fetch_assoc();
        $userID = $row['UserID'];
        $firstName = $row['FirstName'];
        $role = $row['Role'];
        $hashed_password = $row['Password'];

        if (password_verify($password, $hashed_password)) {
            // Password is correct, store user information in session
            $_SESSION['UserID'] = $userID;
            $_SESSION['FirstName'] = $firstName;
            $_SESSION['Role'] = $role;

            // Redirect to homepage
            header("Location: index.php");
            exit();
        } else {
            // Incorrect password
            $info = "<p class='alert alert-danger'>Incorrect email or password.</p>";
        }
    } else {
        // User not found
        $info = "<p class='alert alert-danger'>Incorrect email.</p>";
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
                    <h2>Welcome back</h2>
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
                        <!-- password -->
                        <div class="row">
                            <div class="col">
                                <div class="input-control">
                                    <label for="password3">Password</label>
                                    <input id="password3" name="password" type="password">
                                    <div class="error"></div>
                                </div>
                            </div>
                        </div>
                        <!-- login button -->
                        <div class="row">
                            <div class="col">
                                <button id="login-btn" type="submit">Log in</button>
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
                                    <a href="reset-form.php"> Forgot Password? </a>
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