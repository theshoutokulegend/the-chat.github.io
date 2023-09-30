<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $securityCode = $_POST["security_code"];

    if ($securityCode !== getenv('SECRET')) {
        echo '<script>alert("Invalid email address"); window.location.href = "index.php";</script>';
        exit();
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Check if the username already exists
    $users = [];
    if (file_exists("users.json")) {
        $users = json_decode(file_get_contents("users.json"), true);
        foreach ($users as $user) {
            if ($user["username"] === $username) {
                echo '<script>alert("Username already exists. Please choose a different username."); window.location.href = "index.php";</script>';
                exit();
            }
        }
    }

    // Store user information in users.json
    $users[] = [
        "username" => $username,
        "password" => $hashedPassword
    ];
    file_put_contents("users.json", json_encode($users));

    // Redirect to the login page with success message
    header("Location: index.php?message=signup_success");
    exit();
}
?>