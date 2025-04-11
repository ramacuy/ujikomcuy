<div class="container mt-5">
    <h2>Data Detail Penjualan</h2>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Nama Produk</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($details)) : $no = 1; ?>
                    <?php foreach ($details as $d) : ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= htmlspecialchars($d['NamaProduk'] ?? '-', ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= $d['JumlahProduk'] ?></td>
                            <td>Rp <?= number_format($d['SubTotal'], 2, ',', '.') ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="4" class="text-center">Belum ada data detail penjualan.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
