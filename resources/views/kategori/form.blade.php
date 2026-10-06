<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form">
    <div class="modal-dialog modal-lg" role="document">
        <form action="" method="post" class="form-horizontal">
            @csrf
            @method('post')

            <div class="modal-content modern-modal">
                <!-- Modal Header -->
                <div class="modal-header">
                    <button type="button" class="close-button" data-dismiss="modal" aria-label="Close">
                        <i class="fa fa-times"></i>
                    </button>
                    <h4 class="modal-title">
                        <i class="fa fa-cube"></i>
                        <span class="title-text"></span>
                    </h4>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nama_kategori" class="form-label required">
                            <i class="fa fa-cube"></i>
                            Nama Kategori
                        </label>
                        <div class="input-group-modern">
                            <span class="input-icon">
                                <i class="fa fa-cube"></i>
                            </span>
                            <input type="text"
                                   name="nama_kategori"
                                   id="nama_kategori"
                                   class="form-control modern-input"
                                   placeholder="Masukkan nama kategori"
                                   required
                                   autofocus>
                        </div>
                        <span class="help-block with-errors"></span>
                    </div>
                </div>

                <!-- Modal Footer -->
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
