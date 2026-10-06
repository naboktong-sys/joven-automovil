@extends('layouts.master')

@section('title')
    Edit Profil
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Edit Profil</li>
@endsection

@section('content')
<!-- Profile Header -->
<div class="row">
    <div class="col-lg-12">
        <div class="welcome-banner" style="margin-bottom: 30px;">
            <div class="welcome-content">
                <div class="welcome-text">
                    <h1 class="welcome-title">
                        <i class="fa fa-user-circle"></i>
                        Pengaturan Profil
                    </h1>
                    <p class="welcome-subtitle">
                        Kelola informasi pribadi dan keamanan akun Anda
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Profile Card -->
    <div class="col-lg-4 col-md-5">
        <div class="box modern-box">
            <div class="box-body text-center" style="padding: 40px 30px;">
                <div class="profile-avatar-wrapper">
                    <div class="profile-avatar tampil-foto">
                        <img src="{{ url($profil->foto ?? '/img/user.jpg') }}" alt="Profile Photo" class="profile-img">
                        <div class="profile-avatar-overlay">
                            <i class="fa fa-camera"></i>
                        </div>
                    </div>
                </div>
                
                <h3 class="profile-name">{{ $profil->name }}</h3>
                <p class="profile-email">{{ $profil->email }}</p>
                
                <div class="profile-role">
                    <span class="badge-status info">
                        <i class="fa fa-user-tag"></i>
                        {{ ucfirst($profil->level ?? 'User') }}
                    </span>
                </div>
                
                <div class="profile-stats">
                    <div class="profile-stat-item">
                        <div class="stat-icon">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <div class="stat-info">
                            <div class="stat-label">Bergabung Sejak</div>
                            <div class="stat-value">{{ $profil->created_at ? $profil->created_at->format('d M Y') : '-' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Security Tips -->
        <div class="box modern-box">
            <div class="box-body" style="padding: 25px;">
                <h4 style="font-size: 16px; font-weight: 700; color: var(--text-dark); margin: 0 0 20px 0; display: flex; align-items: center; gap: 10px;">
                    <i class="fa fa-shield-alt" style="color: var(--tosca-primary);"></i>
                    Tips Keamanan
                </h4>
                <ul style="list-style: none; padding: 0; margin: 0;">
                    <li style="padding: 12px 0; border-bottom: 1px solid var(--gray-light); display: flex; align-items: start; gap: 12px;">
                        <i class="fa fa-check-circle" style="color: #27ae60; margin-top: 2px;"></i>
                        <span style="font-size: 14px; color: var(--text-dark);">Gunakan password minimal 6 karakter</span>
                    </li>
                    <li style="padding: 12px 0; border-bottom: 1px solid var(--gray-light); display: flex; align-items: start; gap: 12px;">
                        <i class="fa fa-check-circle" style="color: #27ae60; margin-top: 2px;"></i>
                        <span style="font-size: 14px; color: var(--text-dark);">Kombinasikan huruf, angka, dan simbol</span>
                    </li>
                    <li style="padding: 12px 0; display: flex; align-items: start; gap: 12px;">
                        <i class="fa fa-check-circle" style="color: #27ae60; margin-top: 2px;"></i>
                        <span style="font-size: 14px; color: var(--text-dark);">Jangan gunakan password yang sama di aplikasi lain</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Edit Form -->
    <div class="col-lg-8 col-md-7">
        <div class="box modern-box">
            <div class="box-header">
                <div class="box-header-left">
                    <h3 class="box-title">
                        <i class="fa fa-edit"></i>
                        Edit Informasi Profil
                    </h3>
                    <p class="box-subtitle">Update data pribadi dan password Anda</p>
                </div>
            </div>

            <form action="{{ route('user.update_profil') }}" method="post" class="form-profil" data-toggle="validator" enctype="multipart/form-data">
                @csrf
                <div class="box-body">
                    <!-- Success Alert -->
                    <div class="alert alert-success alert-dismissible profile-alert" style="display: none; margin-bottom: 25px;">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <i class="fa fa-check-circle"></i>
                        <strong>Berhasil!</strong> Perubahan profil berhasil disimpan
                    </div>

                    <!-- Personal Information Section -->
                    <div class="form-section">
                        <h4 class="form-section-title">
                            <i class="fa fa-user"></i>
                            Informasi Pribadi
                        </h4>

                        <div class="form-group">
                            <label for="name" class="form-label required">
                                <i class="fa fa-user"></i>
                                Nama Lengkap
                            </label>
                            <div class="input-group-modern">
                                <i class="input-icon fa fa-user"></i>
                                <input type="text" 
                                       name="name" 
                                       class="modern-input" 
                                       id="name" 
                                       required 
                                       autofocus 
                                       value="{{ $profil->name }}"
                                       placeholder="Masukkan nama lengkap">
                            </div>
                            <span class="help-block with-errors"></span>
                        </div>

                        <div class="form-group">
                            <label for="foto" class="form-label">
                                <i class="fa fa-image"></i>
                                Foto Profil
                            </label>
                            
                            <div class="file-upload-wrapper">
                                <input type="file" 
                                       name="foto" 
                                       class="file-upload-input" 
                                       id="foto"
                                       accept="image/*"
                                       onchange="preview('.tampil-foto .profile-img', this.files[0], this)">
                                <div class="file-upload-button">
                                    <i class="fa fa-cloud-upload-alt"></i>
                                    <div class="file-upload-text">
                                        <div class="main-text">Pilih atau seret foto di sini</div>
                                        <div class="sub-text">Format: JPG, PNG (Max: 2MB)</div>
                                    </div>
                                </div>
                            </div>
                            <div class="file-preview" id="file-preview" style="display: none;">
                                <i class="fa fa-file-image"></i>
                                <div class="file-preview-info">
                                    <div class="file-preview-name" id="file-name"></div>
                                    <div class="file-preview-size" id="file-size"></div>
                                </div>
                                <button type="button" class="file-preview-remove" onclick="removeFile()">
                                    <i class="fa fa-times"></i>
                                </button>
                            </div>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>

                    <!-- Security Section -->
                    <div class="form-section">
                        <h4 class="form-section-title">
                            <i class="fa fa-lock"></i>
                            Keamanan Akun
                        </h4>

                        <div class="info-banner" style="margin-bottom: 20px;">
                            <i class="fa fa-info-circle"></i>
                            <span>Kosongkan jika tidak ingin mengubah password</span>
                        </div>

                        <div class="form-group">
                            <label for="old_password" class="form-label">
                                <i class="fa fa-key"></i>
                                Password Lama
                            </label>
                            <div class="input-group-modern">
                                <i class="input-icon fa fa-key"></i>
                                <input type="password" 
                                       name="old_password" 
                                       id="old_password" 
                                       class="modern-input" 
                                       minlength="6"
                                       placeholder="Masukkan password lama">
                                <span class="password-toggle" onclick="togglePassword('old_password')">
                                    <i class="fa fa-eye" id="toggle-old_password"></i>
                                </span>
                            </div>
                            <span class="help-block with-errors"></span>
                        </div>

                        <div class="form-group">
                            <label for="password" class="form-label">
                                <i class="fa fa-lock"></i>
                                Password Baru
                            </label>
                            <div class="input-group-modern">
                                <i class="input-icon fa fa-lock"></i>
                                <input type="password" 
                                       name="password" 
                                       id="password" 
                                       class="modern-input" 
                                       minlength="6"
                                       placeholder="Masukkan password baru (min. 6 karakter)">
                                <span class="password-toggle" onclick="togglePassword('password')">
                                    <i class="fa fa-eye" id="toggle-password"></i>
                                </span>
                            </div>
                            <span class="help-block with-errors"></span>
                            <div class="password-strength" id="password-strength" style="display: none;">
                                <div class="strength-bar">
                                    <div class="strength-bar-fill" id="strength-bar"></div>
                                </div>
                                <div class="strength-text" id="strength-text"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation" class="form-label">
                                <i class="fa fa-lock"></i>
                                Konfirmasi Password Baru
                            </label>
                            <div class="input-group-modern">
                                <i class="input-icon fa fa-lock"></i>
                                <input type="password" 
                                       name="password_confirmation" 
                                       id="password_confirmation" 
                                       class="modern-input" 
                                       data-match="#password"
                                       placeholder="Ketik ulang password baru">
                                <span class="password-toggle" onclick="togglePassword('password_confirmation')">
                                    <i class="fa fa-eye" id="toggle-password_confirmation"></i>
                                </span>
                            </div>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                </div>

                <div class="box-footer" style="display: flex; justify-content: space-between; align-items: center;">
                    <div style="font-size: 13px; color: var(--text-light);">
                        <i class="fa fa-info-circle"></i>
                        Pastikan data yang Anda masukkan sudah benar
                    </div>
                    <div style="display: flex; gap: 10px;">
                        <button type="reset" class="btn btn-secondary">
                            <i class="fa fa-redo"></i>
                            <span>Reset</span>
                        </button>
                        <button type="submit" class="btn btn-primary btn-save">
                            <i class="fa fa-save"></i>
                            <span>Simpan Perubahan</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
/* Profile Avatar */
.profile-avatar-wrapper {
    margin-bottom: 25px;
    display: inline-block;
    position: relative;
}

.profile-avatar {
    width: 140px;
    height: 140px;
    border-radius: 50%;
    overflow: hidden;
    border: 5px solid var(--white);
    box-shadow: 0 8px 24px rgba(22, 160, 133, 0.2);
    position: relative;
    transition: all 0.3s ease;
}

.profile-avatar:hover {
    box-shadow: 0 12px 32px rgba(22, 160, 133, 0.3);
    transform: scale(1.05);
}

.profile-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.profile-avatar-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(22, 160, 133, 0.8);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: all 0.3s ease;
}

.profile-avatar:hover .profile-avatar-overlay {
    opacity: 1;
}

.profile-avatar-overlay i {
    color: var(--white);
    font-size: 32px;
}

/* Profile Info */
.profile-name {
    font-size: 22px;
    font-weight: 700;
    color: var(--text-dark);
    margin: 0 0 8px 0;
}

.profile-email {
    font-size: 14px;
    color: var(--text-light);
    margin: 0 0 15px 0;
}

.profile-role {
    margin-bottom: 25px;
}

/* Profile Stats */
.profile-stats {
    padding-top: 25px;
    border-top: 2px solid var(--gray-light);
}

.profile-stat-item {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 15px;
    background: linear-gradient(135deg, rgba(22, 160, 133, 0.05) 0%, rgba(26, 188, 156, 0.05) 100%);
    border-radius: 10px;
}

.profile-stat-item .stat-icon {
    width: 45px;
    height: 45px;
    background: linear-gradient(135deg, var(--tosca-primary) 0%, var(--tosca-dark) 100%);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--white);
    font-size: 18px;
}

