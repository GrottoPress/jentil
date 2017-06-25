<?php

/**
 * Sidebar
 *
 * The template for displaying sidebars. Sidebars display
 * with the `get_sidebar()` call.
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
 * Layout columns
 *
 * @since 		Jentil 0.1.0
 */
$jentil_columns = Utilities\Template\Template::instance()->get( 'layout' )->column();

/**
 * Do not show sidebars if page layout is one column
 * 
 * @since 		Jentil 0.1.0
 */
if ( 'one-column' == $jentil_columns ) {
	return;
}

/**
 * Primary Sidebar
 * 
 * @since 		Jentil 0.1.0
 */
if ( is_active_sidebar( 'primary-widget-area' ) ) { ?>
	<div id="primary-widget-area-wrap" class="sidebar-wrap p">
		<aside id="primary-widget-area" class="site-sidebar hobbit widget-area" itemscope itemtype="http://schema.org/WPSideBar">
			<?php dynamic_sidebar( 'primary-widget-area' ); ?>
		</aside><!-- #primary -->
	</div>
<?php }

/**
 * Secondary sidebar
 * 
 * @since 		Jentil 0.1.0
 */
if ( 'three-columns' == $jentil_columns ) {
	if ( is_active_sidebar( 'secondary-widget-area' ) ) { ?>
		<div id="secondary-widget-area-wrap" class="sidebar-wrap p">
			<aside id="secondary-widget-area" class="site-sidebar hobbit widget-area" itemscope itemtype="http://schema.org/WPSideBar">
				<?php dynamic_sidebar( 'secondary-widget-area' ); ?>
			</aside><!-- #secondary -->
		</div>
	<?php }
}