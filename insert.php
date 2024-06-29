<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Masukan data</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <?php
        ini_set('display_errors', '1');
        ini_set('display_startup_errors', '1');
        error_reporting(E_ALL);

        require_once 'config_db.php';

        $db = new ConfigDB();
        $conn = $db->connect();
    ?>
    <div class="container">
        <h1 class="text-center mt-5">Masukan Data</h1>
        <form action="" method="post">
            <div class="form-group">
                <label for="nameInput">Nama Barang</label>
                <input type="text" class="form-control" id="nameInput" name="name" placeholder="Enter Name" required>
            </div>
            <div class="form-group">
                <label for="nameInput">Harga Barang</label>
                <input type="number" class="form-control" id="nameInput" name="price" placeholder="Enter Price" required>
            </div>
            <div class="form-group">
                <label for="nameInput">Category</label>
                <?php
                    $nameInput = $conn->query("SELECT id_category, nama FROM categories");
                    echo "<select class='form-control id='nameInput' name='id_category' required>";
                    echo "<option value=''>Pilih Category</option>";
                    while ($row = $nameInput->fetch_assoc()) {
                        echo "<option value='{$row['id_category']}'>{$row['nama']}</option>";
                    }
                    echo "</select>";
                ?>
            </div>
            <div class="form-group">
                <label for="nameInput">Nama Pemasok</label>
                <?php
                    $nameInput = $conn->query("SELECT id_pembeli, nama_pembeli FROM pembeli");
                    echo "<select class='form-control id='nameInput' name='id_pembeli' required>";
                    echo "<option value=''>Pilih Nama Pembeli</option>";
                    while ($row = $nameInput->fetch_assoc()) {
                        echo "<option value='{$row['id_pembeli']}'>{$row['nama_pembeli']}</option>";
                    }
                    echo "</select>";
                ?>
            </div>
            <div class="form-group">
                <label for="nameInput">Stock</label>
                <input type="number" class="form-control" id="nameInput" name="stock" placeholder="Enter Stock" required>
            </div>
            <button type="submit" class="btn btn-primary">Tambah</button>
                    <a href="index.php" class="btn btn-secondary">Kembali</a>
        </form>

        <?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $name = $_POST['name'];
                $price = $_POST['price'];
                $category = $_POST['id_category'];
                $pembeli = $_POST['id_pembeli'];
                $stock = $_POST['stock'];
                $createAt = date('Y-m-d H:i:s');

                $query = "INSERT INTO products (name, price, id_category, id_pembeli, stock, created_at) 
                         VALUES ('$name', '$price', '$category', '$pembeli', '$stock', '$createAt')";

                if ($conn->query($query) === TRUE) {
                    echo "<div class='alert alert-success mt-3' role='alert'>Data inserted successfully</div>";
                } else {
                    echo "<div class='alert alert-danger mt-3' role='alert'>Error: " . $query . "<br>" . $conn->error . "</div>";
                }
            }
            $conn->close();
        ?>
    </div>
</body>
</html>