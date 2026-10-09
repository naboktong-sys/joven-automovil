<!-- Modal Form User -->
<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form">
    <div class="modal-dialog modal-lg" role="document">
        <form action="" method="post" class="form-horizontal">
            @csrf
            @method('post')

            <div class="modal-content modern-modal">
                <div class="modal-header">
                    <button type="button" class="close close-button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">
                        <i class="fa fa-user"></i>
                        <span class="title-text">Tambah User</span>
                    </h4>
                </div>
                <div class="modal-body">
                    <!-- Nama -->
                    <div class="form-group">
                        <label for="name" class="form-label required">
                            <i class="fa fa-user"></i>
                            Nama
                        </label>
                        <div class="input-group-modern">
                            <span class="input-icon">
                                <i class="fa fa-user"></i>
                            </span>
                            <input type="text"
                                   name="name"
                                   id="name"
                                   class="form-control modern-input"
                                   placeholder="Nama lengkap user"
                                   required
                                   autofocus>
                        </div>
                        <span class="help-block with-errors"></span>
                    </div>

                    <!-- Email -->
                    <div class="form-group">
                        <label for="email" class="form-label required">
                            <i class="fa fa-envelope"></i>
                            Email
                        </label>
                        <div class="input-group-modern">
                            <span class="input-icon">
                                <i class="fa fa-envelope"></i>
                            </span>
                            <input type="email"
                                   name="email"
                                   id="email"
                                   class="form-control modern-input"
                                   placeholder="email@example.com"
                                   required>
                        </div>
                        <span class="help-block with-errors"></span>
                    </div>

                    <!-- Level -->
                    <div class="form-group">
                        <label for="level" class="form-label required">
                            <i class="fa fa-shield"></i>
                            Level
                        </label>
                        <div class="input-group-modern">
                            <span class="input-icon">
                                <i class="fa fa-shield"></i>
                            </span>
                            <select name="level" id="level" class="form-control modern-input" required>
                                <option value="2">Sales</option>
                                <option value="1">Admin</option>
                            </select>
                        </div>
                        <span class="help-block with-errors"></span>
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <label for="password" class="form-label required">
                            <i class="fa fa-lock"></i>
                            Password
                        </label>
                        <div class="input-group-modern">
                            <span class="input-icon">
                                <i class="fa fa-lock"></i>
                            </span>
                            <input type="password"
                                   name="password"
                                   id="password"
                                   class="form-control modern-input"
                                   placeholder="Minimal 6 karakter"
                                   required
                                   minlength="6">
                        </div>
                        <span class="help-block with-errors"></span>
                    </div>

                    <!-- Konfirmasi Password -->
                    <div class="form-group">
                        <label for="password_confirmation" class="form-label required">
                            <i class="fa fa-lock"></i>
                            Konfirmasi Password
                        </label>
                        <div class="input-group-modern">
                            <span class="input-icon">
                                <i class="fa fa-lock"></i>
                            </span>
                            <input type="password"
                                   name="password_confirmation"
                                   id="password_confirmation"
                                   class="form-control modern-input"
                                   placeholder="Ulangi password"
                                   required
                                   data-match="#password">
                        </div>
                        <span class="help-block with-errors"></span>
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
