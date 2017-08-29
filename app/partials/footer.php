<?php

/**
 * Footer Template
 *
 * This contains code that would be included in
 * other templates via the `\get_footer()` call.
 *
 * @package GrottoPress\Jentil
 * @since 0.1.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kus Adusei
 */

declare ( strict_types = 1 );

if ( ! \defined( 'WPINC' ) ) {
    die;
}

						/**
						 * @action jentil_after_after_content
						 *
						 * @since 0.1.0
						 */
						\do_action( 'jentil_after_after_content' );
						
						/**
						 * Load comments
						 *
						 * @since 0.1.0
						 */
						if ( \Jentil()->utilities()->page()->is( 'singular' ) ) {
							if ( 'open' == \get_option( 'default_ping_status' ) ) {
								echo '<!--'; \trackback_rdf(); echo '-->';
							}
							
							\Jentil()->utilities()->loader()->load_comments();
						} ?>
						
					</main><!-- #content -->
				</div><!-- #content-wrap -->

				<?php
				/**
				 * Load sidebars
				 *
				 * @since 0.1.0
				 */
				\Jentil()->utilities()->loader()->load_partial( 'sidebar' ); ?>

			</div><!-- #main -->
			
			<?php
			/**
			 * @action jentil_before_footer
			 *
			 * @since 0.1.0
			 */
			\do_action( 'jentil_before_footer' ); ?>

			<footer id="footer" class="site-footer hobbit p" itemscope itemtype="http://schema.org/WPFooter">
			
				<?php
				/**
				 * @action jentil_inside_footer
				 *
				 * @since 0.1.0
				 */
				\do_action( 'jentil_inside_footer' ); ?>
				
			</footer><!-- #footer -->
			
			<?php
			/**
			 * @action wp_footer
			 *
			 * @since 0.1.0
			 */
			\wp_footer(); ?>
		
		</div><!-- #wrap -->
	</body>
</html>
