<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>List Product</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="text-center mt-5">List Product</h1>
        <div class="row">
            <a href="insert.php" class="ml-auto mb-2"><button class="btn btn-success">Tambah Data</button></a>
            <table class="table">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Category</th>
                    <th>Stock</th>
                    <th>Tgl. Buat</th>
                </tr>
                </thead>
                <?php
                ini_set('display_errors', '1');
                ini_set('display_startup_errors', '1');
                error_reporting(E_ALL);

                require_once 'config_db.php';

                $db = new ConfigDB();
                $conn = $db->connect();

                $result = $db->select("products");
                if (count($result)) {
                    foreach ($result as $key => $row) {
                        echo "<tr>";
                        echo "<td>".($key + 1)."</td>";
                        echo "<td>".$row['name']."</td>";
                        echo "<td>".$row['price']."</td>";
                        echo "<td>".$row['category']."</td>";
                        echo "<td>".$row['stock']."</td>";
                        echo "<td>".$row['created_at']."</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6' class='text-center'>No Data</td></tr>";
                }

                $db->close();
                ?>
            </table>
        </div>
    </div>
</body>
</html>
