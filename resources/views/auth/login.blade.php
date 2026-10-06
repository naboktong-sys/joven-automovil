@extends('layouts.auth')

@section('login')

<div class="login-page">
    <div class="login-container">
        <!-- Decorative Elements -->
        <div class="login-decoration decoration-1"></div>
        <div class="login-decoration decoration-2"></div>
        <div class="login-decoration decoration-3"></div>

        <div class="login-box">
            <!-- Logo Section -->
            <div class="login-header">
                <div class="login-logo">
                    <a href="{{ url('/') }}">
                        <img src="{{ url($setting->path_logo) }}" alt="logo" class="logo-image">
                    </a>
                </div>
                <h2 class="login-title">Welcome Back!</h2>
                <p class="login-subtitle">Sign in to your account to continue</p>
            </div>

            <!-- Login Form -->
            <div class="login-box-body">
                <form action="{{ route('login') }}" method="post" class="form-login">
                    @csrf
                    
                    <!-- Email Input -->
                    <div class="form-group @error('email') has-error @enderror">
                        <label class="form-label">
                            <i class="fa fa-envelope"></i>
                            Email Address
                        </label>
                        <div class="input-wrapper">
                            <span class="input-icon">
                                <i class="fa fa-envelope"></i>
                            </span>
                            <input type="email" 
                                   name="email" 
                                   class="form-control" 
                                   placeholder="Enter your email" 
                                   required 
                                   value="{{ old('email') }}" 
                                   autofocus>
                        </div>
                        @error('email')
                            <span class="help-block">
                                <i class="fa fa-exclamation-circle"></i>
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <!-- Password Input -->
                    <div class="form-group @error('password') has-error @enderror">
                        <label class="form-label">
                            <i class="fa fa-lock"></i>
                            Password
                        </label>
                        <div class="input-wrapper">
                            <span class="input-icon">
                                <i class="fa fa-lock"></i>
                            </span>
                            <input type="password" 
                                   name="password" 
                                   class="form-control" 
                                   placeholder="Enter your password" 
                                   required
                                   id="password-input">
                            <span class="password-toggle" onclick="togglePassword()">
                                <i class="fa fa-eye" id="toggle-icon"></i>
                            </span>
                        </div>
                        @error('password')
                            <span class="help-block">
                                <i class="fa fa-exclamation-circle"></i>
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="form-options">
                        <div class="checkbox-wrapper">
                            <label class="custom-checkbox">
                                <input type="checkbox" name="remember" class="checkmark">
                                <span class="checkbox-label">Remember Me</span>
                            </label>
                        </div>
                        <a href="#" class="forgot-password">Forgot Password?</a>
                    </div>

                    <!-- Submit Button -->
                    <div class="form-submit">
                        <button type="submit" class="btn btn-login">
                            <span class="btn-text">Sign In</span>
                            <span class="btn-icon">
                                <i class="fa fa-arrow-right"></i>
                            </span>
                        </button>
                    </div>
                </form>

                <!-- Additional Info -->
                <div class="login-footer">
                    <p class="register-link">
                        Don't have an account? 
                        <a href="#">Contact Administrator</a>
                    </p>
                </div>
            </div>
        </div>

        <!-- Footer Info -->
        <div class="login-info">
            <p>&copy; {{ date('Y') }} {{ $setting->nama_perusahaan }}. All rights reserved.</p>
        </div>
    </div>
</div>

<script>
function togglePassword() {
    const passwordInput = document.getElementById('password-input');
    const toggleIcon = document.getElementById('toggle-icon');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleIcon.classList.remove('fa-eye');
        toggleIcon.classList.add('fa-eye-slash');
    } else {
        passwordInput.type = 'password';
        toggleIcon.classList.remove('fa-eye-slash');
        toggleIcon.classList.add('fa-eye');
    }
}
</script>

@endsection