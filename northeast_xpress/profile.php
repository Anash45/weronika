<?php
require_once './includes/db_conn.php';

$info = '';

// Check if user is logged in
if (!isLoggedIn()) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}

// Retrieve UserID from session
$userID = $_SESSION['UserID'];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Define variables and initialize with empty values
    $firstName = $lastName = $email = $phone = $password = "";

    // Process form data when form is submitted
    $userID = $_SESSION['UserID'];
    $firstName = $conn->real_escape_string($_POST['firstName']);
    $lastName = $conn->real_escape_string($_POST['lastName']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);

    $attach = '';
    if (isset($_POST['password']) && !empty($_POST['password'])) {
        $password = $_POST['password'];
        $password = password_hash($password, PASSWORD_DEFAULT);
        $attach = ", Password = '$password'";
    }

    // Check if new email is not used by another user
    $email_check_query = "SELECT UserID FROM users WHERE Email = '$email' AND UserID != $userID";
    $email_result = $conn->query($email_check_query);

    if ($email_result->num_rows > 0) {
        // Email already exists for another user
        $info = "<p class='alert alert-danger'>Error: Email already exists for another user.</p>";
    } else {

        // Update profile information in the database
        $update_query = "UPDATE users SET FirstName = '$firstName', LastName = '$lastName', Email = '$email', Phone = '$phone' ".$attach." WHERE UserID = $userID";
        if ($conn->query($update_query) === TRUE) {
            // Profile information updated successfully
            $info = "<p class='alert alert-success'>Profile information updated successfully.</p>";
        } else {
            // Error updating profile information
            $info = "<p class='alert alert-danger'>Error updating profile information: " . $conn->error . "</p>";
        }
    }
}

// Retrieve user information from the database based on UserID
$query = "SELECT FirstName, LastName, Email, Phone FROM users WHERE UserID = $userID";
$result = $conn->query($query);

// Check if query was successful
if ($result) {
    // Fetch user information
    $row = $result->fetch_assoc();
    $firstName = $row['FirstName'];
    $lastName = $row['LastName'];
    $email = $row['Email'];
    $phone = $row['Phone'];
} else {
    // Error fetching user information
    $info = "<p class='alert alert-danger'>Error fetching user information.</p>";
}

// Close result set
$result->close();

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
        <!-- main -->
        <div class="container-fluid profile-page">
            <div class="row">
                <div class="col-12 col-md-10 col-lg-6 m-auto profile">
                    <h2 id="fullName"><?php echo $firstName . ' ' . $lastName; ?></h2>
                    <!-- Profile photo upload section (to be implemented) -->
                    <!-- Display profile information in a table -->
                    <div class="profile-box" id="profileInfo">
                        <hr id="horizontal">
                        <h5 class="heading"> Account Information <!-- Edit button to switch to edit mode -->
                            <button type="button" onclick="editAccount();" class="edit-button">
                                <img src="./assets/img/edit-b.png" alt="Edit Icon">
                            </button>
                        </h5>
                        <?php echo $info; ?>
                        <!-- Table displaying account information -->
                        <table class="tprofile">
                            <tr>
                                <td>First Name:</td>
                                <td id="displayFirstName"><?php echo $firstName; ?></td>
                            </tr>
                            <tr>
                                <td>Last Name:</td>
                                <td id="displayLastName"><?php echo $lastName; ?></td>
                            </tr>
                            <tr>
                                <td>Email:</td>
                                <td id="displayEmail"><?php echo $email; ?></td>
                            </tr>
                            <tr>
                                <td>Phone:</td>
                                <td id="displayPhone"><?php echo $phone; ?></td>
                            </tr>
                            <tr>
                                <td>Password:</td>
                                <td id="displayPassword">••••••••</td>
                            </tr>
                        </table>
                    </div>
                    <!-- Form for editing account information -->
                    <div class="profile-box" id="editForm">
                        <hr id="horizontal">
                        <h5 class="heading"> Edit Account Information </h5>
                        <!-- Form fields pre-filled with current information -->
                        <form id="accountForm" class="form" method="POST" action="">
                            <div class="form-group">
                                <label for="firstName">First Name:</label>
                                <input type="text" id="firstName" name="firstName" value="<?php echo $firstName; ?>"
                                    class="form-control" required>
                                <div class="error"></div>
                            </div>
                            <div class="form-group">
                                <label for="lastName">Last Name:</label>
                                <input type="text" id="lastName" name="lastName" value="<?php echo $lastName; ?>"
                                    class="form-control" required>
                                <div class="error"></div>
                            </div>
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="email" id="email" name="email" value="<?php echo $email; ?>"
                                    class="form-control" required>
                                <div class="error"></div>
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone:</label>
                                <input type="text" id="phone" name="phone" value="<?php echo $phone; ?>"
                                    class="form-control" required pattern="[0-9]{10}"
                                    title="Provide a valid phone number of 10 digits without symbols">
                                <div class="error"></div>
                            </div>
                            <div class="form-group">
                                <label for="password">Password:</label>
                                <input type="password" id="password" name="password" class="form-control">
                                <p><small>Only fill this if you want to update the password.</small></p>
                                <div class="error"></div>
                            </div>
                            <!-- Save and Cancel buttons -->
                            <div class="buttons justify-content-between align-items-center mt-4">
                                <span onclick="cancelEdit();" class="text-decoration-none fw-bold">CANCEL</span>
                                <button type="submit" class="save-btn w-fit mt-0">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- FOOTER -->
        <div id="contact" class="container-fluid m-0 footer">
            <div class="row justify-content-center red">
                <div class="col-md-4 text-center">
                    <h4>Location</h4>
                    <p>497 East Moorestown Road, <br>Wind Gap, PA 18091</p>
                </div>
                <div class="col-md-4 text-center">
                    <h4>Hours</h4>
                    <p>Monday - Sunday<br>8am - 5pm</p>
                </div>
                <div class="col-md-4 text-center">
                    <h4>Contact</h4>
                    <p>dryvan@live.com<br>
                        <a href="tel:+14844846666"> (484) 484 6666 </a>
                    </p>
                </div>
            </div>
        </div>
        <!-- copyright -->
        <div class="container-fluid m-0 justify-content-center copyright">
            <div class="row">
                <div class="col">
                    <p> Copyright &copy; 2024 Northeast Xpress Inc. All rights reserved. </p>
                </div>
            </div>
        </div>
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.3.1.min.js"
            integrity="sha384-tsQFqpEReu7ZLhBV2VZlAu7zcOV+rXbYlF2cqB8txI/8aZajjp4Bqd+V6D5IgvKT"
            crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"
            integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
            crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"
            integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
            crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    </body>

</html>