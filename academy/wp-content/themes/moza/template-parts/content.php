<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Moza
 */
if ( ! is_singular( ) ) : ?>

<div class="col-lg-4">
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<div class="blog-singele-box">
            <div class="blog-thumb">
            	<?php if(has_post_thumbnail() ): 
              	moza_post_thumbnail(); 
                else : ?>
		        <img src="<?php echo esc_url (get_stylesheet_directory_uri() . '/assets/img/01.jpg' ); ?>" alt="<?php the_title(); ?>">
		        <?php endif; ?>
                <div class="blog-content">
	                <div class="blog-date">
	                  <span><?php moza_posted_on(); ?></span>
	                </div>
	                <div class="blog-desc"><?php the_excerpt(); ?></div>
	                <div class="blog-btn">
	                  <?php echo'<a href="'.esc_url ( get_the_permalink( $post->ID ) ).'">'.esc_html__('Click Here','moza').'</a>'; ?>
	                </div>
	            </div>
            </div>
            <div class="blog-meta-title">
                <?php
					if ( is_singular() ) :
						the_title( '<h2>', '</h2>' );
					else :
						the_title( '<h2><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
					endif; 
				?>
            </div>
        </div>
	</article>
</div>
	
<?php else: ?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if ( has_post_thumbnail () ): ?>
		<?php moza_post_thumbnail(); ?>
	<?php endif; ?>
	<div class="post-content">
		<?php if ( 'post' === get_post_type() ) : ?>
			<div class="entry-meta">
				<?php moza_posted_on(); ?>
			</div><!-- .entry-meta -->
		<?php endif; ?>

		<header class="entry-header">
			<?php
			if ( is_singular() ) :
				the_title( '<h1 class="entry-title">', '</h1>' );
			else :
				the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			endif; ?>
		</header><!-- .entry-header -->

		<div class="entry-content">
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
			}else{
				the_excerpt();
			}
			wp_link_pages(
				array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'moza' ),
					'after'  => '</div>',
				)
			);
			?>
		</div><!-- .entry-content -->

		<?php if ( is_singular() ) : ?>
			<footer class="entry-footer">
				<?php moza_entry_footer(); ?>
			</footer><!-- .entry-footer -->
		<?php endif; ?>
	</div>
</article>
<?php endif; ?>