<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form">
    <div class="modal-dialog modal-lg" role="document">
        <form action="" method="post" class="form-horizontal" enctype="multipart/form-data" id="form-produk">
            @csrf
            @method('post')

            <div class="modal-content modern-modal">
                <div class="modal-header">
                    <button type="button" class="close-button" data-dismiss="modal" aria-label="Close">
                        <i class="fa fa-times"></i>
                    </button>
                    <h4 class="modal-title">
                        <i class="fa fa-cubes"></i>
                        <span class="title-text"></span>
                    </h4>
                </div>

                <div class="modal-body">
                    <!-- Upload Gambar -->
                    <div class="form-group">
                        <label for="gambar" class="form-label">
                            <i class="fa fa-image"></i>
                            Gambar Produk
                        </label>
                        <div class="image-upload-wrapper">
                            <div class="image-preview" id="image-preview">
                                <img id="preview-img" src="{{ asset('img/product-placeholder.png') }}" alt="Preview">
                            </div>
                            <div class="upload-control">
                                <input type="file" name="gambar" id="gambar" class="form-control" accept="image/*">
                                <small class="text-muted">Format: JPG, PNG, GIF. Maksimal 2MB</small>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="nama_produk" class="form-label required">
                            <i class="fa fa-tag"></i>
                            Nama Produk
                        </label>
                        <div class="input-group-modern">
                            <span class="input-icon">
                                <i class="fa fa-tag"></i>
                            </span>
                            <input type="text"
                                   name="nama_produk"
                                   id="nama_produk"
                                   class="form-control modern-input"
                                   placeholder="Masukkan nama produk"
                                   required
                                   autofocus>
                        </div>
                        <span class="help-block with-errors"></span>
                    </div>

                    <div class="form-group">
                        <label for="id_kategori" class="form-label required">
                            <i class="fa fa-cube"></i>
                            Kategori
                        </label>
                        <div class="input-group-modern">
                            <span class="input-icon">
                                <i class="fa fa-cube"></i>
                            </span>
                            <select name="id_kategori" id="id_kategori" class="form-control modern-select" required>
                                <option value="">Pilih Kategori</option>
                                @foreach ($kategori as $key => $item)
                                <option value="{{ $key }}">{{ $item }}</option>
                                @endforeach
                            </select>
                        </div>
                        <span class="help-block with-errors"></span>
                    </div>

                    <div class="form-group">
                        <label for="merk" class="form-label">
                            <i class="fa fa-bookmark"></i>
                            Merk
                        </label>
                        <div class="input-group-modern">
                            <span class="input-icon">
                                <i class="fa fa-bookmark"></i>
                            </span>
                            <input type="text"
                                   name="merk"
                                   id="merk"
                                   class="form-control modern-input"
                                   placeholder="Masukkan merk produk (opsional)">
                        </div>
                        <span class="help-block with-errors"></span>
                    </div>

                    <div class="form-row">
                        <div class="form-col-2">
                            <div class="form-group">
                                <label for="harga_beli" class="form-label required">
                                    <i class="fa fa-dollar"></i>
                                    Harga Beli
                                </label>
                                <div class="input-group-modern">
                                    <span class="input-icon">
                                        <i class="fa fa-dollar"></i>
                                    </span>
                                    <input type="number"
                                           name="harga_beli"
                                           id="harga_beli"
                                           class="form-control modern-input"
                                           placeholder="0"
                                           min="0"
                                           required>
                                </div>
                                <span class="help-block with-errors"></span>
                            </div>
                        </div>
                        <div class="form-col-2">
                            <div class="form-group">
                                <label for="harga_jual" class="form-label required">
                                    <i class="fa fa-money"></i>
                                    Harga Jual
                                </label>
                                <div class="input-group-modern">
                                    <span class="input-icon">
                                        <i class="fa fa-money"></i>
                                    </span>
                                    <input type="number"
                                           name="harga_jual"
                                           id="harga_jual"
                                           class="form-control modern-input"
                                           placeholder="0"
                                           min="0"
                                           required>
                                </div>
                                <span class="help-block with-errors"></span>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-col-2">
                            <div class="form-group">
                                <label for="stok" class="form-label required">
                                    <i class="fa fa-boxes"></i>
                                    Stok
                                </label>
                                <div class="input-group-modern">
                                    <span class="input-icon">
                                        <i class="fa fa-boxes"></i>
                                    </span>
                                    <input type="number"
                                           name="stok"
                                           id="stok"
                                           class="form-control modern-input"
                                           placeholder="0"
                                           value="0"
                                           min="0"
                                           required>
                                </div>
                                <span class="help-block with-errors"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-save">
                        <i class="fa fa-save"></i>
                        <span>Simpan</span>
                    </button>
                    <button type="button" class="btn btn-secondary btn-cancel" data-dismiss="modal">
                        <i class="fa fa-times"></i>
                        <span>Batal</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
.image-upload-wrapper {
    display: flex;
    gap: 20px;
    align-items: flex-start;
}

.image-preview {
    flex-shrink: 0;
    width: 150px;
    height: 150px;
    border: 2px dashed #ddd;
    border-radius: 8px;
    overflow: hidden;
    background: #f9f9f9;
    display: flex;
    align-items: center;
    justify-content: center;
}

.image-preview img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
}

.upload-control {
    flex: 1;
}
</style>

@push('scripts')
<script>
// Preview gambar saat dipilih
$('#gambar').on('change', function() {
    const file = this.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            $('#preview-img').attr('src', e.target.result);
        }
        reader.readAsDataURL(file);
    }
});
</script>
@endpush
