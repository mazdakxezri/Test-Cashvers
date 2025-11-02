<?php get_header(); ?>

<header class="search-header">
    <h1 class="search-title">Search Results</h1>
    <div class="search-info">
        <?php if (have_posts()) : ?>
            <p>Found <?php echo $wp_query->found_posts; ?> results for "<?php echo get_search_query(); ?>"</p>
        <?php else : ?>
            <p>No results found for "<?php echo get_search_query(); ?>"</p>
        <?php endif; ?>
    </div>
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
                <p>Try searching with different keywords or check back later for new content!</p>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php get_footer(); ?>
