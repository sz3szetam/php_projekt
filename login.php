<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bejelentkezés</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0wnVR/y0vNUo/FZi+SLfSkDkYY5imli21Wok/lD2Fo+Q8kGNc0RR1omEeEW0D4W" crossorigin="anonymous">
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
    </style>
</head>
<body>

<div class="container">
    <h1 class="mt-5">Bejelentkezés</h1>
    <form class="mt-4" method="post" action="">
        <div class="mb-3">
            <label for="username" class="form-label">Felhasználónév:</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Jelszó:</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary">Bejelentkezés</button>
    </form>
    <?php if (!empty($errors)) { ?>
        <div class="alert alert-danger mt-4" role="alert">
            <?php foreach ($errors as $error) { ?>
                <p><?php echo $error; ?></p>
            <?php } ?>
        </div>
    <?php } ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-n2+3pPKobq5a2cZer6cf0ZgU6Pz7WP2gDycyruoIq6B+uIjXUrbwlsR2zPkXJd19" crossorigin="anonymous"></script>
</body>
</html>
