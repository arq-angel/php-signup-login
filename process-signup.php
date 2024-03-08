<?php

if (empty($_POST['name'])) {
    die('Name is required');
}

if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    die('Valid email is required');
};

if (strlen($_POST['password']) < 8) {
    die('Password must be at least 8 characters');
}

if (! preg_match("/[a-z]/i", $_POST['password'])) {
    die('Password must contain at least one letter');
}

if (! preg_match("/[0-9]/i", $_POST['password'])) {
    die('Password must contain at least one number');
}

if ($_POST['password']  !== $_POST['password_confirmation']) {
    die('Passwords must match');
}

$password_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);


$mysqli = require_once __DIR__ . "/database.php";

// Check if the $mysqli object was created successfully
if (!$mysqli) {
    die("Connection error: " . mysqli_connect_error());
}

$sql = "INSERT INTO user (name, email, password_hash)
        VALUES (?, ?, ?)";

$stmt = $mysqli->stmt_init();

try {
    if (!$stmt->prepare($sql)) {
        throw new mysqli_sql_exception("SQL error: " . $mysqli->error, $mysqli->errno);
    }

    // Assuming $password_hash is calculated somewhere in your code
    $password_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt->bind_param("sss", $_POST['name'], $_POST['email'], $password_hash);

    if ($stmt->execute()) {

        header("Location: signup-success.html");
        exit;

    } else {
        if ($mysqli->errno === 1062) {
            throw new mysqli_sql_exception("Email already taken", $mysqli->errno);
        } else {
            throw new mysqli_sql_exception($mysqli->error, $mysqli->errno);
        }
    }
} catch (mysqli_sql_exception $e) {
    die($e->getMessage() . " " . $e->getCode());
} finally {
    $stmt->close();
    $mysqli->close();
}



//
//echo "<pre>";
//print_r($_POST);
//echo "</pre>";
//
//var_dump($password_hash);
