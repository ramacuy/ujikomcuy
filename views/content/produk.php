<?php
$produk = $produk ?? [];
$kategori = $kategori ?? []; // dari controller, berisi enum KategoriProduk
?>

<div class="container mt-5">
    <h2>Daftar Barang</h2>

    <?php if (isset($_SESSION['message'])) : ?>
        <div class="alert alert-info"><?= $_SESSION['message']; ?></div>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>

    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambah">
        Tambah Barang
    </button>

    <div class="table-responsive">
        <table class="table table-bordered table-hover" id="tabel-barang">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th>Stok</th>
                    <th>Harga</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($produk)) : ?>
                    <?php $no = 1; foreach ($produk as $b) : ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= htmlspecialchars($b['NamaProduk'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?= htmlspecialchars($b['KategoriProduk'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?= htmlspecialchars($b['Stok'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td>Rp <?= number_format($b['Harga'], 0, ',', '.'); ?></td>
                            <td>
                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $b['ProdukID']; ?>">Edit</button>
                                <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalHapus<?= $b['ProdukID']; ?>">Hapus</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="6" class="text-center">Data barang tidak ditemukan.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog">
        <form action="index.php?page=produk&action=store" method="POST" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Barang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Nama Barang</label>
                    <input type="text" name="nama" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Kategori</label>
                    <select name="kategori" class="form-control" required>
                        <option value="" disabled selected>Pilih Kategori</option>
                        <?php foreach ($kategori as $k) : ?>
                            <option value="<?= $k ?>"><?= $k ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Stok</label>
                    <input type="number" name="stok" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Harga</label>
                    <input type="number" name="harga" class="form-control" required>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit dan Hapus -->
<?php foreach ($produk as $b) : ?>
    <!-- Modal Edit -->
    <div class="modal fade" id="modalEdit<?= $b['ProdukID']; ?>" tabindex="-1">
        <div class="modal-dialog">
            <form action="index.php?page=produk&action=update" method="POST" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Barang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_produk" value="<?= $b['ProdukID']; ?>">
                    <div class="mb-3">
                        <label class="form-label">Nama Barang</label>
                        <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($b['NamaProduk'], ENT_QUOTES, 'UTF-8'); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <select name="kategori" class="form-control" required>
                            <?php foreach ($kategori as $k) : ?>
                                <option value="<?= $k ?>" <?= ($b['KategoriProduk'] == $k) ? 'selected' : '' ?>><?= $k ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Stok</label>
                        <input type="number" name="stok" class="form-control" value="<?= htmlspecialchars($b['Stok'], ENT_QUOTES, 'UTF-8'); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Harga</label>
                        <input type="number" name="harga" class="form-control" value="<?= htmlspecialchars($b['Harga'], ENT_QUOTES, 'UTF-8'); ?>" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Hapus -->
    <div class="modal fade" id="modalHapus<?= $b['ProdukID']; ?>" tabindex="-1">
        <div class="modal-dialog">
            <form action="index.php?page=produk&action=destroy" method="POST" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Yakin ingin menghapus barang <strong><?= htmlspecialchars($b['NamaProduk'], ENT_QUOTES, 'UTF-8'); ?></strong>?</p>
                    <input type="hidden" name="id_produk" value="<?= $b['ProdukID']; ?>">
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </div>
            </form>
        </div>
    </div>
<?php endforeach; ?>
