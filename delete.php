<?php
// Include the database connection file
include('database.php');

// Start a session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // If not logged in, redirect to login page
    header('location: login.php');
    exit;
}

// Check if the book ID is provided in the URL
if (isset($_GET['id'])) {
    // Sanitize the input to prevent SQL injection
    $book_id = mysqli_real_escape_string($conn, $_GET['id']);

    // Write the SQL query to delete the book
    $sql = "DELETE FROM book WHERE id = $book_id";

    // Execute the SQL query
    if (mysqli_query($conn, $sql)) {
        // If deletion is successful, redirect to the book list page
        header('location:list.php');
        exit;
    } else {
        // If an error occurs, display an error message
        echo "Error deleting record: " . mysqli_error($conn);
    }
} else {
    // If no book ID is provided, redirect to the book list page
    header('location:list.php');
    exit;
}
?>
