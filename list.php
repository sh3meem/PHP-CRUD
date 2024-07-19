<?php
// Start a session
session_start();

// Check if the user is logged in
if(!isset($_SESSION['username'])) {
    // If not logged in, redirect to login page
    header('location: login.php');
    exit;
}

// Get the username of the currently logged-in user
$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .container {
            max-width: 800px;
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

        h5 {
       
            color: green;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            color: #333;
            font-weight: bold;
            text-transform: uppercase;
        }

        td.actions a {
            text-decoration: none;
            padding: 8px 16px;
            border: 1px solid #007bff;
            border-radius: 4px;
            background-color: #007bff;
            color: #fff;
            transition: background-color 0.3s;
        }

        td.actions a:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .add-button {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .add-button a {
            text-decoration: none;
            padding: 12px 24px;
            background-color: #28a745;
            color: #fff;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .add-button a:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="container">
        <h5> <?php echo $username; ?></h5> <!-- Display the username -->
        <h2>Book List</h2>
        <?php
            // Include the database connection file
            include('database.php');

            // Retrieve book data from the database
            $sql = "SELECT id, author, title FROM book";
            $result = mysqli_query($conn, $sql);

            if(mysqli_num_rows($result) > 0) {
                echo "<table>";
                echo "<tr><th>Title</th><th>Author</th><th>Actions</th></tr>";
                while($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['title'] . "</td>";
                    echo "<td>" . $row['author'] . "</td>";
                    echo "<td class='actions'>
                            <a href='update.php?id=" . $row['id'] . "'>Edit</a>
                            <a href='delete.php?id=" . $row['id'] . "';\">Delete</a>
                          </td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "<p>No books found.</p>";
            }
        ?>
        <div class="add-button">
            <a href="add.php">Add New Book</a>
        </div>
    </div>
</body>
</html>
