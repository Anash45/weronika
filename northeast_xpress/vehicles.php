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
        <a href="#" class="skip-to-content"> Skip to main content </a>
        <!-- NAVIGATION -->
        <?php include './includes/navbar.php'; ?>
        <!-- VEHICLES POP UP FORM -->
        <main>
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
                                                $vehiclesHTML .= '</div></td><td><div class="col-sm-12 text-right vtableicon v-table-right">';
                                                $status = '';
                                                if ($row['approved'] == 1) {
                                                    $status = '<b class="text-success mr-2">APPROVED</b>';
                                                } else if ($row['approved'] == 2) {
                                                    $status = '<b class="text-danger mr-2">DECLINED</b>';
                                                } else if ($row['approved'] == 3) {
                                                    $status = '<b class="text-warning mr-2">PENDING</b>';
                                                }
                                                $vehiclesHTML .= $status;
                                                if (isUser()) {
                                                    $remindBtn = '<span class="request font-weight-medium text-secondary cursor-pointer mx-2" data-id="' . $row['id'] . '">REQUEST</span>';
                                                    $vehiclesHTML .= '<input class="datePicker d-none" type="date">' . $remindBtn;
                                                }
                                                $vehiclesHTML .= '<a href="vehicle-details.php?id=' . $row['id'] . '" class="font-weight-medium mx-2 text-secondary">DETAILS</a>';
                                                if (isAdmin()) {
                                                    $vehiclesHTML .= '<a href="message.php?UserID=' . $row['UserID'] . '" class="text-secondary mx-2"><i class="fa fa-envelope"></i></a>';
                                                }
                                                $vehiclesHTML .= '<a href="?delete=' . $row['id'] . '" class="remove-vehicle-btn btn"><img src="assets/img/delete-button.png" alt="bin icon"></a>';
                                                $vehiclesHTML .= '</div></div></div></td></tr>';
                                            }
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
                                            <td class="text-right"><button onclick="openFormVehicle();" type="button"
                                                    class="add-vehicle-btn" id="add-vehicle-btn">+ Add Vehicle</button>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            if (isUser()) {
                ?>
                <!-- FIX TRUCK BUTTON + FORM -->
                <div class="container-fluid fix">
                    <div class="row justify-content-end">
                        <div class="col-auto" id="fixTruckButton">
                            <button onclick="openForm()" class="fix-truck-button">Need to fix your<br>truck?</button>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
            <!-- The pop-out form -->
            <div id="myForm" class="popup-form">
                <div class="text-center">
                    <h2>Vehicle Fix Request</h2>
                    <p class="mb-4">Please provide as much detail as possible regarding<br> the issue your vehicle is encountering.
                    </p>
                </div>
                <form action="message.php" class="pt-2" method="POST">
                    <!-- Dummy input fields -->
                    <div class="d-flex mb-2">
                        <label for="name">Name:</label>
                        <input type="text" class="ml-2 rounded-3 fix-inp" id="name" name="name" required>
                    </div>
                    <div class="d-flex mb-2">
                        <label for="email">Email:</label>
                        <input type="email" class="ml-2 rounded-3 fix-inp" id="email" name="email" required>
                    </div>
                    <div class="d-flex flex-column mb-3">
                        <label for="message">Vehicle Issue:</label>
                        <textarea id="message" name="message" class="rounded-3 fix-inp mt-1" rows="4" cols="40"
                            required></textarea>
                    </div>
                    <div class="buttons pt-3">
                        <button type="button" class="fix-close-btn" onclick="closeForm()">Close</button>
                        <button type="submit" class="fix-submit-btn ml-auto" name="repairRequest">Send</button>
                    </div>
                </form>
            </div>
        </main>
        <!-- FOOTER -->
        <footer>
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
        </footer>
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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/js/bootstrap-datepicker.min.js"
            integrity="sha512-LsnSViqQyaXpD4mBBdRYeP6sRwJiJveh2ZIbW41EBrNmKxgr/LFZIiWT6yr+nycvhvauz8c2nYMhrP80YhG7Cw=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script>
            $(document).ready(function () {
                $('.request').click(function () {
                    // Open the date picker associated with the clicked button
                    $('.datepicker').datepicker('show', {
                        clearBtn: true,
                    });

                    $('.datepicker-title').html('Select Start Date').show();
                });

                // Capture the date selection event for all datepickers
                $('.datepicker').on('changeDate', function (e) {
                    // Get the selected date
                    var selectedDate = e.date;

                    var mysqlDatetime = formatDateToMySQLDatetime(selectedDate);
                    // Get the message ID from the associated .request button
                    var messageId = $(this).siblings('.request').data('id');

                    // Construct the URL with parameters
                    var url = 'message.php?requestId=' + messageId + '&selectedDate=' + mysqlDatetime;

                    // Redirect to messages.php with the parameters
                    window.location.href = url;
                });
            });
            // Function to format date to MySQL DATETIME format
            function formatDateToMySQLDatetime(date) {
                // Ensure date is a valid Date object
                if (!(date instanceof Date)) {
                    return null;
                }

                // Format the date components
                var year = date.getFullYear();
                var month = padZero(date.getMonth() + 1); // Months are zero indexed, so add 1
                var day = padZero(date.getDate());
                var hours = padZero(date.getHours());
                var minutes = padZero(date.getMinutes());
                var seconds = padZero(date.getSeconds());

                // Return formatted datetime string
                return year + '-' + month + '-' + day + ' ' + hours + ':' + minutes + ':' + seconds;
            }

            // Function to pad zero to single-digit numbers
            function padZero(num) {
                return (num < 10 ? '0' : '') + num;
            }
        </script>
    </body>

</html>