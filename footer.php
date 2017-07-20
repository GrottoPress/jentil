<?php

/**
 * Footer
 *
 * The theme's footer template. This contains code that would be
 * included in other templates via the `get_footer()` call.
 *
 * @link			https://jentil.grottopress.com
 * @package			jentil
 * @since			Jentil 0.1.0
 */

if ( ! defined( 'WPINC' ) ) {
    die;
}

use GrottoPress\Jentil\Utilities;

						/**
						 * Do action after content
						 * 
						 * @action		jentil_after_after_content
						 *
						 * @since       Jentil 0.1.0
						 */
						do_action( 'jentil_after_after_content' );
						
						if ( Utilities\Template\Template::instance()->is( 'singular' ) ) {
							the_post();
							
							if ( 'open' == get_option( 'default_ping_status' ) ) {
								echo '<!--'; trackback_rdf(); echo '-->';
							}
							
							comments_template( '', true );
							
							rewind_posts();
						} ?>
						
					</main><!-- #content -->
				</div><!-- #content-wrap -->

				<?php
				/**
				 * Include templates sidebar
				 *
				 * @since		Jentil 0.1.0
				 */
				get_sidebar(); ?>

			</div><!-- #main -->
			
			<?php
			/**
			 * Do action before footer
			 * 
			 * @action		jentil_before_footer
			 *
			 * @since       Jentil 0.1.0
			 */
			do_action( 'jentil_before_footer' ); ?>

			<footer id="footer" class="site-footer hobbit p" itemscope itemtype="http://schema.org/WPFooter">
			
				<?php
				/**
				 * Do action inside footer
				 * 
				 * @action		jentil_inside_footer
				 *
				 * @since       Jentil 0.1.0
				 */
				do_action( 'jentil_inside_footer' ); ?>
				
			</footer><!-- #footer -->
			
			<?php
			/**
			 * Do the WordPress footer action
			 * 
			 * This is required by most plugins to include their
			 * own code into the footer of the theme.
			 * 
			 * @action		wp_footer
			 *
			 * @since       Jentil 0.1.0
			 */
			wp_footer(); ?>
		
		</div><!-- #wrap -->
	</body>
</html>