.profile-stat-item .stat-info {
    flex: 1;
    text-align: left;
}

.profile-stat-item .stat-label {
    font-size: 12px;
    color: var(--text-light);
    margin-bottom: 4px;
}

.profile-stat-item .stat-value {
    font-size: 14px;
    font-weight: 600;
    color: var(--text-dark);
}

/* Form Sections */
.form-section {
    margin-bottom: 35px;
    padding-bottom: 30px;
    border-bottom: 2px solid var(--gray-light);
}

.form-section:last-child {
    border-bottom: none;
    margin-bottom: 0;
    padding-bottom: 0;
}

.form-section-title {
    font-size: 17px;
    font-weight: 700;
    color: var(--text-dark);
    margin: 0 0 20px 0;
    display: flex;
    align-items: center;
    gap: 10px;
}

.form-section-title i {
    color: var(--tosca-primary);
    font-size: 18px;
}

/* Password Strength Indicator */
.password-strength {
    margin-top: 10px;
}

.strength-bar {
    height: 6px;
    background: var(--gray-light);
    border-radius: 3px;
    overflow: hidden;
    margin-bottom: 8px;
}

.strength-bar-fill {
    height: 100%;
    width: 0;
    transition: all 0.3s ease;
    border-radius: 3px;
}

.strength-text {
    font-size: 12px;
    font-weight: 600;
}

