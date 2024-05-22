<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>List Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <h1 class="text-center mt-5">List Product</h1>
        <div class="row">
            <div class="d-flex justify-content-between">
                <form action="" method="get" class="d-flex">
                    <input class="form-control" placeholder="Cari Data" name="search"/>
                    <select name="search_by">
                        <option value="">Search All</option>
                        <option value="name">Name</option>
                        <option value="category">Category</option>
                    </select>
                    <button type="submit" class="btn btn-success btn-sm">Cari</button>
                </form>
                <a href="insert.php" class="ml-auto mb-2"><button class="btn btn-success">Tambah Data</button></a>
            </div>
            <table class="table">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Category</th>
                    <th>Stock</th>
                    <th>Tgl. Buat</th>
                    <th colspan="2">Pilihan</th>
                </tr>
                </thead>
                <?php
                ini_set('display_errors', '1');
                ini_set('display_startup_errors', '1');
                error_reporting(E_ALL);

                require_once 'config_db.php';

                $db = new ConfigDB();
                $conn = $db->connect();

                $conditional = [];
                if (isset($_GET['search'])) {
                    $conditional['AND name like'] = '%'.$_GET['search'].'%';
                }
                $result = $db->select("products", $conditional);

                if (count($result)) {
                    foreach ($result as $key => $row) {
                        echo "<tr>";
                        echo "<td>".($key + 1)."</td>";
                        echo "<td>".$row['name']."</td>";
                        echo "<td>".$row['price']."</td>";
                        echo "<td>".$row['category']."</td>";
                        echo "<td>".$row['stock']."</td>";
                        echo "<td>".$row['created_at']."</td>";
                        echo "<td><a class='btn btn-sm btn-info' href='update.php?id=$row[id]'>Update</a></td>";
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
