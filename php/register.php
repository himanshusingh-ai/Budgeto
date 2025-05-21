<?php
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Check if user already exists
    $check_sql = "SELECT * FROM users WHERE email = ?";
    $stmt_check = $conn->prepare($check_sql);
    $stmt_check->bind_param("s", $email);
    $stmt_check->execute();
    $result = $stmt_check->get_result();

    if ($result->num_rows > 0) {
        echo "User already exists!";
    } else {
        $sql = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss",$name, $email, $hashed_password);

        if ($stmt->execute()) {
            header("Location: ../login.html?success=registered");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
    }
}
?>
