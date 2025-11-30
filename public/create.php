<?php 
require_once "../src/ProductRepository.php";

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // VALIDASI INPUT
    if (empty($_POST['name']) || strlen($_POST['name']) < 2) {
        $errors[] = "Nama produk minimal 2 karakter.";
    }

    if (empty($_POST['category'])) {
        $errors[] = "Kategori tidak boleh kosong.";
    }

    if (!is_numeric($_POST['price']) || $_POST['price'] < 0) {
        $errors[] = "Harga harus angka dan tidak negatif.";
    }

    if (!is_numeric($_POST['stock']) || $_POST['stock'] < 0) {
        $errors[] = "Stok harus angka dan tidak negatif.";
    }

    $validStatus = ["active", "inactive"];
    if (!in_array($_POST['status'], $validStatus)) {
        $errors[] = "Status tidak valid.";
    }

    // VALIDASI FILE
    if ($_FILES['image']['error'] == 0) {

        $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
        $maxSize = 2 * 1024 * 1024;

        if (!in_array($_FILES['image']['type'], $allowedTypes)) {
            $errors[] = "File harus JPG/PNG.";
        }

        if ($_FILES['image']['size'] > $maxSize) {
            $errors[] = "Ukuran file maksimal 2MB.";
        }

        // UPLOAD FILE (hanya sekali)
        if (empty($errors)) {
            $cleanName = preg_replace("/[^A-Za-z0-9\._-]/", "_", $_FILES["image"]["name"]);
            $fileName = time() . "_" . $cleanName;
            $uploadPath = "uploads/" . $fileName;

            if (!move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
                $errors[] = "Gagal upload gambar.";
            }
        }

    } else {
        $errors[] = "Gambar wajib diupload.";
    }


    // INSERT DATA KE DATABASE
    if (empty($errors)) {

        $product = new Product(
            $_POST['name'],
            $_POST['category'],
            $_POST['price'],
            $_POST['stock'],
            $uploadPath,
            $_POST['status']
        );

        $repo = new ProductRepository();
        $repo->create($product);

        header("Location: index.php");
        exit;
    }
}
?>

<link rel="stylesheet" href="style.css">

<div class="container">
    <h2>➕ Tambah Produk</h2>

    <?php if (!empty($errors)): ?>
        <div class="error-box">
            <ul>
            <?php foreach ($errors as $err): ?>
                <li><?= $err ?></li>
            <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="" method="POST" enctype="multipart/form-data">
        <label>Nama Produk:</label>
        <input type="text" name="name">

        <label>Kategori:</label>
        <input type="text" name="category">

        <label>Harga:</label>
        <input type="number" name="price">

        <label>Stok:</label>
        <input type="number" name="stock">

        <label>Gambar Produk:</label>
        <input type="file" name="image">

        <label>Status:</label>
        <select name="status">
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
        </select>

        <button type="submit">Simpan Produk</button>
    </form>
</div>
