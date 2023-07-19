<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the form data
    $userID = $_POST['id'];
    $email = $_POST['email'];
    $users = $_POST['username'];
    $role = $_POST['role'];
    $status = $_POST['status'];

    // Connect to the database
    include 'connect.php';

    // Check the role of the user
    $query = "SELECT quyenhan FROM users WHERE id = '$userID'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $user = mysqli_fetch_assoc($result);
        $userRole = $user['quyenhan'];

        // Only allow status update if the user has role "user"
        if ($userRole === 'user') {
            // Update the user information in the database
            $query = "UPDATE users SET email = '$email', username = '$users', quyenhan = '$role', status = '$status' WHERE id = '$userID'";
            $updateResult = mysqli_query($conn, $query);

            if ($updateResult) {
                echo '<script>alert("User information updated successfully.");
                window.location.href = "admin.php"; 
                </script>';

            } else {
                echo "Error updating user information: " . mysqli_error($conn);
            }
        } else {
            echo "You do not have permission to update the status.";
        }
    } else {
        echo "Error retrieving user information: " . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_close($conn);
}
?>
<a href="admin.php">back</a>
