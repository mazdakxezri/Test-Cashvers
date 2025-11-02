<?php get_header(); ?>

<!-- Hero Section -->
<section class="hero-section">
    <div class="hero-content">
        <h1 class="hero-title">Welcome to Cashvers Academy</h1>
        <p class="hero-subtitle">Learn how to earn money online through crypto, gaming, apps, and smart strategies</p>
        <a href="https://cashvers.com" class="hero-cta" target="_blank">Start Earning Now</a>
    </div>
</section>

<!-- Categories Section -->
<section class="categories-section">
    <h2 class="section-title">Explore Our Categories</h2>
    <div class="categories-grid">
        <a href="<?php echo esc_url(get_category_link(get_cat_ID('Crypto'))); ?>" class="category-card">
            <i class="fas fa-coins category-icon" style="color: #DC2626;"></i>
            <h3>Crypto</h3>
            <p>Learn about cryptocurrency trading, mining, and earning opportunities</p>
        </a>
        
        <a href="<?php echo esc_url(get_category_link(get_cat_ID('Gaming'))); ?>" class="category-card">
            <i class="fas fa-gamepad category-icon" style="color: #DC2626;"></i>
            <h3>Gaming</h3>
            <p>Discover how to earn money through gaming and esports</p>
        </a>
        
        <a href="<?php echo esc_url(get_category_link(get_cat_ID('Apps'))); ?>" class="category-card">
            <i class="fas fa-mobile-alt category-icon" style="color: #DC2626;"></i>
            <h3>Apps</h3>
            <p>Review and earn with mobile apps and online platforms</p>
        </a>
        
        <a href="<?php echo esc_url(get_category_link(get_cat_ID('Tips & Tricks'))); ?>" class="category-card">
            <i class="fas fa-lightbulb category-icon" style="color: #DC2626;"></i>
            <h3>Tips & Tricks</h3>
            <p>Expert advice and strategies to maximize your earnings</p>
        </a>
        
        <a href="<?php echo esc_url(get_category_link(get_cat_ID('Earn Money'))); ?>" class="category-card">
            <i class="fas fa-dollar-sign category-icon" style="color: #DC2626;"></i>
            <h3>Earn Money</h3>
            <p>Proven methods and platforms to start earning today</p>
        </a>
    </div>
</section>

<!-- Recent Posts Section -->
<section class="posts-section">
    <h2 class="section-title">Latest Articles</h2>
    <div class="posts-grid">
        <?php if (have_posts()) : ?>
            <?php while (have_posts()) : the_post(); ?>
                <article class="post-card">
                    <div class="post-thumbnail">
                        <?php if (has_post_thumbnail()) : ?>
                            <?php the_post_thumbnail('medium'); ?>
                        <?php else : ?>
                            <i class="fas fa-image"></i>
                        <?php endif; ?>
                    </div>
                    <div class="post-content">
                        <div class="post-meta">
                            <span class="post-category">
                                <?php
                                $categories = get_the_category();
                                if ($categories) {
                                    echo esc_html($categories[0]->name);
                                }
                                ?>
                            </span>
                            <span class="post-date">
                                <i class="fas fa-calendar"></i> <?php echo get_the_date(); ?>
                            </span>
                            <span class="reading-time">
                                <i class="fas fa-clock"></i> <?php echo estimate_reading_time(); ?> min read
                            </span>
                        </div>
                        <h3 class="post-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h3>
                        <p class="post-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p>
                        <a href="<?php the_permalink(); ?>" class="read-more">Read More <i class="fas fa-arrow-right"></i></a>
                    </div>
                </article>
            <?php endwhile; ?>
        <?php else : ?>
            <div class="no-posts">
                <h3>No posts found</h3>
                <p>Check back soon for new content!</p>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Statistics Section -->
<section class="stats-section">
    <div class="container">
        <div class="stats-grid">
            <div class="stat-item">
                <h3 class="stat-number">500+</h3>
                <p class="stat-label">Articles Published</p>
            </div>
            <div class="stat-item">
                <h3 class="stat-number">50K+</h3>
                <p class="stat-label">Monthly Readers</p>
            </div>
            <div class="stat-item">
                <h3 class="stat-number">$2M+</h3>
                <p class="stat-label">Earned by Readers</p>
            </div>
            <div class="stat-item">
                <h3 class="stat-number">100+</h3>
                <p class="stat-label">Success Stories</p>
            </div>
        </div>
    </div>
</section>

<!-- Newsletter Signup -->
<section class="newsletter-section">
    <div class="newsletter-content">
        <h2>Stay Updated</h2>
        <p>Get the latest earning strategies and tips delivered to your inbox</p>
        <form class="newsletter-form" id="newsletter-form">
            <input type="email" placeholder="Enter your email address" required id="newsletter-email">
            <button type="submit">Subscribe</button>
        </form>
    </div>
</section>

<script>
// Newsletter subscription functionality
document.getElementById('newsletter-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const email = document.getElementById('newsletter-email').value;
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.textContent;
    
    // Show loading state
    submitBtn.textContent = 'Subscribing...';
    submitBtn.disabled = true;
    
    // Simulate subscription process
    setTimeout(() => {
        // Here you would typically send the email to your backend
        // For now, we'll just show a success message
        alert('Thank you for subscribing! You\'ll receive our latest earning strategies and tips.');
        
        // Reset form
        this.reset();
        submitBtn.textContent = originalText;
        submitBtn.disabled = false;
        
        // You can integrate with your email service here:
        // - Mailchimp
        // - ConvertKit
        // - Custom WordPress function
        // - Third-party API
        
    }, 2000);
});
</script>

<?php get_footer(); ?>
