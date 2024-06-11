<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
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
            width: 320px; /* Ukuran halaman login */
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
        <h1 class="text-center mt-5">Login</h1>
        <form action="" method="post">
            <div class="form-group mt-5">
                <label for="emailInput">Email</label>
                <input type="email" class="form-control" id="emailInput" name="email" placeholder="Enter Email" required>
            </div>
            <div class="form-group">
                <label for="passwordInput">Password</label>
                <input type="password" class="form-control" id="passwordInput" name="password" placeholder="Enter Password" required>
            </div>
            <div class="mt-5">
                <button type="submit" class="btn btn-primary">Login</button>
                <a href="register.php" class="btn btn-secondary mt-3">Register</a> <!-- Pindahkan ke bawah tombol Login -->
            </div>
        </form>
        <?php
            
            ini_set('display_errors', '1');
            ini_set('display_startup_errors', '1');
            error_reporting(E_ALL);

            session_start();
            if (isset($_SESSION['login'])) {
                header('Location: index.php');
            }

            require_once 'config_db.php';

            $db = new ConfigDB();
            $conn = $db->connect();

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $email = $_POST['email'];
                $password = $_POST['password'];

                $query = "SELECT id, email, full_name, password FROM users WHERE email = '$email'";
                $queryExecute = $conn->query($query);

                if ($queryExecute->num_rows > 0) {
                    $user = $queryExecute->fetch_assoc();
                    $isPasswordMatch = password_verify($password, $user['password']);
                    if ($isPasswordMatch) {
                        setcookie('clientId', $user['id'], time() + 86400, '/');
                        setcookie('clientSecret', hash('sha256', $user['email']), time() + 86400, '/');
                        header('Location: index.php');
                    } else {
                        echo "<div class='alert alert-danger mt-3' role='alert'>User/Password is incorrect</div>";
                    }
                } else {
                    echo "<div class='alert alert-danger mt-3' role='alert'>User/Password is incorrect</div>";
                }
            }
        ?>
    </div>
</body>
</html>
