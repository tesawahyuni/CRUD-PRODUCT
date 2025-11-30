<?php
require_once "../src/ProductRepository.php";
$repo = new ProductRepository();
$products = $repo->getAll();
?>
<link rel="stylesheet" href="style.css">

<div class="container">
    <h2>📦 Daftar Produk</h2>

    <!-- TOMBOL TAMBAH PRODUK -->
    <div style="text-align:right; margin-bottom:15px;">
        <a href="/create.php" class="button" style="background:#28a745; padding:8px 14px;">
            + Tambah Produk
        </a>
    </div>

    <table>
        <tr>
            <th>ID</th>
            <th>Produk</th>
            <th>Kategori</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Gambar</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>

        <?php foreach ($products as $p): ?>
        <tr>
            <td><?= $p['id'] ?></td>
            <td><?= $p['name'] ?></td>
            <td><?= $p['category'] ?></td>
            <td>Rp <?= number_format($p['price'],0,',','.') ?></td>
            <td><?= $p['stock'] ?></td>

            <td>
                <?php if ($p['image_path']): ?>
                    <img src="<?= $p['image_path'] ?>" width="55" style="border-radius:10px;">
                <?php endif; ?>
            </td>

            <td>
                <span style="
                    padding:6px 10px;
                    border-radius:8px;
                    color:white;
                    background:<?= $p['status']=='active'?'#28a745':'#dc3545' ?>;">
                    <?= $p['status'] ?>
                </span>
            </td>

            <td>
                <!-- DETAIL -->
                <a href="/detail.php?id=<?= $p['id'] ?>" class="button" style="background:#007bff;">
                    Detail
                </a>

                <!-- EDIT -->
                <a href="/edit.php?id=<?= $p['id'] ?>" class="button" style="background:orange;">
                    Edit
                </a>

                <!-- DELETE -->
                <a href="/delete.php?id=<?= $p['id'] ?>"
                    class="button"
                    style="background:red;"
                    onclick="return confirm('Yakin ingin menghapus?')">
                    Delete
                </a>

            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>

