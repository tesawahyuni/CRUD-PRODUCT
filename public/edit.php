<?php
require_once "../src/ProductRepository.php";

$repo = new ProductRepository();
$data = $repo->getById($_GET['id']);

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // === VALIDASI TEKS ===
    if (empty($_POST['name']) || strlen($_POST['name']) < 2) {
        $errors[] = "Nama minimal 2 karakter.";
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

    // Default: gambar lama
    $imagePath = $data['image_path'];

    // === HANDLE UPLOAD GAMBAR BARU JIKA ADA ===
    if ($_FILES['image']['error'] == 0) {

        $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
        $maxSize = 2 * 1024 * 1024;

        if (!in_array($_FILES['image']['type'], $allowedTypes)) {
            $errors[] = "File harus JPG atau PNG.";
        }

        if ($_FILES['image']['size'] > $maxSize) {
            $errors[] = "Ukuran file maksimal 2MB.";
        }

        if (empty($errors)) {
            // Nama file dinormalisasi
            $cleanName = preg_replace("/[^A-Za-z0-9\._-]/", "_", $_FILES["image"]["name"]);
            $fileName = time() . "_" . $cleanName;

            $newPath = "uploads/" . $fileName;

            // Upload file
            if (move_uploaded_file($_FILES['image']['tmp_name'], $newPath)) {
                $imagePath = $newPath; // replace gambar lama dengan baru
            } else {
                $errors[] = "Gagal upload gambar baru.";
            }
        }
    }

    // === UPDATE KE DATABASE JIKA TIDAK ADA ERROR ===
    if (empty($errors)) {
        $product = new Product(
            $_POST['name'],
            $_POST['category'],
            $_POST['price'],
            $_POST['stock'],
            $imagePath, // ini gambar lama atau baru
            $_POST['status'],
            $_GET['id']
        );

        $repo->update($product);
        header("Location: index.php");
        exit;
    }
}
?>

<link rel="stylesheet" href="style.css">

<div class="container">
    <h2>Edit Produk</h2>

    <?php if (!empty($errors)): ?>
        <div class="error-box">
            <ul>
                <?php foreach ($errors as $e): ?>
                    <li><?= $e ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="" method="POST" enctype="multipart/form-data">
        Nama Produk:
        <input type="text" name="name" value="<?= $data['name'] ?>" required>

        Kategori:
        <input type="text" name="category" value="<?= $data['category'] ?>" required>

        Harga:
        <input type="number" name="price" value="<?= $data['price'] ?>" required>

        Stok:
        <input type="number" name="stock" value="<?= $data['stock'] ?>" required>

        Gambar Lama:<br>
        <img src="<?= $data['image_path'] ?>" width="100" style="border-radius:8px; margin:5px 0;"><br>

        Upload Gambar Baru (opsional):
        <input type="file" name="image">

        Status:
        <select name="status">
            <option value="active" <?= $data['status']=='active'?'selected':'' ?>>Active</option>
            <option value="inactive" <?= $data['status']=='inactive'?'selected':'' ?>>Inactive</option>
        </select>

        <button type="submit">Update</button>
    </form>
</div>
