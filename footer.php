<?php

/**
 * Footer
 *
 * The theme's footer template. This contains code that would be
 * included in other templates via the `get_footer()` call.
 *
 * @link			https://jentil.grottopress.com
 * @package			jentil
 * @since			jentil 1.0.0
 */

?>
				</div><!-- #main -->
			</div><!-- #main-wrap -->
			
			<?php do_action( 'jentil_before_footer' ); ?>
			
			<div id="footer-wrap">
				<footer id="footer" class="site-footer hobbit self-clear" itemscope itemtype="http://schema.org/WPFooter">
				
					<?php do_action( 'jentil_inside_footer' ); ?>
					
				</footer><!-- #footer -->
    		</div><!-- #footer-wrap -->
    	</div><!-- #wrapper -->
		
		<?php wp_footer(); ?>
		
	</body>
</html>