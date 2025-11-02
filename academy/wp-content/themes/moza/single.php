<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Moza
 */
if(is_active_sidebar('sidebar-1')){
	$moza_column = 8;
}else{
	$moza_column = 12;
}
get_header(); ?>
<section class="single-area <?php if( ! is_active_sidebar('sidebar-1')): ?>block-content-css<?php endif; ?>" id="content">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="blog-title">
					<h3 class="heading-title"><?php  the_title(); ?></h3>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-<?php echo esc_attr($moza_column); ?>">
				<?php
					while ( have_posts() ) :
						the_post();

						get_template_part( 'template-parts/content', get_post_type() );
						the_post_navigation(); 
						// If comments are open or we have at least one comment, load up the comment template.
						if ( comments_open() || get_comments_number() ) :
							comments_template();
						endif;

					endwhile; // End of the loop.
				?>
			</div>
			<?php if(is_active_sidebar('sidebar-1')): ?>
			<div class="col-lg-4">
				<?php get_sidebar(); ?>
			</div>
			<?php endif; ?>
		</div>
	</div>
</div>
<?php
get_footer();
