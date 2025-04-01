<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<?php
// Ensure the suppliers variable is available
$suppliers = $suppliers ?? [];
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
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Nama Supplier</th>
                    <th>Kontak</th>
                    <th>Alamat</th>
                    <th>Telepon</th>
                    <th>Email</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($suppliers)) : ?>
                    <?php $no = 1; foreach ($suppliers as $supplier) : ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= htmlspecialchars($supplier['nama_supplier'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?= htmlspecialchars($supplier['kontak'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?= htmlspecialchars($supplier['alamat'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?= htmlspecialchars($supplier['telepon'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?= htmlspecialchars($supplier['email'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td>
                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $supplier['supplier_id']; ?>">
                                    Edit
                                </button>
                                <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalHapus<?= $supplier['supplier_id']; ?>">
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
                <form action="index.php?page=supplier&action=tambah" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Nama Supplier</label>
                        <input type="text" name="nama_supplier" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kontak</label>
                        <input type="text" name="kontak" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <textarea name="alamat" class="form-control"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Telepon</label>
                        <input type="text" name="telepon" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit & Delete Modals -->
<?php foreach ($suppliers as $supplier) : ?>
    <!-- Edit Supplier Modal -->
    <div class="modal fade" id="modalEdit<?= $supplier['supplier_id']; ?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Supplier</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="index.php?page=supplier&action=edit" method="POST">
                        <input type="hidden" name="supplier_id" value="<?= $supplier['supplier_id']; ?>">
                        <div class="mb-3">
                            <label class="form-label">Nama Supplier</label>
                            <input type="text" name="nama_supplier" class="form-control" value="<?= htmlspecialchars($supplier['nama_supplier'], ENT_QUOTES, 'UTF-8'); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kontak</label>
                            <input type="text" name="kontak" class="form-control" value="<?= htmlspecialchars($supplier['kontak'], ENT_QUOTES, 'UTF-8'); ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <textarea name="alamat" class="form-control"><?= htmlspecialchars($supplier['alamat'], ENT_QUOTES, 'UTF-8'); ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Telepon</label>
                            <input type="text" name="telepon" class="form-control" value="<?= htmlspecialchars($supplier['telepon'], ENT_QUOTES, 'UTF-8'); ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($supplier['email'], ENT_QUOTES, 'UTF-8'); ?>">
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Supplier Modal -->
    <div class="modal fade" id="modalHapus<?= $supplier['supplier_id']; ?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Yakin ingin menghapus supplier <strong><?= htmlspecialchars($supplier['nama_supplier'], ENT_QUOTES, 'UTF-8'); ?></strong>?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form action="index.php?page=supplier&action=delete" method="POST">
                        <input type="hidden" name="supplier_id" value="<?= $supplier['supplier_id']; ?>">
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
