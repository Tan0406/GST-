<?php
// Start session for authentication
session_start();

// Redirect to login if not authenticated
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}

// Database connection
$servername = "localhost";
$username = "root"; // Change to your MySQL username
$password = ""; // Change to your MySQL password
$dbname = "gst restaurant";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query payments table
$sql = "SELECT id, customer_name, email, phone, reservation_date, reservation_time, guests FROM payments";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Management</title>
    <link rel="stylesheet" href="admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="admin-container">
        <aside class="sidebar">
            <div class="sidebar-header">
                <h2><i class="fas fa-utensils"></i> GST Restaurant</h2>
            </div>
            <div class="sidebar-menu">
                <ul>
                    <li><a href="admin.php" class="active"><i class="fas fa-tachometer-alt"></i> <span>Dashboard</span></a></li>
                    <li><a href="data.php"><i class="fas fa-database"></i> <span>Reservations</span></a></li>
                    <li><a href="#"><i class="fas fa-cog"></i> <span>Settings</span></a></li>
                </ul>
            </div>
        </aside>

        <main class="main-content">
            <nav class="navbar">
                <div class="menu-toggle">
                    <i class="fas fa-bars"></i>
                </div>
                <div class="user-info">
                    <img src="https://via.placeholder.com/40" alt="User">
                    <span>Admin</span>
                </div>
            </nav>

            <div class="content-area">
                <div class="page-header">
                    <h2>Reservation Management</h2>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3>All Reservations</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Guests</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Counter for serial numbers
                                    $serialNumber = 1;

                                    // Check if there are any rows returned
                                    if ($result->num_rows > 0) {
                                        // Output data of each row
                                        while($row = $result->fetch_assoc()) {
                                            echo "<tr>";
                                            echo "<td>".$serialNumber."</td>";
                                            echo "<td>".htmlspecialchars($row["customer_name"])."</td>";
                                            echo "<td>".htmlspecialchars($row["email"])."</td>";
                                            echo "<td>".htmlspecialchars($row["phone"])."</td>";
                                            echo "<td>".htmlspecialchars($row["reservation_date"])."</td>";
                                            echo "<td>".htmlspecialchars($row["reservation_time"])."</td>";
                                            echo "<td>".htmlspecialchars($row["guests"])."</td>";
                                            echo "</tr>";
                                            $serialNumber++;
                                        }
                                    } else {
                                        echo "<tr><td colspan='7'>No reservations found</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="app.js"></script>
</body>
</html>
<?php $conn->close(); ?>