<?php

$is_invalid = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $mysqli = require_once __DIR__ . "/database.php";

    $sql = sprintf("SELECT * FROM user 
                        WHERE email = '%s'",
                        $mysqli->real_escape_string($_POST['email']));

    $result = $mysqli->query($sql);

    $user = $result->fetch_assoc();

    if ($user) {
        if (password_verify($_POST['password'], $user['password_hash'])) {

            session_start();

            session_regenerate_id();

            $_SESSION['user_id'] = $user['id'];

            header("Location: index.php");
            exit;

        }
    }

    $is_invalid = true;

}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>
<body>

<h1>Login</h1>

<?php if ($is_invalid): ?>
    <em>Invalid login</em>
<?php endif; ?>


<form action="" method="post">

    <div>
        <label for="email">Email</label>
        <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($_POST['email'] ?? '') ?>">
    </div>

    <div>
        <label for="password">Password</label>
        <input type="password" name="password" id="password">
    </div>

    <button>Login</button>

</form>

</body>
</html>




