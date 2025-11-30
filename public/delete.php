<?php
require_once "../src/ProductRepository.php";

if (!isset($_GET['id'])) {
    header("Location: /index.php");
    exit;
}

$id = $_GET['id'];

$repo = new ProductRepository();
$deleteSuccess = $repo->delete($id);
?>
<link rel="stylesheet" href="style.css">

<div class="delete-container">
    <div class="delete-card">
        <?php if ($deleteSuccess): ?>
            <div class="delete-icon">✔</div>
            <h2>Produk Berhasil Dihapus</h2>
            <p>Produk telah dihapus dari sistem.</p>
        <?php else: ?>
            <div class="delete-icon" style="color: #dc3545;">✖</div>
            <h2 style="color:#dc3545;">Gagal Menghapus Produk</h2>
            <p>Terjadi kesalahan saat menghapus produk.</p>
        <?php endif; ?>
        <a href="/index.php" class="back-button">← Kembali ke Daftar Produk</a>
    </div>
</div>
