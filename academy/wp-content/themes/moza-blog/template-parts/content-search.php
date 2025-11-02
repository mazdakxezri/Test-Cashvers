<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Moza
 */
if ( ! is_singular( ) ) : ?>
<div class="post-item">
	<div class="post-wrapper card-layout">
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<div class="post-inner">
				<div class="image-outer-wrapper">
					<div class="image-wrapper">
						<?php if(has_post_thumbnail() ): 
							moza_post_thumbnail(); 
						else : ?>
				        <img src="<?php echo esc_url (get_stylesheet_directory_uri() . '/assets/img/01.jpg' ); ?>" alt="<?php the_title(); ?>">
				        <?php endif; ?>
					</div>
				</div>
				<div class="content-wrapper">
					<div class="content-inner">
						<?php
						if ( is_singular() ) :
							the_title( '<h3 class="title">', '</h3>' );
						else :
							the_title( '<h3 class="title"><a class="title-animation-underline" href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' );
						endif; ?>
						<div class="meta-wrapper">
							<div class="post-author-wrapper">
								<div class="author-wrapper">
									<?php moza_blog_posted_by(); ?>
								</div>
							</div>
							<div class="comments-wrapper">
								<span class="comments">
									<?php moza_blog_comments(); ?>          
								</span>
							</div>
						</div>
						<div class="excerpt"><?php the_excerpt(); ?></div>
					</div>
				</div>
			</div>
			<div class="footer-wrap">
				<div class="terms-wrapper">
					<?php moza_blog_category(); ?>
				</div>
			</div>
		</article>
	</div>
</div>
<?php else: ?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="meta-wrapper">
		<div class="post-author-wrapper">
			<div class="author-wrapper">
				<?php moza_blog_posted_by(); ?>
			</div>
		</div>
	</div>
	<div class="image-wrapper">
		<?php if(has_post_thumbnail() ): 
			moza_post_thumbnail(); 
	    endif; ?>
	</div>
	<div class="single-content">
		<?php

		if(is_single( )){
			the_content(
				sprintf(
					wp_kses(
						/* translators: %s: Name of current post. Only visible to screen readers */
						__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'moza' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					wp_kses_post( get_the_title() )
				)
			);
		}

		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'moza' ),
				'after'  => '</div>',
			)
		);
		?>
		<div class="footer-wrap">
			<div class="terms-wrapper">
				<?php moza_blog_category(); ?>
			</div>
		</div>
	</div>
</article>
<?php endif; ?>