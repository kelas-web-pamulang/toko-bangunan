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
        ini_set('display_errors', '1');
        ini_set('display_startup_errors', '1');
        error_reporting(E_ALL);

        date_default_timezone_set('Asia/Jakarta');
        require_once 'config_db.php';

        $db = new ConfigDB();
        $conn = $db->connect();
        // function checkNum($number) {
                //     if($number>1) {
                //       throw new Exception("Value must be 1 or below");
                //     }
                //     return true;
                //   }
                  
                //   try {
                //       echo checkNum(2);	
                //   } catch (Exception $e) {
                //       echo 'Error : '.$e->getMessage();
                //   }
                      
                //   echo 'Finish';                 
                  //echo $nama;
        $result = [];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $conn->begin_transaction();

            try {
                $name = $_POST['name'];
                $price = $_POST['price'];
                $category = $_POST['id_category'];
                $pembeli = $_POST['id_pembeli'];
                $stock = $_POST['stock'];
                $usedStock = $_POST['used_stock'];
                $returnStock = $_POST['return_stock'];
                $updatedAt = date('Y-m-d H:i:s');

                // Calculate new stock value
                $newStock = $stock + $returnStock - $usedStock;

                // Ensure stock does not go negative
                if ($newStock < 0) {
                    throw new Exception("Stock cannot be negative.");
                }

                $query = "UPDATE products SET name='$name', price='$price', id_category='$category', id_pembeli='$pembeli', stock='$newStock', updated_at='$updatedAt' WHERE id=" . $_GET['id'];

                if ($conn->query($query) === TRUE) {
                    $conn->commit();
                    echo "<div class='alert alert-success mt-3' role='alert'>Data updated successfully</div>";
                } else {
                    $conn->rollback();
                    echo "<div class='alert alert-danger mt-3' role='alert'>Error updating data: " . $conn->error . "</div>";
                }

                $result = $conn->query("SELECT * FROM products WHERE id=" . $_GET['id'])->fetch_assoc();
            } catch (Exception $e) {
                $conn->rollback();
                echo "<div class='alert alert-danger mt-3' role='alert'>Error: " . $e->getMessage() . "</div>";
            }
        } else {
            $result = $conn->query("SELECT * FROM products WHERE id=" . $_GET['id'])->fetch_assoc();
        }
    ?>
    <div class="container">
        <h1 class="text-center mt-5">Ubah Data Barang</h1>
        <form action="" method="post">
            <div class="form-group">
                <label for="nameInput">Nama Barang</label>
                <input type="text" class="form-control" id="nameInput" name="name" placeholder="Enter Name" required value="<?php echo isset($result['name']) ? $result['name'] : '' ?>">
            </div>
            <div class="form-group">
                <label for="priceInput">Harga Barang</label>
                <input type="number" class="form-control" id="priceInput" name="price" placeholder="Enter Price" required value="<?php echo isset($result['price']) ? $result['price'] : '' ?>">
            </div>
            <div class="form-group">
                <label for="categorySelect">Kategori</label>
                <select class="form-control" id="categorySelect" name="id_category" required>
                    <option value="">Pilih Kategori</option>
                    <?php
                        $categories = $conn->query("SELECT id_category, nama FROM categories");
                        while ($row = $categories->fetch_assoc()) {
                            $selected = ($row['id_category'] == $result['id_category']) ? 'selected' : '';
                            echo "<option value='{$row['id_category']}' $selected>{$row['nama']}</option>";
                        }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="pembeliSelect">Nama Pembeli</label>
                <select class="form-control" id="pembeliSelect" name="id_pembeli" required>
                    <option value="">Pilih Nama Pembeli</option>
                    <?php
                        $pembeli = $conn->query("SELECT id_pembeli, nama_pembeli FROM pembeli");
                        while ($row = $pembeli->fetch_assoc()) {
                            $selected = ($row['id_pembeli'] == $result['id_pembeli']) ? 'selected' : '';
                            echo "<option value='{$row['id_pembeli']}' $selected>{$row['nama_pembeli']}</option>";
                        }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="stockInput">Stock</label>
                <input type="number" class="form-control" id="stockInput" name="stock" placeholder="Enter Stock" required readonly value="<?php echo isset($result['stock']) ? $result['stock'] : '' ?>">
            </div>
            <div class="form-group">
                <label for="usedStockInput">Stok Terpakai</label>
                <input type="number" class="form-control" id="usedStockInput" name="used_stock" placeholder="Enter Used Stock" value="0">
            </div>
            <div class="form-group">
                <label for="returnStockInput">Tambah Stok</label>
                <input type="number" class="form-control" id="returnStockInput" name="return_stock" placeholder="Enter Returned Stock" value="0">
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="index.php" class="btn btn-secondary">Kembali</a>
        </form>
        <?php
            $conn->close();
        ?>
    </div>
</body>
</html>
