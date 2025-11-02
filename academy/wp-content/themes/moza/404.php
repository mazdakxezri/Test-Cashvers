<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Moza
 */

get_header();
?>
<section id="blog" class="error-page">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="blog-title">
					<h3 class="heading-title"><?php esc_html_e('404 Error Page','moza'); ?></h3>
				</div>
				<div class="text-center">
					<h2><?php esc_html_e('Page not found!','moza'); ?></h2>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="button error"><?php esc_html_e('Back To Home','moza'); ?></a>
				</div>
			</div>
		</div>
	</div>
</section>
<?php 
get_footer();
