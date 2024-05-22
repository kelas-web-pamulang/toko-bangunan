<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Update Data</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <?php
        require_once 'config_db.php';

        $db = new ConfigDB();
        $conn = $db->connect();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'];
            $price = $_POST['price'];
            $category = $_POST['category'];
            $stock = $_POST['stock'];

            $query = $db->update('products', [
                'name' => $name,
                'price' => $price,
                'category' => $category,
                'stock' => $stock
            ], $_GET['id']);

            if ($query) {
                echo "<div class='alert alert-success mt-3' role='alert'>Data updated successfully</div>";
            } else {
                echo "<div class='alert alert-danger mt-3' role='alert'>Error: " . $query . "<br>" . $conn->error . "</div>";
            }
            $result = $db->select("products", ['AND id=' => $_GET['id']]);
        } else {
            $result = $db->select("products", ['AND id=' => $_GET['id']]);
        }
    ?>
    <div class="container">
        <h1 class="text-center mt-5">Ubah Data</h1>
        <form action="" method="post">
            <div class="form-group">
                <label for="nameInput">Name</label>
                <input type="text" class="form-control" id="nameInput" name="name" placeholder="Enter Name" required value="<?php echo $result[0]['name'] ?>">
            </div>
            <div class="form-group">
                <label for="nameInput">Price</label>
                <input type="number" class="form-control" id="nameInput" name="price" placeholder="Enter Price" required value="<?php echo $result[0]['price'] ?>">
            </div>
            <div class="form-group">
                <label for="nameInput">Category</label>
                <input type="text" class="form-control" id="nameInput" name="category" placeholder="Enter Category" required value="<?php echo $result[0]['category'] ?>">
            </div>
            <div class="form-group">
                <label for="nameInput">Stock</label>
                <input type="number" class="form-control" id="nameInput" name="stock" placeholder="Enter Stock" required value="<?php echo $result[0]['stock'] ?>">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
            <a href="index.php" class="btn btn-info">Kembali</a>
        </form>

        <?php

            $conn->close();
        ?>
    </div>
</body>
</html>