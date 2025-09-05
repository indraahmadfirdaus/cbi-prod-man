<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <i class="fas fa-box me-2"></i><?= $title ?>
                </h5>
                <a href="<?= base_url('produk/create') ?>" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus me-1"></i>Tambah Produk
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="produkTable" class="table table-striped table-hover" width="100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Produk</th>
                                <th>Kategori</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                <th width="150">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data akan dimuat melalui AJAX -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {
    // Initialize DataTable
    $('#produkTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '<?= base_url('produk/data') ?>',
            type: 'GET'
        },
        columns: [
            {
                data: null,
                render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                },
                orderable: false,
                searchable: false
            },
            { data: 'nama_produk' },
            { data: 'nama_kategori' },
            { 
                data: 'harga',
                className: 'text-end'
            },
            { 
                data: 'stok',
                className: 'text-center'
            },
            { 
                data: 'aksi',
                orderable: false,
                searchable: false,
                className: 'text-center'
            }
        ],
        order: [[1, 'asc']],
        language: {
            processing: "Memuat...",
            lengthMenu: "Tampilkan _MENU_ data per halaman",
            zeroRecords: "Data tidak ditemukan",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
            infoFiltered: "(disaring dari _MAX_ total data)",
            search: "Cari:",
            paginate: {
                first: "Pertama",
                last: "Terakhir",
                next: "Selanjutnya",
                previous: "Sebelumnya"
            }
        },
        pageLength: 10,
        lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
        responsive: true
    });
});

// Function to delete product
function deleteProduk(id) {
    if (confirm('Apakah Anda yakin ingin menghapus produk ini?')) {
        $.ajax({
            url: '<?= base_url('produk/delete/') ?>' + id,
            type: 'POST',
            data: {
                '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    // Show success message
                    showAlert('success', response.message);
                    // Reload DataTable
                    $('#produkTable').DataTable().ajax.reload();
                } else {
                    showAlert('danger', response.message);
                }
            },
            error: function() {
                showAlert('danger', 'Terjadi kesalahan saat menghapus produk');
            }
        });
    }
}

// Function to show alert
function showAlert(type, message) {
    const alertHtml = `
        <div class="alert alert-${type} alert-dismissible fade show" role="alert">
            <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} me-2"></i>${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
    
    // Remove existing alerts
    $('.alert').remove();
    
    // Add new alert at the top of container
    $('.container').prepend(alertHtml);
    
    // Auto hide after 5 seconds
    setTimeout(function() {
        $('.alert').fadeOut();
    }, 5000);
}
</script>
<?= $this->endSection() ?>