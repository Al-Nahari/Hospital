
<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add'])) {
        $name = $_POST['name'];
        $beds = $_POST['beds'];

        $sql = "INSERT INTO Departments (Name, BedsAvailable) VALUES ('$name', $beds)";
        $conn->query($sql);
    } elseif (isset($_POST['delete'])) {
        $id = $_POST['id'];
        $sql = "DELETE FROM Departments WHERE DepartmentID = $id";
        $conn->query($sql);
    }
}

$result = $conn->query("SELECT * FROM Departments");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Departments</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h1 class="text-center mb-4">Manage Departments</h1>
        <form method="post" class="mb-4">
            <div class="row g-3">
                <div class="col-md-6">
                    <input type="text" name="name" class="form-control" placeholder="Department Name" required>
                </div>
                <div class="col-md-4">
                    <input type="number" name="beds" class="form-control" placeholder="Beds Available" required>
                </div>
                <div class="col-12 text-center">
                    <button type="submit" name="add" class="btn btn-primary">Add Department</button>
                </div>
            </div>
        </form>
        <h2 class="mb-3">Departments List</h2>
        <table class="table table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Beds Available</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) : ?>
                    <tr>
                        <td><?= $row['DepartmentID'] ?></td>
                        <td><?= $row['Name'] ?></td>
                        <td><?= $row['BedsAvailable'] ?></td>
                        <td>
                            <form method="post" class="d-inline">
                                <input type="hidden" name="id" value="<?= $row['DepartmentID'] ?>">
                                <button type="submit" name="delete" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
