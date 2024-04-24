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

if (isset($_POST['delete'])) {
    $id = $_POST['id'];

    $sql = "DELETE FROM booked_appointments WHERE id = :id";
    $stmt = $connect->prepare($sql);
    $stmt->execute(['id' => $id]);

    if ($stmt->rowCount() > 0) {
        echo "<script>alert('Időpont sikeresen törölve!');</script>";
    } else {
        echo "<script>alert('Hiba történt az időpont törlése során!');</script>";
    }
}

if (isset($_POST['modify'])) {
    $id = $_POST['id'];
    $newDate = $_POST['new_date'];

    $sql = "UPDATE booked_appointments SET date = :new_date WHERE id = :id";
    $stmt = $connect->prepare($sql);
    $stmt->execute(['new_date' => $newDate, 'id' => $id]);

    if ($stmt->rowCount() > 0) {
        echo "<script>alert('Időpont sikeresen módosítva!');</script>";
    } else {
        echo "<script>alert('Hiba történt az időpont módosítása során!');</script>";
    }
}

if (isset($_POST['book'])) {
    $date = $_POST['date'];
    
    if (isLoggedIn() && isset($_SESSION['username'])) {
        $user_name = $_SESSION['username'];

        $sql = "INSERT INTO booked_appointments (date, user_name) VALUES (:date, :user_name)";
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
}


$bookedAppointmentsSql = "SELECT * FROM booked_appointments ORDER BY date";
$bookedAppointmentsResult = $connect->query($bookedAppointmentsSql);


$availableAppointmentsSql = "SELECT * FROM available_appointments ORDER BY date";
$availableAppointmentsResult = $connect->query($availableAppointmentsSql);

?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lefoglalt időpontok</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container">
    <h1 class="mt-5">Lefoglalt időpontok</h1>

    <?php if (!isLoggedIn()) { ?>
        <p><a href="login.php">Belépés</a></p>
    <?php } else { ?>
        <p><a href="?logout=1">Kilépés</a></p>
        <h2 class="mt-4">Foglalt időpontjaid:</h2>
        <ul class="list-group mt-3">
            <?php while ($row = $bookedAppointmentsResult->fetch(PDO::FETCH_ASSOC)) { ?>
                <li class="list-group-item">
                    <?php echo date("Y-m-d H:i", strtotime($row['date'])); ?> 
                    <form method="post" style="display: inline;">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <button type="submit" class="btn btn-danger btn-sm ml-2" name="delete">Törlés</button>
                    </form>
                    <button type="button" class="btn btn-primary btn-sm ml-2" data-toggle="modal" data-target="#modifyModal<?php echo $row['id']; ?>">Módosítás</button>
                </li>

                <div class="modal fade" id="modifyModal<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="modifyModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modifyModalLabel">Időpont módosítása</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="post">
                                    <div class="form-group">
                                        <label for="newDate">Új időpont:</label>
                                        <input type="datetime-local" class="form-control" id="newDate" name="new_date" required>
                                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                    </div>
                                    <button type="submit" class="btn btn-primary" name="modify">Mentés</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </ul>

        <h2 class="mt-4">Szabad időpontok:</h2>
        <ul class="list-group mt-3">
            <?php while ($row = $availableAppointmentsResult->fetch(PDO::FETCH_ASSOC)) { ?>
                <li class="list-group-item">
                    <?php echo date("Y-m-d H:i", strtotime($row['date'])); ?> 
                    <form method="post" style="display: inline;">
                        <input type="hidden" name="date" value="<?php echo $row['date']; ?>">
                        <button type="submit" class="btn btn-success btn-sm ml-2" name="book">Foglalás</button>
                    </form>
                </li>
            <?php } ?>
        </ul>
    <?php } ?>
</div>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
