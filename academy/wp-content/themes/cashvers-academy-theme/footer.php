        </div> <!-- End content-area -->
    </div> <!-- End main-content -->
</div> <!-- End site-container -->

<!-- Footer -->
<footer class="site-footer">
    <div class="footer-content">
        <!-- About Section -->
        <div class="footer-section">
            <h3>About Cashvers Academy</h3>
            <p>Your ultimate destination for learning how to earn money online through crypto, gaming, apps, and smart strategies.</p>
        </div>

        <!-- Quick Links -->
        <div class="footer-section">
            <h3>Quick Links</h3>
            <ul class="footer-links">
                <li><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
                <li><a href="<?php echo esc_url(get_category_link(get_cat_ID('Crypto'))); ?>">Crypto Guides</a></li>
                <li><a href="<?php echo esc_url(get_category_link(get_cat_ID('Gaming'))); ?>">Gaming Tips</a></li>
                <li><a href="<?php echo esc_url(get_category_link(get_cat_ID('Apps'))); ?>">App Reviews</a></li>
                <li><a href="<?php echo esc_url(get_category_link(get_cat_ID('Tips & Tricks'))); ?>">Tips & Tricks</a></li>
            </ul>
        </div>

        <!-- Categories -->
        <div class="footer-section">
            <h3>Categories</h3>
            <ul class="footer-links">
                <li><a href="<?php echo esc_url(get_category_link(get_cat_ID('Earn Money'))); ?>">Earn Money</a></li>
                <li><a href="<?php echo esc_url(get_category_link(get_cat_ID('Crypto'))); ?>">Cryptocurrency</a></li>
                <li><a href="<?php echo esc_url(get_category_link(get_cat_ID('Gaming'))); ?>">Gaming</a></li>
                <li><a href="<?php echo esc_url(get_category_link(get_cat_ID('Apps'))); ?>">Mobile Apps</a></li>
                <li><a href="<?php echo esc_url(get_category_link(get_cat_ID('Tips & Tricks'))); ?>">Tips & Tricks</a></li>
            </ul>
        </div>

        <!-- Connect -->
        <div class="footer-section">
            <h3>Connect With Us</h3>
            <p>Stay updated with the latest earning opportunities and strategies.</p>
            <div style="margin-top: 1rem;">
                <a href="https://cashvers.com" target="_blank" style="color: var(--primary-red); text-decoration: none; font-weight: 500;">
                    <i class="fas fa-external-link-alt" style="margin-right: 0.5rem;"></i>
                    Visit Main Website
                </a>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <p>&copy; <?php echo date('Y'); ?> Cashvers Academy. All rights reserved. | <a href="https://cashvers.com">cashvers.com</a></p>
    </div>
</footer>

<script>
// Mobile menu toggle
document.addEventListener('DOMContentLoaded', function() {
    const mobileToggle = document.getElementById('mobile-menu-toggle');
    const sidebar = document.getElementById('sidebar');
    
    if (mobileToggle && sidebar) {
        mobileToggle.addEventListener('click', function() {
            sidebar.classList.toggle('open');
        });
        
        // Close sidebar when clicking outside
        document.addEventListener('click', function(e) {
            if (!sidebar.contains(e.target) && !mobileToggle.contains(e.target)) {
                sidebar.classList.remove('open');
            }
        });
    }
});
</script>

<?php wp_footer(); ?>
</body>
</html>
