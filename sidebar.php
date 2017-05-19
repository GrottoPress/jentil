<?php

/**
 * Sidebar
 *
 * The template for displaying sidebars.
 *
 * @link			https://jentil.grottopress.com
 * @package			jentil
 * @since			Jentil 0.1.0
 */

global $jentil_template;

$column = $jentil_template->get( 'layout' )->column();

/**
 * Do not show sidebars if page layout is one column
 * 
 * @since 		Jentil 0.1.0
 */
if ( 'one-column' == $column ) {
	return;
}

/**
 * Primary Sidebar
 * 
 * @since 		Jentil 0.1.0
 */
if ( is_active_sidebar( 'primary-widget-area' ) ) { ?>
	<div id="primary-widget-area-wrap" class="sidebar-wrap margin-vertical">
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
if ( 'three-columns' == $column ) {
	if ( is_active_sidebar( 'secondary-widget-area' ) ) { ?>
		<div id="secondary-widget-area-wrap" class="sidebar-wrap margin-vertical">
			<aside id="secondary-widget-area" class="site-sidebar hobbit widget-area" itemscope itemtype="http://schema.org/WPSideBar">
				<?php dynamic_sidebar( 'secondary-widget-area' ); ?>
			</aside><!-- #secondary -->
		</div>
	<?php }
}