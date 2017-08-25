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
 * @author GrottoPress (https://www.grottopress.com)
 * @author N Atta Kus Adusei (https://twitter.com/akadusei)
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
						
						if ( \Jentil()->utilities()->page()->is( 'singular' ) ) {
							\the_post();
							
							if ( 'open' == \get_option( 'default_ping_status' ) ) {
								echo '<!--'; \trackback_rdf(); echo '-->';
							}
							
							\comments_template( '/src/app/partials/comments.php', true );
							
							\rewind_posts();
						} ?>
						
					</main><!-- #content -->
				</div><!-- #content-wrap -->

				<?php
				/**
				 * Include sidebars
				 *
				 * @since 0.1.0
				 */
				\get_template_part( 'src/app/partials/sidebar' ); ?>

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
