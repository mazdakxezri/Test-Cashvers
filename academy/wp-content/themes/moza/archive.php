<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Moza
 */
get_header(); ?>
<section class="archive-area <?php if( ! is_active_sidebar ('sidebar-1') ): ?>block-content-css<?php endif; ?>" id="content">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="blog-title">
				<?php
					the_archive_title( '<h3 class="heading-title">', '</h3>' );
					the_archive_description( '<div class="archive-description">', '</div>' );
				?>
				</div>
				<?php if ( have_posts() ) : ?>
					<div class="row masonry-post">
					<?php
					/* Start the Loop */
					while ( have_posts() ) :
						the_post();

						/*
						 * Include the Post-Type-specific template for the content.
						 * If you want to override this in a child theme, then include a file
						 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
						 */
						get_template_part( 'template-parts/content', 'archive' );

					endwhile; ?>
					</div> 
					<?php

					the_posts_navigation();

				else :

					get_template_part( 'template-parts/content', 'none' );

				endif;
				?>
			</div>
		</div>
	</div>
</section>	

<?php
get_footer();
