<?php
error_reporting(E_ALL);
session_start();
// Database connection parameters

// Database connection parameters
$host = "localhost";
$dbname = "northeast_xpress_db"; // database name
$username = "root"; // database username
$password = "root"; // database password

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to check if user is logged in
function isLoggedIn()
{
    return isset($_SESSION['UserID']);
}

// Function to check if logged-in user is an admin
function isAdmin()
{
    return (isLoggedIn() && isset($_SESSION['Role']) && $_SESSION['Role'] === 'admin');
}

// Function to check if logged-in user is a regular user
function isUser()
{
    return (isLoggedIn() && isset($_SESSION['Role']) && $_SESSION['Role'] === 'user');
}