<!-- Modal Form Toko -->
<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form">
    <div class="modal-dialog modal-lg" role="document">
        <form id="form-toko" method="post" enctype="multipart/form-data">
            @csrf
            @method('post')

            <div class="modal-content modern-modal">
                <div class="modal-header">
                    <button type="button" class="close close-button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">
                        <i class="fa fa-store"></i>
                        <span class="title-text">Tambah Toko</span>
                    </h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <!-- Form Fields -->
                        <div class="col-md-12">
                            <!-- Nama Toko -->
                            <div class="form-group">
                                <label for="nama_toko" class="form-label required">
                                    <i class="fa fa-store"></i>
                                    Nama Toko
                                </label>
                                <div class="input-group-modern">
                                    <span class="input-icon">
                                        <i class="fa fa-store"></i>
                                    </span>
                                    <input type="text"
                                           name="nama_toko"
                                           id="nama_toko"
                                           class="form-control modern-input"
                                           placeholder="Nama toko langganan"
                                           required
                                           autofocus>
                                </div>
                                <span class="help-block with-errors"></span>
                            </div>

                            <!-- Alamat -->
                            <div class="form-group">
                                <label for="alamat" class="form-label required">
                                    <i class="fa fa-map-marker-alt"></i>
                                    Alamat
                                </label>
                                <div class="input-group-modern">
                                    <span class="input-icon">
                                        <i class="fa fa-map-marker-alt"></i>
                                    </span>
                                    <textarea name="alamat"
                                              id="alamat"
                                              rows="3"
                                              class="form-control modern-input"
                                              placeholder="Alamat lengkap toko"
                                              required></textarea>
                                </div>
                                <span class="help-block with-errors"></span>
                            </div>

                            <!-- Kontak -->
                            <div class="form-group">
                                <label for="kontak" class="form-label">
                                    <i class="fa fa-phone"></i>
                                    Kontak
                                </label>
                                <div class="input-group-modern">
                                    <span class="input-icon">
                                        <i class="fa fa-phone"></i>
                                    </span>
                                    <input type="text"
                                           name="kontak"
                                           id="kontak"
                                           class="form-control modern-input"
                                           placeholder="Nomor telepon / WA">
                                </div>
                                <span class="help-block with-errors"></span>
                            </div>

                            <!-- Catatan -->
                            <div class="form-group">
                                <label for="catatan" class="form-label">
                                    <i class="fa fa-sticky-note"></i>
                                    Catatan
                                </label>
                                <div class="input-group-modern">
                                    <span class="input-icon">
                                        <i class="fa fa-sticky-note"></i>
                                    </span>
                                    <textarea name="catatan"
                                              id="catatan"
                                              rows="2"
                                              class="form-control modern-input"
                                              placeholder="Catatan tambahan (opsional)"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-save">
                        <i class="fa fa-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-default btn-cancel" data-dismiss="modal">
                        <i class="fa fa-times"></i> Batal
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
