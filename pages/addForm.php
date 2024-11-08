<?php
session_start();
if (!isset($_SESSION['email']) || !isset($_SESSION['password'])) {
    header('location:../index.php');
    exit();
}

// Check if the form has been submitted
if (isset($_POST['submit'])) {
    // Capture form data and store it in the session 'students' array
    $newStudent = [
        'name' => htmlspecialchars($_POST['name']),
        'age' => htmlspecialchars($_POST['age']),
        'gender' => htmlspecialchars($_POST['gender'])
    ];

    if (!isset($_SESSION['students'])) {
        $_SESSION['students'] = [];
    }

    $_SESSION['students'][] = $newStudent;

    // Redirect to show_details.php to display the submitted information
    header('location: showDetails.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Add Form</title>
    <?php include('../layout/style.php'); ?>
</head>
<style>
    .form-container {
        border: 1px solid #ccc;
        padding: 20px;
        border-radius: 8px;
        width: 300px;
        margin: 0 auto;
    }
    .form-container input[type="text"], .form-container input[type="number"], .form-container button {
        width: 100%;
        margin-bottom: 10px;
    }
    .form-container .gender-options {
        display: flex;
        gap: 10px;
    }
</style>
<body class="sb-nav-fixed">
    <?php include('../layout/header.php'); ?>
    <div id="layoutSidenav">
        <?php include('../layout/navigation.php'); ?>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <div class="form-container">
                        <h2>Add Form</h2>
                        <form action="addForm.php" method="POST">
                            <label for="name">Name:</label>
                            <input type="text" id="name" name="name" placeholder="Enter name" required>

                            <label for="age">Age:</label>
                            <input type="number" id="age" name="age" placeholder="Enter age" required>

                            <label>Gender:</label>
                            <div class="gender-options">
                                <input type="radio" id="male" name="gender" value="Male" required>
                                <label for="male">Male</label>
                                <input type="radio" id="female" name="gender" value="Female" required>
                                <label for="female">Female</label>
                            </div>

                            <button type="submit" name="submit">Submit</button>
                            <button type="reset">Clear</button>
                        </form>
                        <br>
                        <a href="showDetails.php">View Details</a> <!-- Link to Show Details page -->
                    </div>
                </div>
            </main>
            <?php include('../layout/footer.php'); ?>
        </div>
    </div>
    <?php include('../layout/script.php'); ?>
</body>
</html>

