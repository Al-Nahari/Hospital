<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add'])) {
        $name = $_POST['name'];
        $quantity = $_POST['quantity'];
        $expiry = $_POST['expiry'];
        $department = $_POST['department'];

        $sql = "INSERT INTO Inventory (Name, Quantity, ExpiryDate, DepartmentID) 
                VALUES ('$name', $quantity, '$expiry', $department)";
        $conn->query($sql);
    } elseif (isset($_POST['delete'])) {
        $id = $_POST['id'];
        $sql = "DELETE FROM Inventory WHERE ItemID = $id";
        $conn->query($sql);
    }
}

$departments = $conn->query("SELECT * FROM Departments");
$result = $conn->query("SELECT * FROM Inventory");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Inventory</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h1 class="text-center mb-4">Manage Inventory</h1>
        <form method="post" class="mb-4">
            <div class="row g-3">
                <div class="col-md-4">
                    <input type="text" name="name" class="form-control" placeholder="Item Name" required>
                </div>
                <div class="col-md-2">
                    <input type="number" name="quantity" class="form-control" placeholder="Quantity" required>
                </div>
                <div class="col-md-3">
                    <input type="date" name="expiry" class="form-control" placeholder="Expiry Date">
                </div>
                <div class="col-md-3">
                    <select name="department" class="form-select" required>
                        <option value="">Select Department</option>
                        <?php while ($row = $departments->fetch_assoc()) : ?>
                            <option value="<?= $row['DepartmentID'] ?>"><?= $row['Name'] ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col-12 text-center">
                    <button type="submit" name="add" class="btn btn-primary">Add Item</button>
                </div>
            </div>
        </form>
        <h2 class="mb-3">Inventory List</h2>
        <table class="table table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Quantity</th>
                    <th>Expiry Date</th>
                    <th>Department</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) : ?>
                    <tr>
                        <td><?= $row['ItemID'] ?></td>
                        <td><?= $row['Name'] ?></td>
                        <td><?= $row['Quantity'] ?></td>
                        <td><?= $row['ExpiryDate'] ?></td>
                        <td><?= $row['DepartmentID'] ?></td>
                        <td>
                            <form method="post" class="d-inline">
                                <input type="hidden" name="id" value="<?= $row['ItemID'] ?>">
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
