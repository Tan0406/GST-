<?php
    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "gst restaurant";  

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get and sanitize form data
    $customer_name = $conn->real_escape_string($_POST['customer_name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $reservation_date = $conn->real_escape_string($_POST['reservation_date']);
    $reservation_time = $conn->real_escape_string($_POST['reservation_time']);
    $guests = (int)$_POST['guests'];

    // Prepare SQL statement with proper column names
    $stmt = $conn->prepare("INSERT INTO payments (customer_name, email, phone, reservation_date, reservation_time, guests) 
                          VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssi", $customer_name, $email, $phone, $reservation_date, $reservation_time, $guests);

    if ($stmt->execute()) {
        echo "<script>alert('Reservation complete');</script>";
        echo "<script>window.setTimeout(function(){ window.location.href = 'index.html'; }, 1000);</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
?>