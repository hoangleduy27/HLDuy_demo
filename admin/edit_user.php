<?php
// Check if the user ID is provided
include 'connect.php';

if (isset($_GET['id'])) {
    $userID = $_GET['id'];

    // Connect to the database
   include 'connect.php';
 

    // Retrieve the user's current information from the database
    $query = "SELECT * FROM users WHERE id = '$userID'";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Error retrieving user information: " . mysqli_error($conn));
    }

    // Check if the user exists
    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        // Display the form to edit user information
        ?>
     <div class="edit-background">   
     <img src="./images/woowa_logo.png" alt="" class="logo-edit">

    <form action="update_user.php" method="POST" class="edit-form">
    <input type="hidden" name="id" value="<?php echo $userID; ?>">
    <div class="form-group">

        <label for="email">Email:</label>
        <input type="email" name="email" value="<?php echo $user['email']; ?>">
    </div>
    <div class="form-group">
        <label for="username">Username:</label>
        <input type="text" name="username" value="<?php echo $user['username']; ?>">
    </div>
    <div class="form-group">
        <label for="role">Role:</label>
        <input type="text" name="role" value="<?php echo $user['quyenhan']; ?>">
    </div>
    <div class="form-group">
        <label>Status:</label>
        <div class="radio-group">
            <input type="radio" name="status" value="0" <?php if ($user['status'] == 0) echo 'checked'; ?>>
            <span class="radio-label">Non-Active</span>
            <input type="radio" name="status" value="1" <?php if ($user['status'] == 1) echo 'checked'; ?>>
            <span class="radio-label">Active</span>
        </div>
    </div>
    <input type="submit" value="Update" class="btn-submit">
</form>
</div>

<?php
    } else {
        echo "User not found.";
    }

    // Close the database connection
    mysqli_close($conn);
} else {
    echo "Invalid user ID.";
}
?>

<link rel="stylesheet" href="css/edit.css">
