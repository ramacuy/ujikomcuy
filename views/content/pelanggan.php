<?php
$pelanggan = $pelanggan ?? [];
?>

<div class="container mt-5">
    <h2>Daftar Supplier</h2>

    <!-- Notification -->
    <?php if (isset($_SESSION['message'])) : ?>
        <div class="alert alert-info"><?= $_SESSION['message']; ?></div>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>

    <!-- Add Button -->
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambah">
        Tambah Supplier
    </button>

    <!-- Supplier Table -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover" id="tabel-supplier">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Nama Supplier</th>
                    <th>Kontak</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($pelanggan)) : ?>
                    <?php $no = 1; foreach ($pelanggan as $p) : ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= htmlspecialchars($p['NamaPelanggan'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?= htmlspecialchars($p['Alamat'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?= htmlspecialchars($p['NomorTelepon'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td>
                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $p['PelangganID']; ?>">
                                    Edit
                                </button>
                                <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalHapus<?= $p['PelangganID']; ?>">
                                    Hapus
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="7" class="text-center">Data supplier tidak ditemukan.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Add Supplier Modal -->
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Supplier</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="index.php?page=pelanggan&action=store" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Nama Supplier</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <textarea name="alamat" class="form-control"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">nomor telepon</label>
                        <input type="text" name="nomortelepon" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit & Delete Modals -->
<?php foreach ($pelanggan as $p) : ?>
    <!-- Edit Supplier Modal -->
    <div class="modal fade" id="modalEdit<?= $p['PelangganID']; ?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Supplier</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="index.php?page=supplier&action=update" method="POST">
                        <input type="hidden" name="id_supplier" value="<?= $p['PelangganID']; ?>">
                        <div class="mb-3">
                            <label class="form-label">Nama Supplier</label>
                            <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($p['NamaPelanggan'], ENT_QUOTES, 'UTF-8'); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kontak</label>
                            <input type="text" name="kontak" class="form-control" value="<?= htmlspecialchars($p['Alamat'], ENT_QUOTES, 'UTF-8'); ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <textarea name="alamat" class="form-control"><?= htmlspecialchars($p['NomorTelepon'], ENT_QUOTES, 'UTF-8'); ?></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Supplier Modal -->
    <div class="modal fade" id="modalHapus<?= $p['PelangganID']; ?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Yakin ingin menghapus supplier <strong><?= htmlspecialchars($p['NamaPelanggan'], ENT_QUOTES, 'UTF-8'); ?></strong>?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form action="index.php?page=supplier&action=destroy" method="POST">
                        <input type="hidden" name="id_supplier" value="<?= $p['PelangganID']; ?>">
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>
