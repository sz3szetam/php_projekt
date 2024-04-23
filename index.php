<?php
session_start();
require_once('connect.php');

function isLoggedIn() {
    return isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;
}

if (isset($_GET['logout'])) {
    $_SESSION['loggedin'] = false;
    session_destroy();
    header("Location: index.php");
    exit;
}

$errors = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['date'])) {
        $date = $_POST['date'];
        
        // Ellenőrizzük, hogy a felhasználó be van-e jelentkezve
        if (isLoggedIn() && isset($_SESSION['username'])) {
            $user_name = $_SESSION['username'];

            $sql = "INSERT INTO appointments (date, user_name) VALUES (:date, :user_name)";
            $stmt = $connect->prepare($sql);
            $stmt->execute(['date' => $date, 'user_name' => $user_name]);

            if ($stmt->rowCount() > 0) {
                echo "<script>alert('Sikeres időpont foglalás!');</script>";
            } else {
                echo "<script>alert('Hiba történt az időpont foglalása során!');</script>";
            }
        } else {
            echo "<script>alert('Nem vagy bejelentkezve!');</script>";
        }
    } else {
        echo "<script>alert('Hiányzó adatok!');</script>";
    }
}

$sql = "SELECT * FROM available_appointments ORDER BY date";
$result = $connect->query($sql);

?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nyelvvizsga időpont foglalás</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container">
    <h1 class="mt-5">Nyelvvizsga időpont foglalás</h1>

    <?php if (!isLoggedIn()) { ?>
        <p><a href="login.php">Belépés</a></p>
    <?php } else { ?>
        <p><a href="?logout=1">Kilépés</a></p>
        <h2 class="mt-4">Foglalt időpontjaid:</h2>
        
    <?php } ?>

    <h2 class="mt-4">Válassz lefoglalható időpontot:</h2>
    <ul class="list-group mt-3">
        <?php while ($row = $result->fetch(PDO::FETCH_ASSOC)) { ?>
            <li class="list-group-item">
                <?php echo date("Y-m-d H:i", strtotime($row['date'])); ?> 
                <form method="post">
                    <input type="hidden" name="date" value="<?php echo $row['date']; ?>">
                    <button type="submit" class="btn btn-primary btn-sm ml-2">Foglalás</button>
                </form>
            </li>
        <?php } ?>
    </ul>
</div>

</body>
</html>
