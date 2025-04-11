</div>

<!-- Footer -->
<footer class="footer">
    <p>&copy; <span id="year"></span> INVENTORY. All rights reserved.</p>
</footer>

<!-- Script libraries (urutan penting) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

<!-- Script custom -->
<script src="public/assets/script.js"></script>

<script>
// Inisialisasi tabel DataTables dan footer tahun otomatis
$(document).ready(function () {
    // Tabel Supplier
    $('#tabel-pelanggan').DataTable({
        responsive: true,
        pageLength: 5,
        lengthMenu: [5, 10, 25, 50]
    });

    // Tabel Barang
    $('#tabel-barang').DataTable({
        responsive: true,
        pageLength: 5,
        lengthMenu: [5, 10, 25, 50]
    });

    // Tabel detail
    $('#tabel-detail').DataTable({
        responsive: true,
        pageLength: 5,
        lengthMenu: [5, 10, 25, 50]
    });

    // Tabel Distribusi dengan kolom aksi (terakhir) yang tidak bisa diurutkan
    $('#tabel-distribusi').DataTable({
        responsive: true,
        pageLength: 5,
        lengthMenu: [5, 10, 25, 50],
        columnDefs: [
            { orderable: false, targets: -1 }
        ]
    });

    // Update tahun otomatis di footer
    document.getElementById('year').textContent = new Date().getFullYear();
});
</script>

</body>
</html>
