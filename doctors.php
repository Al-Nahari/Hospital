<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add'])) {
        $name = $_POST['name'];
        $specialization = $_POST['specialization'];
        $phone = $_POST['phone'];
        $schedule = $_POST['schedule'];

        $sql = "INSERT INTO Doctors (Name, Specialization, Phone, Schedule) 
                VALUES ('$name', '$specialization', '$phone', '$schedule')";
        $conn->query($sql);
    } elseif (isset($_POST['delete'])) {
        $id = $_POST['id'];
        $sql = "DELETE FROM Doctors WHERE DoctorID = $id";
        $conn->query($sql);
    }
}

$result = $conn->query("SELECT * FROM Doctors");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Doctors</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h1 class="text-center mb-4">Manage Doctors</h1>
        <form method="post" class="mb-4">
            <div class="row g-3">
                <div class="col-md-3">
                    <input type="text" name="name" class="form-control" placeholder="Name" required>
                </div>
                <div class="col-md-3">
                    <input type="text" name="specialization" class="form-control" placeholder="Specialization" required>
                </div>
                <div class="col-md-2">
                    <input type="text" name="phone" class="form-control" placeholder="Phone">
                </div>
                <div class="col-md-4">
                    <textarea name="schedule" class="form-control" placeholder="Schedule"></textarea>
                </div>
                <div class="col-12 text-center">
                    <button type="submit" name="add" class="btn btn-primary">Add Doctor</button>
                </div>
            </div>
        </form>
        <h2 class="mb-3">Doctors List</h2>
        <table class="table table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Specialization</th>
                    <th>Phone</th>
                    <th>Schedule</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) : ?>
                    <tr>
                        <td><?= $row['DoctorID'] ?></td>
                        <td><?= $row['Name'] ?></td>
                        <td><?= $row['Specialization'] ?></td>
                        <td><?= $row['Phone'] ?></td>
                        <td><?= $row['Schedule'] ?></td>
                        <td>
                            <form method="post" class="d-inline">
                                <input type="hidden" name="id" value="<?= $row['DoctorID'] ?>">
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
