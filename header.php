<?php

/**
 * Header
 *
 * The theme's header markup. This contains code that would be
 * included in other templates via the `get_header()` call.
 *
 * @link		    https://jentil.grottopress.com
 * @package	    	jentil
 * @since	    	jentil 0.1.0
 */

?><!DOCTYPE html>
<html data-site-name="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" data-site-decription="<?php echo esc_attr( get_bloginfo( 'description' ) ); ?>" <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php esc_attr( bloginfo( 'charset' ) ); ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		
		<!--[if IE]>
			<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<![endif]-->
		
		<link rel="profile" href="http://gmpg.org/xfn/11" />
		
		<?php if ( is_singular() && pings_open( get_queried_object() ) ) { ?>
    		<link rel="pingback" href="<?php esc_attr( bloginfo( 'pingback_url' ) ); ?>" />
    	<?php } ?>
    	
    	<!--[if lt IE 9]>
      		<script src="<?php echo esc_attr( get_template_directory_uri() ); ?>/dependencies/html5shiv/html5shiv.min.js"></script>
      		<script src="<?php echo esc_attr( get_template_directory_uri() ); ?>/dependencies/respondjs/respond.min.js"></script>
    	<![endif]-->
		
		<?php wp_head(); ?>
		
	</head>
	
	<body <?php body_class(); ?>>
		
		<?php do_action( 'jentil_before_header' ); ?>
		
		<div id="wrapper" class="hfeed site">
			<div id="header-wrap">
				<header id="header" class="site-header hobbit" itemscope itemtype="http://schema.org/WPHeader">
					
					<?php do_action( 'jentil_inside_header' ); ?>
					
				</header><!-- #header -->
			</div><!-- #header-wrap -->
			
			<?php do_action( 'jentil_after_header' ); ?>
			
			<div id="main-wrap">
				<div id="main" class="self-clear">