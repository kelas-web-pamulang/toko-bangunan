<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            background-image: url('img/2234.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
            padding: 0;
        }

        .container {
            background: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            width: 320px; /* Ukuran halaman register */
        }

        .form-group {
            margin-bottom: 20px;
        }

        .btn-primary {
            width: 100%;
        }

        .btn-secondary {
            width: 100%;
        }

        .alert {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center mt-5">Register Page</h1>
        <form action="" method="post">
            <div class="form-group mt-5">
                <label for="nameInput">Name</label>
                <input type="text" class="form-control" id="nameInput" name="name" placeholder="Enter Name" required>
            </div>
            <div class="form-group">
                <label for="emailInput">Email</label>
                <input type="email" class="form-control" id="emailInput" name="email" placeholder="Enter Email" required>
            </div>
            <div class="form-group">
                <label for="passwordInput">Password</label>
                <input type="password" class="form-control" id="passwordInput" name="password" placeholder="Enter Password" required>
            </div>
            <div class="mt-4">
            <button type="submit" class="btn btn-primary">Register</button>
            <a href="login.php" class="btn btn-secondary mt-3">Login</a>
            </div>
        </form>
        <?php
         ini_set('display_errors', '1');
         ini_set('display_startup_errors', '1');
         error_reporting(E_ALL);

         require_once 'config_db.php';

         $db = new ConfigDB();
         $conn = $db->connect();

         if ($_SERVER['REQUEST_METHOD'] == 'POST') {
             $name = $_POST['name'];
             $email = $_POST['email'];
             $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
             $createAt = date('Y-m-d H:i:s');

             $query = "INSERT INTO users (email, full_name, password, role, created_at) VALUES ('$email', '$name', '$password', 'admin', '$createAt')";
             $queryExecute = $conn->query($query);


             if ($queryExecute) {
                 echo "<div class='alert alert-success mt-3' role='alert'>Register berhasil silahkan login!</div>";
             } else {
                 echo "<div class='alert alert-danger mt-3' role='alert'>Error: " . $query . "<br>" . $conn->error . "</div>";
             }
         }
            // PHP code untuk proses registrasi dan pesan kesalahan
        ?>
    </div>
</body>
</html>
