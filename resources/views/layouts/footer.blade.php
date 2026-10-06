<footer class="main-footer">
    <div class="footer-container">
        <div class="footer-left">
            <strong class="footer-copyright">
                <span class="copyright-icon">©</span>
                {{ date('Y') }} 
                <a href="/" class="company-link">{{ $setting->nama_perusahaan }}</a>
            </strong>
            <span class="footer-text">All rights reserved.</span>
        </div>
        <div class="footer-right hidden-xs">
            <div class="version-badge">
                <span class="version-label">Version</span>
                <span class="version-number">1.1</span>
            </div>
        </div>
    </div>
</footer>