<?php
/**
 * Footer action
 * @package Moza
 */
function moza_footer_style_1(){ ?>
<footer class="footer-area">
	<div class="container">
		<div class="row">
			<div class="col-lg-6">
				<div class="copyright text-left">
					<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'moza' ) ); ?>">
						<?php
						/* translators: %s: CMS name, i.e. WordPress. */
						printf( esc_html__( 'Proudly powered by %s', 'moza' ), 'WordPress' );
						?>
					</a>
					<p><?php
						/* translators: 1: Theme name, 2: Theme author. */
						printf( esc_html__( 'Theme: %1$s by %2$s.', 'moza' ), 'moza', 'ashathemes' );
						?></p>
				</div>
			</div>
			<div class="col-lg-6">
				<ul class="social text-right">
                    <li><?php esc_html_e('Follow Us','moza'); 
                    $fb_url = get_theme_mod('fb_url');
					$tw_url = get_theme_mod('tw_url');
					$link_url = get_theme_mod('link_url');
					$instagram_url = get_theme_mod('instagram_url'); ?></li>
                    <li><a href="<?php echo esc_url($fb_url); ?>"><i class="fa fa-facebook"></i></a></li>
                    <li><a href="<?php echo esc_url($tw_url); ?>"><i class="fa fa-twitter"></i></a></li>
                    <li><a href="<?php echo esc_url($link_url); ?>"><i class="fa fa-linkedin"></i></a></li>
                    <li><a href="<?php echo esc_url($instagram_url); ?>"><i class="fa fa-instagram"></i></a></li>
                </ul>	
			</div>
		</div>
	</div>
</footer>
<?php }
add_action('moza_footer_style','moza_footer_style_1');