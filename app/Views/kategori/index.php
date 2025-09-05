<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <i class="fas fa-tags me-2"></i><?= $title ?>
                </h5>
                <a href="<?= base_url('kategori/create') ?>" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus me-1"></i>Tambah Kategori
                </a>
            </div>
            <div class="card-body">
                <?php if (empty($categories)) : ?>
                    <div class="text-center py-5">
                        <i class="fas fa-tags fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Belum ada kategori</h5>
                        <p class="text-muted">Silakan tambah kategori pertama Anda</p>
                        <a href="<?= base_url('kategori/create') ?>" class="btn btn-primary">
                            <i class="fas fa-plus me-1"></i>Tambah Kategori
                        </a>
                    </div>
                <?php else : ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th width="50">No</th>
                                    <th>Nama Kategori</th>
                                    <th>Deskripsi</th>
                                    <th width="150">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($categories as $index => $kategori) : ?>
                                    <tr>
                                        <td><?= $index + 1 ?></td>
                                        <td>
                                            <strong><?= esc($kategori['nama_kategori']) ?></strong>
                                        </td>
                                        <td>
                                            <?php if (!empty($kategori['deskripsi'])) : ?>
                                                <?= esc($kategori['deskripsi']) ?>
                                            <?php else : ?>
                                                <em class="text-muted">Tidak ada deskripsi</em>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="<?= base_url('kategori/edit/' . $kategori['id']) ?>" 
                                                   class="btn btn-warning btn-sm">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form method="post" 
                                                      action="<?= base_url('kategori/delete/' . $kategori['id']) ?>" 
                                                      class="d-inline"
                                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">
                                                    <?= csrf_field() ?>
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
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
<?= $this->endSection() ?>