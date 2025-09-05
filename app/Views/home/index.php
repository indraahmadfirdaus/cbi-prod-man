<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <div class="jumbotron bg-primary text-white rounded p-5 mb-4">
            <h1 class="display-4">
                <i class="fas fa-cube me-3"></i>Selamat Datang di Manajemen Produk
            </h1>
            <p class="lead">
                Aplikasi sederhana untuk mengelola data kategori dan produk dengan teknologi CodeIgniter 4 dan SQL Server.
            </p>
            <hr class="my-4">
            <p>Mulai dengan mengelola kategori produk atau langsung menambahkan produk baru.</p>
            <div class="d-flex gap-3">
                <a class="btn btn-light btn-lg" href="<?= base_url('kategori') ?>" role="button">
                    <i class="fas fa-tags me-2"></i>Kelola Kategori
                </a>
                <a class="btn btn-outline-light btn-lg" href="<?= base_url('produk') ?>" role="button">
                    <i class="fas fa-box me-2"></i>Kelola Produk
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <div class="d-flex align-items-center justify-content-center mb-3">
                    <div class="rounded-circle bg-primary bg-opacity-10 p-3">
                        <i class="fas fa-tags fa-2x text-primary"></i>
                    </div>
                </div>
                <h3 class="card-title"><?= number_format($totalKategori) ?></h3>
                <p class="card-text text-muted">Total Kategori</p>
                <a href="<?= base_url('kategori') ?>" class="btn btn-primary btn-sm">
                    <i class="fas fa-eye me-1"></i>Lihat Semua
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <div class="d-flex align-items-center justify-content-center mb-3">
                    <div class="rounded-circle bg-success bg-opacity-10 p-3">
                        <i class="fas fa-box fa-2x text-success"></i>
                    </div>
                </div>
                <h3 class="card-title"><?= number_format($totalProduk) ?></h3>
                <p class="card-text text-muted">Total Produk</p>
                <a href="<?= base_url('produk') ?>" class="btn btn-success btn-sm">
                    <i class="fas fa-eye me-1"></i>Lihat Semua
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <i class="fas fa-clock me-2"></i>Produk Terbaru
                </h5>
                <a href="<?= base_url('produk') ?>" class="btn btn-outline-primary btn-sm">
                    Lihat Semua <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
            <div class="card-body">
                <?php if (empty($recentProducts)) : ?>
                    <div class="text-center py-5">
                        <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Belum ada produk</h5>
                        <p class="text-muted">Tambahkan produk pertama Anda untuk mulai mengelola inventori.</p>
                        <a href="<?= base_url('produk/create') ?>" class="btn btn-primary">
                            <i class="fas fa-plus me-1"></i>Tambah Produk
                        </a>
                    </div>
                <?php else : ?>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Produk</th>
                                    <th>Kategori</th>
                                    <th>Harga</th>
                                    <th>Stok</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $limitedProducts = array_slice($recentProducts, 0, 5);
                                foreach ($limitedProducts as $index => $produk) : ?>
                                    <tr>
                                        <td><?= $index + 1 ?></td>
                                        <td>
                                            <strong><?= esc($produk['nama_produk']) ?></strong>
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary">
                                                <?= esc($produk['nama_kategori'] ?? 'Tidak ada kategori') ?>
                                            </span>
                                        </td>
                                        <td class="text-end">
                                            <strong class="text-success">
                                                Rp <?= number_format($produk['harga'], 0, ',', '.') ?>
                                            </strong>
                                        </td>
                                        <td class="text-center">
                                            <?php if ($produk['stok'] == 0) : ?>
                                                <span class="badge bg-danger">Habis</span>
                                            <?php elseif ($produk['stok'] < 10) : ?>
                                                <span class="badge bg-warning text-dark"><?= $produk['stok'] ?></span>
                                            <?php else : ?>
                                                <span class="badge bg-success"><?= $produk['stok'] ?></span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card bg-light border-0">
            <div class="card-body text-center">
                <h5 class="card-title">
                    <i class="fas fa-lightbulb me-2 text-warning"></i>Tips Penggunaan
                </h5>
                <div class="row mt-4">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <i class="fas fa-tags fa-2x text-primary mb-2"></i>
                            <h6>Kelola Kategori</h6>
                            <p class="small text-muted">
                                Buat kategori produk terlebih dahulu sebelum menambahkan produk.
                            </p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <i class="fas fa-table fa-2x text-success mb-2"></i>
                            <h6>DataTables</h6>
                            <p class="small text-muted">
                                Gunakan fitur pencarian dan sorting pada tabel produk untuk navigasi yang lebih mudah.
                            </p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <i class="fas fa-shield-alt fa-2x text-info mb-2"></i>
                            <h6>Validasi Data</h6>
                            <p class="small text-muted">
                                Semua input data sudah dilengkapi dengan validasi untuk memastikan kualitas data.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>