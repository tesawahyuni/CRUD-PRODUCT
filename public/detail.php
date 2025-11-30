<?php
require_once "../src/ProductRepository.php";

$repo = new ProductRepository();

// Validasi ID ada atau tidak
if (!isset($_GET['id'])) {
    die("ID produk tidak ditemukan.");
}

$data = $repo->getById($_GET['id']);

if (!$data) {
    die("Produk tidak ditemukan.");
}
?>

<link rel="stylesheet" href="style.css">

<div class="container">
    <h2>Detail Produk</h2>

    <div class="detail-card">
        <img src="<?= $data['image_path'] ?>" class="detail-image">

        <div class="detail-info">
            <h3><?= htmlspecialchars($data['name']) ?></h3>
            <p><strong>Kategori:</strong> <?= htmlspecialchars($data['category']) ?></p>
            <p><strong>Harga:</strong> Rp <?= number_format($data['price'], 0, ',', '.') ?></p>
            <p><strong>Stok:</strong> <?= $data['stock'] ?></p>
            <p><strong>Status:</strong> 
                <span class="status <?= $data['status'] ?>">
                    <?= ucfirst($data['status']) ?>
                </span>
            </p>

            <a href="index.php" class="btn-back">← Kembali</a>
        </div>
    </div>
</div>

<style>
.detail-card {
    display: flex;
    gap: 20px;
    background: #fff;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    margin-top: 20px;
}

.detail-image {
    width: 200px;
    height: 200px;
    border-radius: 12px;
    object-fit: cover;
    border: 2px solid #ddd;
}

.detail-info h3 {
    margin-top: 0;
    margin-bottom: 10px;
    font-size: 22px;
}

.status.active {
    color: green;
    font-weight: bold;
}

.status.inactive {
    color: red;
    font-weight: bold;
}

.btn-back {
    margin-top: 15px;
    display: inline-block;
    padding: 8px 16px;
    background: #444;
    color: #fff;
    border-radius: 6px;
    text-decoration: none;
}

.btn-back:hover {
    background: #000;
}
</style>
