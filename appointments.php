<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add'])) {
        $patient_id = $_POST['patient_id'];
        $doctor_id = $_POST['doctor_id'];
        $date_time = $_POST['date_time'];
        $department_id = $_POST['department_id'];

        $sql = "INSERT INTO Appointments (PatientID, DoctorID, DateTime, DepartmentID) 
                VALUES ($patient_id, $doctor_id, '$date_time', $department_id)";
        $conn->query($sql);
    } elseif (isset($_POST['delete'])) {
        $id = $_POST['id'];
        $sql = "DELETE FROM Appointments WHERE AppointmentID = $id";
        $conn->query($sql);
    }
}

$patients = $conn->query("SELECT * FROM Patients");
$doctors = $conn->query("SELECT * FROM Doctors");
$departments = $conn->query("SELECT * FROM Departments");
$result = $conn->query("
    SELECT a.AppointmentID, p.FullName AS PatientName, d.Name AS DoctorName, a.DateTime, dep.Name AS DepartmentName
    FROM Appointments a
    JOIN Patients p ON a.PatientID = p.PatientID
    JOIN Doctors d ON a.DoctorID = d.DoctorID
    JOIN Departments dep ON a.DepartmentID = dep.DepartmentID
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Appointments</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container my-4">
        <h1 class="text-center mb-4">Manage Appointments</h1>
        
        <div class="card mb-4">
            <div class="card-header">Add New Appointment</div>
            <div class="card-body">
                <form method="post">
                    <div class="mb-3">
                        <label for="patient_id" class="form-label">Patient</label>
                        <select name="patient_id" id="patient_id" class="form-select" required>
                            <option value="">Select Patient</option>
                            <?php while ($row = $patients->fetch_assoc()) : ?>
                                <option value="<?= $row['PatientID'] ?>"><?= $row['FullName'] ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="doctor_id" class="form-label">Doctor</label>
                        <select name="doctor_id" id="doctor_id" class="form-select" required>
                            <option value="">Select Doctor</option>
                            <?php while ($row = $doctors->fetch_assoc()) : ?>
                                <option value="<?= $row['DoctorID'] ?>"><?= $row['Name'] ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="date_time" class="form-label">Date and Time</label>
                        <input type="datetime-local" name="date_time" id="date_time" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="department_id" class="form-label">Department</label>
                        <select name="department_id" id="department_id" class="form-select">
                            <option value="">Select Department</option>
                            <?php while ($row = $departments->fetch_assoc()) : ?>
                                <option value="<?= $row['DepartmentID'] ?>"><?= $row['Name'] ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <button type="submit" name="add" class="btn btn-primary w-100">Add Appointment</button>
                </form>
            </div>
        </div>

        <h2 class="mb-4">Appointments List</h2>
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Patient</th>
                    <th>Doctor</th>
                    <th>Date and Time</th>
                    <th>Department</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) : ?>
                    <tr>
                        <td><?= $row['AppointmentID'] ?></td>
                        <td><?= $row['PatientName'] ?></td>
                        <td><?= $row['DoctorName'] ?></td>
                        <td><?= $row['DateTime'] ?></td>
                        <td><?= $row['DepartmentName'] ?></td>
                        <td>
                            <form method="post" style="display:inline;">
                                <input type="hidden" name="id" value="<?= $row['AppointmentID'] ?>">
                                <button type="submit" name="delete" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
