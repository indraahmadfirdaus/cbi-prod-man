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
                <form method="post" action="<?= base_url('produk/update/' . $produk['id']) ?>">
                    <?= csrf_field() ?>
                    
                    <div class="mb-3">
                        <label for="kategori_id" class="form-label">
                            Kategori <span class="text-danger">*</span>
                        </label>
                        <select class="form-select <?= $validation->hasError('kategori_id') ? 'is-invalid' : '' ?>" 
                                id="kategori_id" 
                                name="kategori_id" 
                                required>
                            <option value="">Pilih Kategori</option>
                            <?php foreach ($categories as $category) : ?>
                                <option value="<?= $category['id'] ?>" 
                                        <?= old('kategori_id', $produk['kategori_id']) == $category['id'] ? 'selected' : '' ?>>
                                    <?= esc($category['nama_kategori']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?php if ($validation->hasError('kategori_id')) : ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('kategori_id') ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label for="nama_produk" class="form-label">
                            Nama Produk <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               class="form-control <?= $validation->hasError('nama_produk') ? 'is-invalid' : '' ?>" 
                               id="nama_produk" 
                               name="nama_produk" 
                               value="<?= old('nama_produk', $produk['nama_produk']) ?>"
                               placeholder="Masukkan nama produk"
                               required>
                        <?php if ($validation->hasError('nama_produk')) : ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('nama_produk') ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="harga" class="form-label">
                                    Harga <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" 
                                           class="form-control <?= $validation->hasError('harga') ? 'is-invalid' : '' ?>" 
                                           id="harga" 
                                           name="harga" 
                                           value="<?= old('harga', $produk['harga']) ?>"
                                           placeholder="0"
                                           min="1"
                                           step="0.01"
                                           required>
                                    <?php if ($validation->hasError('harga')) : ?>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('harga') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="stok" class="form-label">
                                    Stok <span class="text-danger">*</span>
                                </label>
                                <input type="number" 
                                       class="form-control <?= $validation->hasError('stok') ? 'is-invalid' : '' ?>" 
                                       id="stok" 
                                       name="stok" 
                                       value="<?= old('stok', $produk['stok']) ?>"
                                       placeholder="0"
                                       min="0"
                                       required>
                                <?php if ($validation->hasError('stok')) : ?>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('stok') ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="<?= base_url('produk') ?>" class="btn btn-secondary">
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
    document.getElementById('kategori_id').focus();
    
    // Format number input for price
    document.getElementById('harga').addEventListener('input', function(e) {
        let value = e.target.value;
        if (value < 0) {
            e.target.value = 0;
        }
    });
    
    // Format number input for stock
    document.getElementById('stok').addEventListener('input', function(e) {
        let value = e.target.value;
        if (value < 0) {
            e.target.value = 0;
        }
    });
</script>
<?= $this->endSection() ?>