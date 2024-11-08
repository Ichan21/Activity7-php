<?php
session_start();
if (!isset($_SESSION['email']) || !isset($_SESSION['password'])) {
    header('Location: ../index.php');
    exit();
}

if (!isset($_SESSION['students'])) {
    $_SESSION['students'] = [];
}

$students = $_SESSION['students'];

// Handle form submissions for Insert, Update, and Delete
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'insert') {
            // Insert a new student
            $newStudent = [
                'name' => $_POST['name'],
                'age' => $_POST['age'],
                'gender' => $_POST['gender']
            ];
            $_SESSION['students'][] = $newStudent;
        } elseif ($_POST['action'] === 'update') {
            // Update an existing student
            $index = $_POST['index'];
            $_SESSION['students'][$index] = [
                'name' => $_POST['name'],
                'age' => $_POST['age'],
                'gender' => $_POST['gender']
            ];
        } elseif ($_POST['action'] === 'delete') {
            // Delete a student
            $index = $_POST['index'];
            array_splice($_SESSION['students'], $index, 1);
        }
        // Redirect to prevent form resubmission
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management</title>
    <?php include('../layout/style.php'); ?>
    <style>
        /* Custom styles for a cleaner and modern layout */
        .student-card {
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        .table th, .table td {
            text-align: center;
        }
        .modal-footer {
            display: flex;
            justify-content: space-between;
        }
    </style>
</head>
<body class="sb-nav-fixed">

    <?php include('../layout/header.php'); ?>

    <div id="layoutSidenav">
        <?php include('../layout/navigation.php'); ?>

        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Manage Students</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                    <div class="student-card card">
                        <div class="card-header">
                            <i class="fas fa-users me-2"></i> Student List
                        </div>
                        <div class="card-body">
                            <?php if (count($students) > 0): ?>
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Age</th>
                                            <th>Gender</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($students as $index => $student): ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($student['name']); ?></td>
                                                <td><?php echo htmlspecialchars($student['age']); ?></td>
                                                <td><?php echo htmlspecialchars($student['gender']); ?></td>
                                                <td>
                                                    <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#updateModal" onclick="openUpdateModal(<?php echo $index; ?>)">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </button>
                                                    <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal" onclick="openDeleteModal(<?php echo $index; ?>)">
                                                        <i class="fas fa-trash"></i> Delete
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            <?php else: ?>
                                <p>No students to display.</p>
                            <?php endif; ?>
                            <button class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#insertModal">
                                <i class="fas fa-plus"></i> Add New Student
                            </button>
                        </div>
                    </div>
                </div>
            </main>
            <?php include('../layout/footer.php'); ?>
        </div>
    </div>

    <?php include('../layout/script.php'); ?>

    <!-- Insert Modal -->
    <div class="modal fade" id="insertModal" tabindex="-1" aria-labelledby="insertModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="insertModalLabel">Add New Student</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="age" class="form-label">Age</label>
                            <input type="number" class="form-control" name="age" required>
                        </div>
                        <div class="mb-3">
                            <label for="gender" class="form-label">Gender</label>
                            <select class="form-select" name="gender" required>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                        <input type="hidden" name="action" value="insert">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Update Modal -->
    <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateModalLabel">Update Student</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST">
                        <div class="mb-3">
                            <label for="updateName" class="form-label">Name</label>
                            <input type="text" class="form-control" id="updateName" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="updateAge" class="form-label">Age</label>
                            <input type="number" class="form-control" id="updateAge" name="age" required>
                        </div>
                        <div class="mb-3">
                            <label for="updateGender" class="form-label">Gender</label>
                            <select class="form-select" id="updateGender" name="gender" required>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                        <input type="hidden" name="action" value="update">
                        <input type="hidden" name="index" id="updateIndex">
                        <button type="submit" class="btn btn-warning">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Delete Student</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this student?</p>
                    <form action="" method="POST">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="index" id="deleteIndex">
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-danger">Delete</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // JavaScript for opening the update modal with student data
        function openUpdateModal(index) {
            const student = <?php echo json_encode($students); ?>[index];
            document.getElementById('updateName').value = student.name;
            document.getElementById('updateAge').value = student.age;
            document.getElementById('updateGender').value = student.gender;
            document.getElementById('updateIndex').value = index;
        }

        // JavaScript for opening the delete modal
        function openDeleteModal(index) {
            document.getElementById('deleteIndex').value = index;
        }
    </script>

</body>
</html>