.strength-weak {
    background: #e74c3c;
    color: #e74c3c;
}

.strength-medium {
    background: #f39c12;
    color: #f39c12;
}

.strength-strong {
    background: #27ae60;
    color: #27ae60;
}

/* Profile Alert */
.profile-alert {
    animation: slideInDown 0.3s ease;
}

@keyframes slideInDown {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Responsive */
@media (max-width: 991px) {
    .profile-avatar {
        width: 120px;
        height: 120px;
    }
    
    .profile-name {
        font-size: 20px;
    }
    
    .box-footer {
        flex-direction: column;
        gap: 15px;
        align-items: stretch !important;
    }
    
    .box-footer > div:last-child {
        width: 100%;
    }
    
    .box-footer button {
        flex: 1;
    }
}

@media (max-width: 767px) {
    .profile-avatar {
        width: 100px;
        height: 100px;
        border-width: 4px;
    }
    
    .profile-avatar-overlay i {
        font-size: 24px;
    }
}
</style>

@push('scripts')
<script>
$(function () {
    // Password field dependency
    $('#old_password').on('keyup', function () {
        if ($(this).val() != "") {
            $('#password, #password_confirmation').attr('required', true);
        } else {
            $('#password, #password_confirmation').attr('required', false);
        }
    });

    // Password strength checker
    $('#password').on('keyup', function() {
        const password = $(this).val();
        
        if (password.length > 0) {
            $('#password-strength').show();
            
            let strength = 0;
            if (password.length >= 6) strength += 25;
            if (password.length >= 10) strength += 25;
            if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength += 25;
            if (/[0-9]/.test(password)) strength += 12.5;
            if (/[^a-zA-Z0-9]/.test(password)) strength += 12.5;
            
            $('#strength-bar').css('width', strength + '%');
            
            if (strength < 50) {
                $('#strength-bar').removeClass().addClass('strength-bar-fill strength-weak');
                $('#strength-text').removeClass().addClass('strength-text strength-weak').text('Lemah');
            } else if (strength < 75) {
                $('#strength-bar').removeClass().addClass('strength-bar-fill strength-medium');
                $('#strength-text').removeClass().addClass('strength-text strength-medium').text('Sedang');
            } else {
                $('#strength-bar').removeClass().addClass('strength-bar-fill strength-strong');
                $('#strength-text').removeClass().addClass('strength-text strength-strong').text('Kuat');
            }
        } else {
            $('#password-strength').hide();
        }
    });

    // Form submission
    $('.form-profil').validator().on('submit', function (e) {
        if (!e.preventDefault()) {
            const $submitBtn = $('.btn-save');
            const originalText = $submitBtn.html();
            $submitBtn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> <span>Menyimpan...</span>');

            $.ajax({
                url: $('.form-profil').attr('action'),
                type: $('.form-profil').attr('method'),
                data: new FormData($('.form-profil')[0]),
                async: false,
                processData: false,
                contentType: false
            })
            .done(response => {
                // Update profile data
                $('[name=name]').val(response.name);
                $('.profile-name').text(response.name);
                
                // Update profile image
                const photoUrl = `{{ url('/') }}/${response.foto}`;
                $('.tampil-foto .profile-img').attr('src', photoUrl);
                $('.img-profil').attr('src', photoUrl);

                // Show success message
                $('.profile-alert').fadeIn();
                
                // Reset password fields
                $('#old_password, #password, #password_confirmation').val('');
                $('#password-strength').hide();
                
                // Remove file preview
                removeFile();
                
                // Scroll to top
                $('html, body').animate({ scrollTop: 0 }, 500);
                
                setTimeout(() => {
                    $('.profile-alert').fadeOut();
                }, 5000);

                // Show SweetAlert
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'Profil Anda berhasil diperbarui',
                    confirmButtonColor: '#16a085',
                    timer: 3000
                });
            })
            .fail(errors => {
                let errorMessage = 'Tidak dapat menyimpan data';
                
                if (errors.status == 422) {
                    errorMessage = errors.responseJSON.message || 'Validasi gagal';
                }
                
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: errorMessage,
                    confirmButtonColor: '#e74c3c'
                });
            })
            .always(() => {
                $submitBtn.prop('disabled', false).html(originalText);
            });
        }
    });
});

// Toggle password visibility
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const icon = document.getElementById('toggle-' + fieldId);
    
    if (field.type === 'password') {
        field.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        field.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}

// Preview image with file info
function preview(selector, file, input) {
    if (file) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            $(selector).attr('src', e.target.result);
        };
        
        reader.readAsDataURL(file);
        
        // Show file preview info
        $('#file-preview').show();
        $('#file-name').text(file.name);
        $('#file-size').text((file.size / 1024).toFixed(2) + ' KB');
    }
}

// Remove file
function removeFile() {
    $('#foto').val('');
    $('#file-preview').hide();
}
</script>
@endpush
@endsection