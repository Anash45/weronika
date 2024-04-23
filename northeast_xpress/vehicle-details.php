<?php
require_once './includes/db_conn.php';

$info = '';

// Check if user is logged in
if (!isLoggedIn()) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: vehicles.php");
    exit();
}
if (isset($_GET['id']) && isset($_GET['approve']) && isAdmin()) {
    // Get the values of id and approve from the URL
    $id = $_GET['id'];
    $approve = $_GET['approve'];

    // Construct the SQL UPDATE statement
    $sql = "UPDATE vehicles SET approved = '$approve' WHERE id = '$id'";

    // Execute the SQL statement
    if ($conn->query($sql) === TRUE) {
        $info = "<div class='alert alert-success'>Vehicle status updated successfully</div>";
    } else {
        $info = "<div class='alert alert-danger'>Error updating record: " . $conn->error . "</div>";
    }
}
$vehicleID = $_GET['id'];

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
                    <h2 class="d-flex justify-content-between" id="fullName"><a href="vehicles.php" class="mr-2"><i
                                class="fa fa-chevron-left back-icon text-secondary"></i></a><span class="mx-auto">Vehicle
                            Information</span></h2>
                    <?php echo $info; ?>
                    <!-- Profile photo upload section (to be implemented) -->
                    <!-- Display profile information in a table -->
                    <div class="profile-box" id="profileInfo">
                        <?php
                        // Prepare and execute SQL query to fetch all vehicles
                        $sql = "SELECT * FROM vehicles WHERE id = $vehicleID";
                        $result = $conn->query($sql);

                        // Mapping of keys to proper names
                        $keyToNameMap = array(
                            'vehicleType' => 'Vehicle Type',
                            'companyName' => 'Company Name',
                            'truckNumber' => 'Truck Number',
                            'truckMake' => 'Truck Make',
                            'truckPlateNumber' => 'Truck Plate Number',
                            'DOTNumber' => 'DOT Number',
                            'MCNumber' => 'MC Number',
                            'insurancePolicyNumber' => 'Insurance Policy Number',
                            'insurancePolicyExpirationDate' => 'Insurance Policy Expiration Date',
                            'federalInspectionExpirationDate' => 'Federal Inspection Expiration Date',
                            'stateInspectionExpirationDate' => 'State Inspection Expiration Date',
                        );

                        if ($result && $result->num_rows > 0) {
                            // Output vehicle information in the table
                            echo '<table class="tprofile table table-borderless">';
                            while ($row = $result->fetch_assoc()) {
                                // Loop through each column and display its name and value
                                foreach ($keyToNameMap as $key => $value) {
                                    echo '<tr>';
                                    if (array_key_exists($key, $row)) {
                                        $properName = $keyToNameMap[$key];
                                        echo '<th>' . $properName . ':</th>';
                                        echo '<td>' . $row[$key] . '</td>';
                                    }
                                    echo '</tr>';
                                }
                            }
                            echo '</table>';
                        } else {
                            // No vehicles found in the database
                            echo '<p>No vehicles found.</p>';
                        }
                        ?>
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