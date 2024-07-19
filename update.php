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
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve and sanitize input values
        $id = $_POST['id'];
        $title = mysqli_real_escape_string($conn, $_POST['title']);
        $author = mysqli_real_escape_string($conn, $_POST['author']);

        // Write the SQL query to update the book
        $sql = "UPDATE book SET title = '$title', author = '$author' WHERE id = $id";

        // Execute the SQL query
        if (mysqli_query($conn, $sql)) {
            // If update is successful, redirect to the book list page
            header('location: list.php');
            exit;
        } else {
            // If an error occurs, display an error message
            echo "Error updating book: " . mysqli_error($conn);
        }
    }

    // Retrieve book details from the database
    $sql = "SELECT * FROM book WHERE id = $id";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Book</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .container {
            max-width: 400px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #007bff;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        label {
            margin-bottom: 10px;
            font-weight: bold;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button[type="submit"] {
            padding: 12px 24px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Edit Book</h2>
        <form action="update.php?id=<?php echo $row['id']; ?>" method="post">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" value="<?php echo $row['title']; ?>" required>
            <label for="author">Author:</label>
            <input type="text" id="author" name="author" value="<?php echo $row['author']; ?>" required>
            <button type="submit" name="submit">Update Book</button>
        </form>
    </div>
</body>
</html>
<?php
    } else {
        echo "<p>Book not found.</p>";
    }
} else {
    echo "<p>Invalid request.</p>";
}
?>
