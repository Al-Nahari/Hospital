<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add'])) {
        $fullname = $_POST['fullname'];
        $nationalid = $_POST['nationalid'];
        $gender = $_POST['gender'];
        $age = $_POST['age'];
        $history = $_POST['history'];

        $sql = "INSERT INTO Patients (FullName, NationalID, Gender, Age, MedicalHistory) 
                VALUES ('$fullname', '$nationalid', '$gender', $age, '$history')";
        $conn->query($sql);
    } elseif (isset($_POST['delete'])) {
        $id = $_POST['id'];
        $sql = "DELETE FROM Patients WHERE PatientID = $id";
        $conn->query($sql);
    }
}

$result = $conn->query("SELECT * FROM Patients");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Patients</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h1 class="text-center mb-4">Manage Patients</h1>
        <form method="post" class="mb-4">
            <div class="row g-3">
                <div class="col-md-3">
                    <input type="text" name="fullname" class="form-control" placeholder="Full Name" required>
                </div>
                <div class="col-md-3">
                    <input type="text" name="nationalid" class="form-control" placeholder="National ID" required>
                </div>
                <div class="col-md-2">
                    <select name="gender" class="form-select" required>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="number" name="age" class="form-control" placeholder="Age" required>
                </div>
                <div class="col-md-4">
                    <textarea name="history" class="form-control" placeholder="Medical History"></textarea>
                </div>
                <div class="col-12 text-center">
                    <button type="submit" name="add" class="btn btn-primary">Add Patient</button>
                </div>
            </div>
        </form>
        <h2 class="mb-3">Patients List</h2>
        <table class="table table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Full Name</th>
                    <th>National ID</th>
                    <th>Gender</th>
                    <th>Age</th>
                    <th>Medical History</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) : ?>
                    <tr>
                        <td><?= $row['PatientID'] ?></td>
                        <td><?= $row['FullName'] ?></td>
                        <td><?= $row['NationalID'] ?></td>
                        <td><?= $row['Gender'] ?></td>
                        <td><?= $row['Age'] ?></td>
                        <td><?= $row['MedicalHistory'] ?></td>
                        <td>
                            <form method="post" class="d-inline">
                                <input type="hidden" name="id" value="<?= $row['PatientID'] ?>">
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
