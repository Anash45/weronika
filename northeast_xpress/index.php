<?php
include './includes/db_conn.php';

$info = "";
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Define recipient email address
    $to = "dryvan@live.com,anas14529@gmail.com";

    // Subject
    $subject = "Form Submission";

    // Message
    $message = "
    <html>
    <head>
    <title>Form Submission</title>
    </head>
    <body>
    <h2>Form Submission</h2>
    <table>
    <tr>
    <th>Email:</th>
    <td>{$_POST['email']}</td>
    </tr>
    <tr>
    <th>Message:</th>
    <td>{$_POST['message']}</td>
    </tr>
    </table>
    </body>
    </html>
    ";

    // Set additional headers
    $headers = "From: webmaster@f4futuretech.com" . "\r\n";
    $headers .= "Reply-To: {$_POST['email']}" . "\r\n";
    $headers .= "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1" . "\r\n";

    // Send email
    if (mail($to, $subject, $message, $headers)) {
        $info = "<p class='alert alert-success'>Email sent successfully.</p>";
    } else {
        $info = "<p class='alert alert-danger'>Failed to send email. Please try again later.</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Northeast Xpress Inc</title>
        <script async
            src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY_HERE&callback=console.debug&libraries=maps,marker&v=beta">
            </script>
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
        <!--- HERO -->
        <div class="hero">
            <div class="background">
                <div class="container-fluid m-0">
                    <div class="row">
                        <div class="col-sm-10 col-md-8 mr-auto background-text">
                            <h2> Premium parking space for all Trucks & Trailers in the heart of Pennsylvania. </h2>
                        </div>
                    </div>
                </div>
            </div>
            <!-- RATES -->
            <div class="container-fluid rates">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="text-center">
                            <div id="price" class="fade-in-from-top"> $200/month. </div>
                            <div id="price2" class="fade-in-from-top"> one price, nice and simple. </div>
                            <div id="pay" class="fade-in-from-top"> Pay the rate on the spot. </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ADDRESS -->
            <div class="container-fluid m-0">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-9 address">
                                <h3> 497 East Moorestown Road, Wind Gap, PA 18091 </h3>
                            </div>
                            <div class="col-md-3 business-info">
                                <div class="row">
                                    <div class="col-sm-6 col-md-12 hours">
                                        <h6>Hours</h6>
                                        <p>Monday - Sunday<br>8am - 5pm</p>
                                    </div>
                                    <div class="col-sm-6 col-md-12 phone">
                                        <h6>Phone</h6>
                                        <p>
                                            <a href="tel:+14844846666"> (484) 484 6666 </a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- MAP -->
            <div class="container-fluid m-0 map">
                <div class="row map-container">
                    <div class="col">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3018.7565767350643!2d-75.30488932335892!3d40.833310171375636!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c467c9a45e6d39%3A0xbd37b48e70394cf4!2s497%20E%20Moorestown%20Rd%2C%20Wind%20Gap%2C%20PA%2018091%2C%20USA!5e0!3m2!1sen!2sca!4v1711600417090!5m2!1sen!2sca&z=1"
                            allowfullscreen="" referrerpolicy="no-referrer-when-downgrade"
                            title="Map of Northeast Xpress Inc. Location">
                        </iframe>
                    </div>
                </div>
            </div>
            <!-- QUESTION FORM -->
            <div class="container-fluid m-0 question-form" id="quesion-form">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="parking-lot">
                            <h4> Welcome to Northeast Xpress Inc. Parking Lot </h4>
                            <p> To book your truck and trailer parking lot space for <strong>$200 per month</strong> in
                                Pennsylvania, make sure to log in and add your vehicle details. If you have any other
                                questions, feel free to contact us through email. We will make sure to get back to you
                                as soon as possible. </p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="contact-form">
                            <form id="form" class="form" action="#quesion-form" method="POST">
                                <?php echo $info; ?>
                                <!-- email -->
                                <div class="row">
                                    <div class="col">
                                        <div class="input-control">
                                            <label for="email">Email</label>
                                            <input id="email" type="email" required name="email">
                                            <div class="error"></div>
                                        </div>
                                    </div>
                                </div>
                                <!-- message -->
                                <div class="row">
                                    <div class="col">
                                        <div class="input-control">
                                            <label for="message">Message</label>
                                            <textarea id="message" rows="6" required name="message"></textarea>
                                            <div class="error"></div>
                                        </div>
                                    </div>
                                </div>
                                <!-- send btn -->
                                <div class="row">
                                    <div class="col">
                                        <button id="send-btn" type="submit">Send</button>
                                    </div>
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