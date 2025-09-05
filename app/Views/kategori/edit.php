<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-edit me-2"></i><?= $title ?>
                </h5>
            </div>
            <div class="card-body">
                <form method="post" action="<?= base_url('kategori/update/' . $kategori['id']) ?>">
                    <?= csrf_field() ?>
                    
                    <div class="mb-3">
                        <label for="nama_kategori" class="form-label">
                            Nama Kategori <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               class="form-control <?= $validation->hasError('nama_kategori') ? 'is-invalid' : '' ?>" 
                               id="nama_kategori" 
                               name="nama_kategori" 
                               value="<?= old('nama_kategori', $kategori['nama_kategori']) ?>"
                               placeholder="Masukkan nama kategori"
                               required>
                        <?php if ($validation->hasError('nama_kategori')) : ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('nama_kategori') ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control <?= $validation->hasError('deskripsi') ? 'is-invalid' : '' ?>" 
                                  id="deskripsi" 
                                  name="deskripsi" 
                                  rows="4"
                                  placeholder="Masukkan deskripsi kategori (opsional)"><?= old('deskripsi', $kategori['deskripsi']) ?></textarea>
                        <?php if ($validation->hasError('deskripsi')) : ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('deskripsi') ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="<?= base_url('kategori') ?>" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i>Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>Perbarui
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    // Auto focus pada field pertama
    document.getElementById('nama_kategori').focus();
</script>
<?= $this->endSection() ?>