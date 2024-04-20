<?php
require './includes/db_conn.php';
// Check if the user is an admin
if (isAdmin()) {
    // If admin, get UserID from the URL parameter
    if (isset($_GET['UserID'])) {
        $userID = $_GET['UserID'];
    } else {
        // Redirect to inbox page if UserID is not set for admin
        header("Location: inbox.php");
        exit;
    }
} else {
    // If user, get UserID from the session
    if (isUser()) {
        $userID = $_SESSION['UserID'];
    } else {
        // Redirect to login page if UserID is not set for user
        header("Location: login.php");
        exit;
    }
}

function sendMessage($message)
{
    global $conn;
    global $userID;
    // Get the sender from the session (assuming sender is user)

    if (isAdmin()) {
        $sender = 'admin';
    } else {
        $sender = 'user';
    }

    // Construct the SQL INSERT statement
    $sql = "INSERT INTO messages (UserID, MessageContent, sender) VALUES ('$userID', '$message', '$sender')";

    // Execute the SQL statement
    if ($conn->query($sql) !== TRUE) {
        header("Location: " . $_SERVER['REQUEST_URI']);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['send'])) {
    // Get the message from the form
    $message = $conn->real_escape_string($_POST['message']);
    sendMessage($message);
}

if (isset($_GET['remindDm'])) {
    // Get the message from the form
    $vehicleID = $_GET['remindDm'];
    $message = 'Hey sir, kindly approve the spot for my <a href="vehicle-details.php?id='.$vehicleID.'">vehicle</a>.';
    sendMessage($message);
    header("Location: message.php");
}
?>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Northeast Xpress Inc</title>
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
            integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="assets/css/style.css">
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Work+Sans:ital,wght@0,100..900;1,100..900&display=swap"
            rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    </head>

    <body class="message-page">
        <!-- Skip to content link -->
        <a href="#home" class="skip-to-content"> Skip to main content </a>
        <!-- NAVIGATION -->
        <?php include './includes/navbar.php'; ?>
        <!-- MAIN -->
        <main class="messages-container">
            <div class="container">
                <div class="col-md-8 col-12 messages mx-auto pb-3">
                    <div class="chat border">
                        <div class="chat-header p-2 border-bottom">
                            <h5 class="mb-0">Chat</h5>
                        </div>
                        <div class="chat-body p-2" id="chat-body">
                            <?php
                            $sql = "SELECT * FROM messages WHERE UserID = '$userID' ORDER BY MessageID";
                            $result = $conn->query($sql);
                            $row = $result->fetch_assoc();
                            if (!empty($row)) {
                                while ($row = $result->fetch_assoc()) {
                                    if (isAdmin() && $row['sender'] == 'admin') {
                                        echo '<div class="chat-message sender-message">
                                        <div class="message-content">
                                            <p class="chat-text">' . $row['MessageContent'] . '</p>
                                            <p class="chat-date">' . $row['Timestamp'] . '</p>
                                        </div>
                                    </div>';
                                    } elseif (isUser() && $row['sender'] == 'user') {
                                        echo '<div class="chat-message sender-message">
                                        <div class="message-content">
                                            <p class="chat-text">' . $row['MessageContent'] . '</p>
                                            <p class="chat-date">' . $row['Timestamp'] . '</p>
                                        </div>
                                    </div>';
                                    } else {
                                        echo '<div class="chat-message receiver-message">
                                        <div class="message-content">
                                            <p class="chat-text">' . $row['MessageContent'] . '</p>
                                            <p class="chat-date">' . $row['Timestamp'] . '</p>
                                        </div>
                                    </div>';
                                    }
                                }
                            }
                            ?>
                        </div>
                        <div class="chat-footer">
                            <form method="post" action="" class="d-flex mb-0">
                                <input type="text" name="message" id="message" placeholder="Type your message..."
                                    class="form-control flex-grow-1">
                                <button class="btn btn-light" name="send">Send</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
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
        <script src="assets/js/script.js"></script>
    </body>

</html>