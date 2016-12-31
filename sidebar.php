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

$template = new \GrottoPress\Jentil\Template\Template();
$layout = $template->layout()->get();
$layout_column = $template->layout()->column();

/**
 * Do not show sidebars if page layout is one_column
 */
if ( 'one-column' == $layout_column ) {
	return;
}

/**
 * Primary Sidebar
 */
if ( is_active_sidebar( 'primary-widget-area' ) ) { ?>
	<div id="primary" class="site-sidebar hobbit widget-area" itemscope itemtype="http://schema.org/WPSideBar">
		<?php dynamic_sidebar( 'primary-widget-area' ); ?>
	</div><!-- #primary -->
<?php }

/**
 * Secondary sidebar
 */
if ( 'three-columns' == $layout_column ) {
	if ( is_active_sidebar( 'secondary-widget-area' ) ) { ?>
		<div id="secondary" class="site-sidebar hobbit widget-area" itemscope itemtype="http://schema.org/WPSideBar">
			<?php dynamic_sidebar( 'secondary-widget-area' ); ?>
		</div><!-- #secondary -->
	<?php }
}