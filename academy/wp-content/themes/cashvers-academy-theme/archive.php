<?php get_header(); ?>

<header class="archive-header">
    <h1 class="archive-title">
        <?php
        if (is_category()) {
            single_cat_title();
        } elseif (is_tag()) {
            single_tag_title();
        } elseif (is_author()) {
            the_author();
        } elseif (is_date()) {
            if (is_year()) {
                echo get_the_date('Y');
            } elseif (is_month()) {
                echo get_the_date('F Y');
            } elseif (is_day()) {
                echo get_the_date();
            }
        } else {
            echo 'Archives';
        }
        ?>
    </h1>
    <?php if (category_description()) : ?>
        <div class="archive-description">
            <?php echo category_description(); ?>
        </div>
    <?php endif; ?>
</header>

<section class="posts-section">
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

<?php get_footer(); ?>
