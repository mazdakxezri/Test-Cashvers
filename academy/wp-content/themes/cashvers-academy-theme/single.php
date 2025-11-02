<?php get_header(); ?>

<article class="single-post">
    <?php while (have_posts()) : the_post(); ?>
        <header class="post-header">
            <h1 class="post-title"><?php the_title(); ?></h1>
            <div class="post-meta">
                <span class="post-date">
                    <i class="fas fa-calendar"></i> <?php echo get_the_date(); ?>
                </span>
                <span class="post-category">
                    <?php
                    $categories = get_the_category();
                    if ($categories) {
                        echo '<i class="fas fa-folder"></i> ' . esc_html($categories[0]->name);
                    }
                    ?>
                </span>
                <span class="reading-time">
                    <i class="fas fa-clock"></i> <?php echo estimate_reading_time(); ?> min read
                </span>
            </div>
        </header>

        <div class="post-thumbnail">
            <?php if (has_post_thumbnail()) : ?>
                <?php the_post_thumbnail('large'); ?>
            <?php endif; ?>
        </div>

        <div class="post-content">
            <?php the_content(); ?>
        </div>

        <footer class="post-footer">
            <div class="post-tags">
                <?php
                $tags = get_the_tags();
                if ($tags) {
                    echo '<h4>Tags:</h4>';
                    foreach ($tags as $tag) {
                        echo '<a href="' . get_tag_link($tag->term_id) . '" class="tag">' . $tag->name . '</a>';
                    }
                }
                ?>
            </div>
        </footer>
    <?php endwhile; ?>
</article>

<?php get_footer(); ?>
