<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Toko Bangunan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            background-image: url('img/IMG_8644.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #1A8724;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: #FFFFFF;
            font-weight: bold;
        }

        .container {
            background: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 8px;
            margin-top: 50px;
            flex-grow: 1;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
        }

        .btn-success:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }

        .table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        .table th, .table td {
            padding: 10px;
            text-align: center;
        }

        .table th {
            background-color: #007bff;
            color: #FFFFFF;
        }

        .table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .table tr:hover {
            background-color: #e9ecef;
        }
    </style>
</head>
<body>
    <header>
        <span>Toko Bangunan by Afif Fauzi</span>
        <a href="logout.php" class="btn btn-danger logout-button">Logout</a>
    </header>
    <div class="container">
        <h1 class="text-center">List Toko Bangunan</h1>
        <?php
        session_start();

        if (isset($_SESSION['success_message'])) {
            echo '<div class="alert alert-success" role="alert">';
            echo $_SESSION['success_message'];
            echo '</div>';
            unset($_SESSION['success_message']);
        }
        ?>
        <div class="row mt-5">
            <div class="d-flex justify-content-between">
                <form action="" method="get" class="d-flex align-items-center">
                    <input class="form-control" placeholder="Cari Data" name="search"/>
                    <select name="search_by" class="form-select">
                        <option value="">Cari Tipe Barang</option>
                        <option value="name">Name</option>
                        <option value="category">Category</option>
                    </select>
                    <button type="submit" class="btn btn-success mx-2">Cari</button>
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
                    <th>Pembeli</th>
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

                $query = "SELECT a.id, a.name, a.price, b.nama, c.nama_pembeli, a.stock, a.created_at
                          FROM products a 
                          LEFT JOIN categories b ON a.id_category = b.id_category
                          LEFT JOIN pembeli c ON a.id_pembeli = c.id_pembeli
                          WHERE a.deleted_at IS NULL";

                if (isset($_GET['search']) && !empty($_GET['search'])) {
                    $search = $_GET['search'];
                    $search_by = $_GET['search_by'];

                    if ($search_by == 'name') {
                        $query .= " AND a.name LIKE '%$search%'";
                    } elseif ($search_by == 'category') {
                        $query .= " AND b.nama LIKE '%$search%'";
                    }
                }

                if (isset($_GET['delete'])) {
                    $delete_id = $_GET['delete'];
                    $delete_query = "UPDATE products SET deleted_at = NOW() WHERE id = $delete_id";
                    if ($conn->query($delete_query) === TRUE) {
                        $_SESSION['success_message'] = "Data berhasil dihapus.";
                        header("Location: index.php");
                        exit();
                    } else {
                        echo "Error: " . $conn->error;
                    }
                }

                $result = $conn->query($query);
                $totalRows = $result->num_rows;

                if ($totalRows > 0) {
                    foreach ($result as $key => $row) {
                        echo "<tr>";
                        echo "<td>".($key + 1)."</td>";
                        echo "<td>".$row['name']."</td>";
                        echo "<td>".$row['price']."</td>";
                        echo "<td>".$row['nama']."</td>";
                        echo "<td>".$row['nama_pembeli']."</td>";
                        echo "<td>".$row['stock']."</td>";
                        echo "<td>".$row['created_at']."</td>";
                        echo "<td><a class='btn btn-sm btn-info' href='update.php?id=$row[id]'>Update</a></td>";
                        echo "<td><a class='btn btn-sm btn-danger' href='index.php?delete=$row[id]'>Delete</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='8' class='text-center'>No Data</td></tr>";
                }

                $db->close();
                ?>
            </table>
        </div>
    </div>
