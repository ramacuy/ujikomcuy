<?php
$penjualan = $penjualan ?? [];
$pelangganList = $pelangganList ?? [];
$produkList = $produkList ?? [];
?>

<div class="container mt-5">
    <h2 class="mb-4">Data Penjualan</h2>

    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-info"><?= $_SESSION['message']; unset($_SESSION['message']); ?></div>
    <?php endif; ?>

    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambah">Tambah Penjualan</button>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Total Harga</th>
                    <th>Pelanggan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($penjualan)): $no = 1; foreach ($penjualan as $p): ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= htmlspecialchars($p['TanggalPenjualan']); ?></td>
                        <td>Rp <?= number_format($p['TotalHarga'], 0, ',', '.'); ?></td>
                        <td><?= htmlspecialchars($p['NamaPelanggan']); ?></td>
                        <td>
                            <a href="index.php?page=detail_penjualan&id=<?= $p['PenjualanID']; ?>" class="btn btn-sm btn-info">Detail</a>
                        </td>
                    </tr>
                <?php endforeach; else: ?>
                    <tr><td colspan="5" class="text-center">Tidak ada data penjualan</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Tambah Penjualan -->
<div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form action="index.php?page=penjualan&action=create" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Penjualan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Tanggal Penjualan</label>
                        <input type="date" name="tanggal_penjualan" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Pelanggan</label>
                        <select name="PelangganID" class="form-select" required>
                            <option value="">-- Pilih Pelanggan --</option>
                            <?php foreach ($pelangganList as $pel): ?>
                                <option value="<?= $pel['PelangganID']; ?>"><?= $pel['NamaPelanggan']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <hr>
                    <div id="produk-container">
                        <div class="row mb-2 produk-item">
                            <div class="col-md-5">
                                <select name="ProdukID[]" class="form-select" required>
                                    <option value="">-- Pilih Produk --</option>
                                    <?php foreach ($produkList as $pr): ?>
                                        <option value="<?= $pr['ProdukID']; ?>">
                                            <?= $pr['NamaProduk']; ?> (Stok: <?= $pr['Stok']; ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <input type="number" name="JumlahProduk[]" class="form-control" placeholder="Jumlah" required>
                            </div>
                            <div class="col-md-3">
                                <input type="number" name="Harga[]" class="form-control" placeholder="Harga" required>
                            </div>
                            <div class="col-md-1">
                                <button type="button" class="btn btn-danger remove-produk">&times;</button>
                            </div>
                        </div>
                    </div>
                    <button type="button" id="tambahProduk" class="btn btn-success">+ Produk</button>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="submit">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Template produk item -->
<template id="produk-template">
    <div class="row mb-2 produk-item">
        <div class="col-md-5">
            <select name="ProdukID[]" class="form-select" required>
                <option value="">-- Pilih Produk --</option>
                <?php foreach ($produkList as $pr): ?>
                    <option value="<?= $pr['ProdukID']; ?>"><?= $pr['NamaProduk']; ?> (Stok: <?= $pr['Stok']; ?>)</option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-3">
            <input type="number" name="JumlahProduk[]" class="form-control" placeholder="Jumlah" required>
        </div>
        <div class="col-md-3">
            <input type="number" name="Harga[]" class="form-control" placeholder="Harga" required>
        </div>
        <div class="col-md-1">
            <button type="button" class="btn btn-danger remove-produk">&times;</button>
        </div>
    </div>
</template>

<script>
    document.getElementById("tambahProduk").addEventListener("click", function () {
        const template = document.getElementById("produk-template").content.cloneNode(true);
        document.getElementById("produk-container").appendChild(template);
    });

    document.addEventListener("click", function (e) {
        if (e.target.classList.contains("remove-produk")) {
            e.target.closest(".produk-item").remove();
        }
    });
</script>
