<div class="container mt-4">
    <h2>Selamat Datang di Sistem Gudang</h2>
    <p>Gunakan menu di sidebar untuk mengelola produk, pelanggan, dan transaksi.</p>

    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Produk</h5>
                    <p class="card-text"><?= $jumlahBarang; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Pelanggan</h5>
                    <p class="card-text"><?= $jumlahSupplier; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-warning mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Penjualan</h5>
                    <p class="card-text"><?= $jumlahDistribusi ?></p>
                </div>
            </div>
        </div>
    </div>
</div>