<?php
session_start();
require_once('connect.php');

$errors = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['register'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $sql = "SELECT id FROM users WHERE username=:username";
        $stmt = $connect->prepare($sql);
        $stmt->execute(['username' => $username]);
        $existingUser = $stmt->fetch();

        if ($existingUser) {
            $errors[] = "Ez a felhasználónév már foglalt!";
        }

        if (empty($errors)) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO users (username, password) VALUES (:username, :password)";
            $stmt = $connect->prepare($sql);
            $stmt->execute(['username' => $username, 'password' => $hashed_password]);

            if ($stmt->rowCount() > 0) {
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $username;
                header("Location: index.php");
                exit;
            } else {
                $errors[] = "Hiba történt a regisztráció során.";
            }
        }
    } elseif (isset($_POST['login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM users WHERE username = :username";
        $stmt = $connect->prepare($sql);
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $username;
            header("Location: index.php");
            exit;
        } else {
            $errors[] = "Hibás felhasználónév vagy jelszó!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bejelentkezés és regisztráció</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            max-width: 400px;
            margin: 100px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-label {
            font-weight: bold;
        }

        .btn-primary {
            width: 100%;
        }

        .alert {
            margin-top: 20px;
        }

        .alert li {
            margin-bottom: 5px;
        }
    </style>
</head>
<body>

<div class="container">
    <h1 class="mt-5">Bejelentkezés vagy regisztráció</h1>

    <?php if (!empty($errors)) { ?>
        <div class="alert alert-danger mt-4" role="alert">
            <ul>
                <?php foreach ($errors as $error) { ?>
                    <li><?php echo $error; ?></li>
                <?php } ?>
            </ul>
        </div>
    <?php } ?>

    <form class="mt-4" method="post" action="">
        <div class="mb-3">
            <label for="username" class="form-label">Felhasználónév:</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Jelszó:</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary" name="login">Bejelentkezés</button>
        <button type="submit" class="btn btn-primary" name="register">Regisztráció</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
