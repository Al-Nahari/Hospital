<?php
include 'config.php';

// Handle form submission to generate report
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $report_type = $_POST['report_type'];
    $date_from = $_POST['date_from'];
    $date_to = $_POST['date_to'];

    if ($report_type == 'appointments') {
        $query = "SELECT a.AppointmentID, p.FullName AS PatientName, d.Name AS DoctorName, a.DateTime, dep.Name AS DepartmentName
                  FROM Appointments a
                  JOIN Patients p ON a.PatientID = p.PatientID
                  JOIN Doctors d ON a.DoctorID = d.DoctorID
                  JOIN Departments dep ON a.DepartmentID = dep.DepartmentID
                  WHERE a.DateTime BETWEEN '$date_from' AND '$date_to'";
    } elseif ($report_type == 'departments') {
        $query = "SELECT dep.Name AS DepartmentName, COUNT(a.AppointmentID) AS AppointmentCount, dep.BedsAvailable
                  FROM Departments dep
                  LEFT JOIN Appointments a ON dep.DepartmentID = a.DepartmentID
                  WHERE a.DateTime BETWEEN '$date_from' AND '$date_to'
                  GROUP BY dep.DepartmentID";
    } elseif ($report_type == 'inventory') {
        $query = "SELECT i.Name AS ItemName, i.Quantity, i.ExpiryDate, dep.Name AS DepartmentName
                  FROM Inventory i
                  JOIN Departments dep ON i.DepartmentID = dep.DepartmentID
                  WHERE i.ExpiryDate BETWEEN '$date_from' AND '$date_to'";
    }

    $result = $conn->query($query);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container my-5">
        <h1 class="text-center mb-4">Generate Reports</h1>
        <div class="card mb-4">
            <div class="card-header">Select Report Type and Date Range</div>
            <div class="card-body">
                <form method="post">
                    <div class="mb-3">
                        <label for="report_type" class="form-label">Report Type</label>
                        <select name="report_type" id="report_type" class="form-select" required>
                            <option value="appointments">Appointments</option>
                            <option value="departments">Departments</option>
                            <option value="inventory">Inventory</option>
                        </select>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="date_from" class="form-label">From Date</label>
                            <input type="date" name="date_from" id="date_from" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="date_to" class="form-label">To Date</label>
                            <input type="date" name="date_to" id="date_to" class="form-control" required>
                        </div>
                    </div>
                    <div class="text-center mt-3">
                        <button type="submit" class="btn btn-primary">Generate Report</button>
                    </div>
                </form>
            </div>
        </div>

        <?php if (isset($result)): ?>
            <h2 class="mb-3">Report Results</h2>
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <?php if ($report_type == 'appointments'): ?>
                            <th>Appointment ID</th>
                            <th>Patient Name</th>
                            <th>Doctor Name</th>
                            <th>Date and Time</th>
                            <th>Department</th>
                        <?php elseif ($report_type == 'departments'): ?>
                            <th>Department Name</th>
                            <th>Appointment Count</th>
                            <th>Beds Available</th>
                        <?php elseif ($report_type == 'inventory'): ?>
                            <th>Item Name</th>
                            <th>Quantity</th>
                            <th>Expiry Date</th>
                            <th>Department</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <?php if ($report_type == 'appointments'): ?>
                                <td><?= $row['AppointmentID'] ?></td>
                                <td><?= $row['PatientName'] ?></td>
                                <td><?= $row['DoctorName'] ?></td>
                                <td><?= $row['DateTime'] ?></td>
                                <td><?= $row['DepartmentName'] ?></td>
                            <?php elseif ($report_type == 'departments'): ?>
                                <td><?= $row['DepartmentName'] ?></td>
                                <td><?= $row['AppointmentCount'] ?></td>
                                <td><?= $row['BedsAvailable'] ?></td>
                            <?php elseif ($report_type == 'inventory'): ?>
                                <td><?= $row['ItemName'] ?></td>
                                <td><?= $row['Quantity'] ?></td>
                                <td><?= $row['ExpiryDate'] ?></td>
                                <td><?= $row['DepartmentName'] ?></td>
                            <?php endif; ?>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
