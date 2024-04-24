<?php
session_start();
require_once('connect.php');

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: index.php");
    exit;
}

$errors = array();

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $appointment_id = $_GET['id'];
    
    
    if (isset($_SESSION['email']) && !empty($_SESSION['email'])) {
        $email = $_SESSION['email'];
        
      
        $sql = "SELECT id FROM appointments WHERE id = $appointment_id AND email = '$email'";
        $result = $connect->query($sql);
        
        if ($result->rowCount() == 1) {
            $sql_delete = "DELETE FROM appointments WHERE id = $appointment_id";
            if ($connect->query($sql_delete) === TRUE) {
                header("Location: index.php");
                exit;
            } else {
                $errors[] = "Hiba történt az időpont törlése során: " . $connect->error;
            }
        } else {
            $errors[] = "Nincs jogosultsága ehhez az időponthoz.";
        }
    } else {
        $errors[] = "Hiba történt az email cím lekérdezése során.";
    }
} else {
    $errors[] = "Érvénytelen kérés.";
}
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Időpont törlése</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container">
    <h1 class="mt-5">Időpont törlése</h1>

    <?php if (!empty($errors)) { ?>
        <div class="alert alert-danger mt-4" role="alert">
            <ul>
                <?php foreach ($errors as $error) { ?>
                    <li><?php echo $error; ?></li>
                <?php } ?>
            </ul>
        </div>
    <?php } ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
