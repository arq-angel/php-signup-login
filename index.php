<?php

session_start();

if (isset($_SESSION['user_id'])) {

    $mysqli = require __DIR__ . "/database.php";

    $sql = "SELECT * FROM user
            WHERE id = {$_SESSION['user_id']}";

    $result = $mysqli->query($sql);

    $user = $result->fetch_assoc();
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>

<body>

<h1>Home</h1>

<?php if (isset($user)): ?>
    <p>Hello <?= htmlspecialchars($user['name'])?></p>
    <p><a href="logout.php">Log out</a></p>
<?php else: ?>
    <p><a href="login.php">Log in</a> or <a href="signup.html">sign up</a></p>
<?php endif;?>


</body>
</html>




