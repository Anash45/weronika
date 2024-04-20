<?php
require './includes/db_conn.php';

if (!isLoggedIn()) {
    header('Location:login.php');
}
// Define variables and initialize with empty values
$vehicleType = $companyName = $truckNumber = $truckMake = $truckPlateNumber = $DOTNumber = $MCNumber = $insurancePolicyNumber = $insurancePolicyExpirationDate = $federalInspectionExpirationDate = $stateInspectionExpirationDate = '';
$info = '';

// Get UserID of the logged-in user
$UserID = $_SESSION['UserID'];

if (isset($_GET['delete'])) {
    // Sanitize the input
    $vehicleID = intval($_GET['delete']);

    $sql1 = "SELECT UserID FROM vehicles WHERE id = '$vehicleID'";
    $result1 = $conn->query($sql1);
    $row1 = $result1->fetch_assoc();
    if (!empty($row1)) {
        if (isAdmin() || $UserID == $row1['UserID']) {
            // Prepare and execute SQL query to delete the vehicle
            $deleteQuery = "DELETE FROM vehicles WHERE id = $vehicleID";
            if ($conn->query($deleteQuery) === TRUE) {
                // Vehicle deleted successfully
                $info = "<p class='alert alert-success'>Vehicle deleted successfully.</p>";
            } else {
                // Error deleting vehicle
                $info = "<p class='alert alert-danger'>Error: An error occurred.</p>";
            }
        } else {
            $info = "<p class='alert alert-danger'>Error: Not authorised.</p>";
        }
    }


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
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $vehicleType = $_POST['vehicleType'];
    $companyName = $conn->real_escape_string($_POST['cname']);
    $truckNumber = $conn->real_escape_string($_POST['trucknum']);
    $truckMake = $conn->real_escape_string($_POST['truckmake']);
    $truckPlateNumber = $conn->real_escape_string($_POST['platenum']);
    $DOTNumber = $conn->real_escape_string($_POST['dotnum']);
    $MCNumber = $conn->real_escape_string($_POST['mcnum']);
    $insurancePolicyNumber = $conn->real_escape_string($_POST['policynum']);
    $insurancePolicyExpirationDate = $_POST['policyexp'];
    $federalInspectionExpirationDate = $_POST['federalexp'];
    $stateInspectionExpirationDate = $_POST['stateexp'];

    // Check if a vehicle with the same PlateNumber already exists
    $check_query = "SELECT * FROM vehicles WHERE truckPlateNumber = '$truckPlateNumber'";
    $check_result = $conn->query($check_query);

    if ($check_result->num_rows > 0) {
        // Vehicle with the same PlateNumber already exists
        $info = "<p class='alert alert-danger'>Error: A vehicle with the same Plate Number already exists.</p>";
    } else {
        // Insert vehicle into the database
        $insert_query = "INSERT INTO vehicles (vehicleType, companyName, truckNumber, truckMake, truckPlateNumber, DOTNumber, MCNumber, insurancePolicyNumber, insurancePolicyExpirationDate, federalInspectionExpirationDate, stateInspectionExpirationDate, UserID) VALUES ('$vehicleType', '$companyName', '$truckNumber', '$truckMake', '$truckPlateNumber', '$DOTNumber', '$MCNumber', '$insurancePolicyNumber', '$insurancePolicyExpirationDate', '$federalInspectionExpirationDate', '$stateInspectionExpirationDate', '$UserID')";

        if ($conn->query($insert_query) === TRUE) {
            // Vehicle added successfully
            $info = "<p class='alert alert-success'>Vehicle added successfully.</p>";
            // Reset form fields
            $vehicleType = $companyName = $truckNumber = $truckMake = $truckPlateNumber = $DOTNumber = $MCNumber = $insurancePolicyNumber = $insurancePolicyExpirationDate = $federalInspectionExpirationDate = $stateInspectionExpirationDate = '';
        } else {
            // Error adding vehicle
            $info = "<p class='alert alert-danger'>Error adding vehicle: " . $conn->error . "</p>";
        }
    }
}

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
        <a href="#" class="skip-to-content"> Skip to main content </a>
        <!-- NAVIGATION -->
        <?php include './includes/navbar.php'; ?>
        <!-- VEHICLES POP UP FORM -->
        <div id="vehiclesForm" class="container-fluid justify-content-center your-vehicles-form">
            <div class="row">
                <div class="col-sm-10 col-md-10 col-lg-5 m-auto vehicles">
                    <div class="closeButtonContainer">
                        <button type="button" class="closeButton" onclick="closeFormVehicle()"></button>
                    </div>
                    <h4> Add new vehicle </h4>
                    <p> Please provide all of the below information about your Trucks and Trailers. <br><span
                            id="required">All fields are required.</span>
                    </p>
                    <form id="truckForm" method="POST" action="">
                        <div class="input-control">
                            <label for="vehicleType">Vehicle Type*</label>
                            <div class="toggle">
                                <input type="checkbox" id="d" name="">
                                <input type="hidden" name="vehicleType" id="vehicleType">
                                <label for="d" aria-hidden="true">
                                    <div class="switch" data-checked="Trailer" data-unchecked="Truck"></div>
                                </label>
                            </div>
                        </div>
                        <div class="input-control">
                            <label for="cname">Company Name*</label>
                            <input type="text" id="cname" name="cname">
                            <div class="error-truck"></div>
                        </div>
                        <div class="input-control">
                            <label for="trucknum">Truck Number*</label>
                            <input type="text" id="trucknum" name="trucknum">
                            <div class="error-truck"></div>
                        </div>
                        <div class="input-control">
                            <label for="truckmake">Truck Make*</label>
                            <input type="text" id="truckmake" name="truckmake">
                            <div class="error-truck"></div>
                        </div>
                        <div class="input-control">
                            <label for="platenum">Truck Plate Number*</label>
                            <input type="text" id="platenum" name="platenum">
                            <div class="error-truck"></div>
                        </div>
                        <div class="input-control">
                            <label for="dotnum">DOT Number*</label>
                            <input type="text" id="dotnum" name="dotnum">
                            <div class="error-truck"></div>
                        </div>
                        <div class="input-control">
                            <label for="mcnum">MC Number*</label>
                            <input type="text" id="mcnum" name="mcnum">
                            <div class="error-truck"></div>
                        </div>
                        <div class="input-control">
                            <label for="policynum">Insurance Policy Number*</label>
                            <input type="text" id="policynum" name="policynum">
                            <div class="error-truck"></div>
                        </div>
                        <div class="input-control">
                            <label for="policyexp">Insurance Policy Expiration Date*</label>
                            <input type="date" id="policyexp" name="policyexp">
                            <div class="error-truck"></div>
                        </div>
                        <div class="input-control">
                            <label for="federalexp">Federal Inspection Expiration Date*</label>
                            <input type="date" id="federalexp" name="federalexp">
                            <div class="error-truck"></div>
                        </div>
                        <div class="input-control">
                            <label for="stateexp">State Inspection Expiration Date*</label>
                            <input type="date" id="stateexp" name="stateexp">
                            <div class="error-truck"></div>
                        </div>
                        <!-- refresh prevented to see the new row added -->
                        <button type="submit" class="submit-btn">Submit</button>
                    </form>
                </div>
            </div>
        </div>
        <!-- main vehicle section -->
        <div class="container-fluid your-vehicles" id="addVehicleButtonContainer">
            <div class="row">
                <div class="col-sm-12 text-center vehicles">
                    <h2></h2>
                </div>
                <div class="col-sm-12 col-md-12 col-lg-7 m-auto vehicles">
                    <?php echo $info; ?>
                </div>
                <div class="col-sm-12 col-md-12 col-lg-7 m-auto vehicles">
                    <div class="row" x-show="isFormVisible" @click.away="closeForm()">
                        <div class="col">
                            <table id="tvehicle" class="table table-bordered table-sm">
                                <tbody id="tbody">
                                    <?php
                                    $vehiclesHTML = '';
                                    // Prepare and execute SQL query to retrieve vehicles for the logged-in user
                                    if (isAdmin()) {
                                        $sql = "SELECT * FROM vehicles";
                                    } else {
                                        $sql = "SELECT * FROM vehicles WHERE UserID = $UserID";
                                    }
                                    $result = $conn->query($sql);

                                    // print_r($result->fetch_assoc());
                                    // Check if there are any vehicles
                                    if ($result->num_rows > 0) {
                                        // Loop through each row of the result set
                                        while ($row = $result->fetch_assoc()) {
                                            // Construct HTML for each vehicle and append it to $vehiclesHTML
                                            $vehiclesHTML .= '<tr><td><div class="container-fluid vtable" id="inputvehicle"><div class="row"><div class="col-sm-12 vtabletext">';
                                            $vehiclesHTML .= '<p class="vehicleDescription">' . $row['companyName'] . ' ' . $row['truckMake'] . ' ' . $row['truckPlateNumber'] . '</p>';
                                            $vehiclesHTML .= '</div></td><td><div class="col-sm-12 text-right vtableicon">';
                                            $status = ($row['approved']) ? '<b class="text-success mr-2">Approved</b>' : '<b class="text-warning mr-2">Pending</b>';
                                            $vehiclesHTML .= $status;
                                            if (isAdmin()) {
                                                $statusBtn = (!$row['approved']) ? '<a class="btn btn-sm btn-success" href="?id=' . $row['id'] . '&approve=1">Approve</a>' : '<a class="btn btn-sm btn-danger" href="?id=' . $row['id'] . '&approve=0">Disapprove</a>';
                                                $vehiclesHTML .= $statusBtn;
                                            } else {
                                                $remindBtn = '<a class="btn btn-sm btn-success" href="message.php?remindDm=' . $row['id'] . '">Remind</a>';
                                                $vehiclesHTML .= $remindBtn;
                                            }
                                            $vehiclesHTML .= '<a href="vehicle-details.php?id=' . $row['id'] . '" class="btn btn-primary btn-sm">Details</a>';
                                            $vehiclesHTML .= '<a href="?delete=' . $row['id'] . '" class="remove-vehicle-btn btn btn-light btn-outline-dark"><img src="assets/img/delete-button.png" alt="bin icon"></a>';
                                            $vehiclesHTML .= '</div></div></div></td></tr>';
                                        }
                                    } else {
                                        // No vehicles found
                                        $vehiclesHTML = '<tr><td colspan="2">No vehicles found.</td></tr>';
                                    }
                                    echo $vehiclesHTML;
                                    // Close connection
                                    $conn->close();
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td class="text-right">
                                            <span id="placeholder">It's looking empty in here...</span>
                                        </td>
                                        <td><button onclick="openFormVehicle();" type="button" class="add-vehicle-btn"
                                                id="add-vehicle-btn">+ Add Vehicle</button></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- FIX TRUCK BUTTON + FORM -->
        <div class="container-fluid fix">
            <div class="row justify-content-end">
                <div class="col-auto" id="fixTruckButton">
                    <button onclick="openForm()" class="fix-truck-button">Need to fix your<br>truck?</button>
                </div>
            </div>
        </div>
        <!-- The pop-out form -->
        <div id="myForm" class="popup-form">
            <h2>Vehicle Fix Request</h2>
            <p>Please provide as much detail as possible regarding<br> the issue your vehicle is encountering.</p>
            <form action="#">
                <!-- Dummy input fields -->
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required><br><br>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required><br><br>
                <label for="message">Message:</label><br>
                <textarea id="message" name="message" rows="4" cols="40" required></textarea><br><br>
                <div class="buttons">
                    <button type="submit" class="fix-submit-btn">Send</button>
                    <button type="button" class="fix-close-btn" onclick="closeForm()">Close</button>
                </div>
            </form>
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