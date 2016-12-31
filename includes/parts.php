<?php

/**
 * Template Parts
 *
 * This defines template functions and parts to be
 * hooked into the theme.
 *
 * @link            https://jentil.grotttopress.com
 * @package		    jentil
 * @subpackage 	    jentil/includes
 * @since		    Jentil 0.1.0
 */

namespace GrottoPress\Jentil;

/**
 * Template
 *
 * This defines template functions and parts to be
 * hooked into the theme.
 *
 * @link			https://jentil.grotttopress.com
 * @package			jentil
 * @subpackage 	    jentil/includes
 * @since			jentil 0.1.0
 */
class Parts {
    /**
     * Template
	 *
	 * @since       MagPack 0.1.0
	 * @access      private
	 * 
	 * @var         \GrottoPress\Jentil\Template\Template         $template       Template
	 */
	private $template;
	
	/**
	 * Constructor
	 *
	 * @since       MagPack 0.1.0
	 * @access      public
	 */
	public function __construct() {
	    $this->template = new \GrottoPress\Jentil\Template\Template();
	}
    
    /**
     * Microdata schema
     * 
	 * Use schema.org's vocabulary to provide microdata
	 * markup for this theme.
	 * 
	 * @see         http://www.paulund.co.uk/add-schema-org-wordpress
	 *
	 * @since       Jentil 0.1.0
	 * @access      public
	 * 
	 * @filter      language_attributes
	 */
    public function html_microdata( $output ) {
    	$output .= ' itemscope itemtype="http://schema.org/';
        
        if ( $this->template->is( 'author' ) ) {
            $output .= 'ProfilePage';
        } elseif ( $this->template->is( 'search' ) ) {
            $output .= 'SearchResultsPage';
        } else {
            $output .= 'WebPage';
        }
        
    	$output .= '" ';
    
    	return $output;
    }
    
    /**
     * Search form
     *
     * @see 		https://developers.google.com/structured-data/slsb-overview
     * 
     * @since       Jentil 0.1.0
	 * @access      public
	 * 
	 * @filter      get_search_form
     */
    public function search_form( $searchform ) {
    	$searchform = '<div class="search-wrap" itemscope itemtype="http://schema.org/WebSite" itemref="">
    		<meta id="meta-search-website" itemprop="url" content="' . esc_attr( home_url( '/' ) ) . '"/>
    		<form role="search" method="get" class="form search self-clear" action="' . esc_attr( home_url( '/' ) ) . '" itemprop="potentialAction" itemscope itemtype="http://schema.org/SearchAction" itemref="">
    			<meta id="meta-search-target" itemprop="target" content="' . esc_attr( home_url( '/' ) ) . '?s={s}" />
    			<label class="screen-reader-text" for="s">' . esc_html__( 'Search for:', 'jentil' ) . '</label>
    			<input itemprop="query-input" type="search" placeholder="' . esc_attr__( 'Search', 'jentil' ) . '" class="input search" name="s" id="s" value="';
    			   
    				if ( get_search_query() ) {
    				    $searchform .= esc_attr( get_search_query() );
    				}
    				
    				$searchform .= '" required />
                    <input type="submit" class="input submit" value="' . esc_attr__( 'Search', 'jentil' ) . '" />
    		</form>
    	</div>';
        
    	return $searchform;
    }
    
    /**
     * Header logo
     * 
     * @todo        Fill in the img src with logo theme mod from
     *              customizer and custom logo since WP 4.6
     * 
     * @since       Jentil 0.1.0
	 * @access      public
	 * 
	 * @action      jentil_inside_header
     */
    public function header_logo() {
    	$logo = new Logo();
    	
    	echo $logo->get();
    }
    
    /**
     * Header search
     * 
     * @since       Jentil 0.1.0
	 * @access      public
	 * 
	 * @action      jentil_inside_header
     */
    public function header_search() {
    	get_search_form();
    }
    
    /**
     * Header menu
     * 
     * @since       Jentil 0.1.0
	 * @access      public
	 * 
	 * @action      jentil_inside_header
     */
    public function header_menu() {
    	echo '<nav role="navigation" class="site-navigation main-navigation menu-min-screen-920">
    	    <div class="screen-reader-text skip-link">
    	        <a href="#content">' . esc_html__( 'Skip to content', 'jentil' ) . '</a>
            </div>';
            
            wp_nav_menu( array( 'theme_location' => 'primary-menu' ) );
            
        echo '</nav>';
    }
    
    /**
     * Mobile header menu
     * 
     * @since       Jentil 0.1.0
	 * @access      public
	 * 
	 * @action      jentil_inside_header
     */
    public function mobile_header_menu() {
    	$status = isset( $_GET['menu'] ) ? sanitize_key( $_GET['menu'] ) : 'off';
    	$pagination = new \GrottoPress\MagPack\Pagination();
    	
    	echo '<div class="site-navigation main-navigation menu-max-screen-920">
    	    <div class="screen-reader-text skip-link">
    	        <a href="#content">' . esc_html__( 'Skip to content', 'jentil' ) . '</a>
            </div>
            
            <div class="menu-mobile-menu-container">
    	        <ul class="menu mobile-menu">
    	            <li class="menu-item hamburger">
    	                <a href="' . esc_url( add_query_arg( array(
    		                'menu' => ( $status == 'off' ? 'on' : 'off' ),
    	                ), $pagination->get_current_page_url( true, true ) ) ) . '">' . esc_html__( 'Menu', 'jentil' ) . '</a>
    	            </li>
    	        </ul>
            </div>
        </div>
    	
    	<nav role="navigation" class="menu-max-screen-920" ' . ( $status == 'off' ? ' style="display:none;"' : '' ) . '>';
            
            get_search_form(); wp_nav_menu( array( 'theme_location' => 'primary-menu' ) );
            
        echo '</nav>';
    }
    
    /**
     * Breadcrumbs
     * 
     * @since       Jentil 0.1.0
	 * @access      public
	 * 
	 * @action      jentil_before_title
     */
    public function breadcrumbs() {
    	if ( $this->template->is( 'front_page' ) && ! is_paged() ) {
    	    return;
    	}
    
        $args = array(
            'before' => esc_html__( 'Path: ', 'jentil' ),
        );
    	
    	$breadcrumbs = new \GrottoPress\MagPack\Breadcrumbs( $args );
    	echo $breadcrumbs->trail();
    }
    
    /**
     * Single post entry meta
     * 
     * @since       Jentil 0.1.0
	 * @access      public
	 * 
	 * @action      jentil_after_title
     */
    public function single_post_entry_meta() {
    	if ( ! $this->template->is( 'singular', 'post' ) ) {
    	    return;
    	}
    	
    	global $post;
    	
    	$magpack_post = new \GrottoPress\MagPack\Post\Post( $post->ID );
    	$avatar = $magpack_post->meta_list( 'avatar__50', '' );
    	$author = $magpack_post->meta_list( 'author_link', '' );
    	
    	$output = '<div class="entry-meta after-title self-clear">';
    	
    	if ( ! empty( $avatar ) ) {
    	    $output .= $avatar;
    	}
    	
    	if ( ! empty( $author ) ) {
    	    $output .= '<p>' . $author . '</p>';
    	}
    	
    	$output .= '<p>' . $magpack_post->meta_list( 'published_date, published_time, comments_link' ) . '</p></div>';
        
        echo $output;
    }
    
    /**
     * Footer Widget Area.
     *
     * @since       Jentil 0.1.0
     * @access      public
     * 
     * @action      jentil_inside_footer
     */
    public function footer_widgets() {
		if ( is_active_sidebar( 'footer-widget-area' ) ) { ?>
		    <div class="widget-area">
				<?php dynamic_sidebar( 'footer-widget-area' ); ?>
			</div><!-- .widget-area -->
		<?php }
    }
    
    /**
     * Colophon
     * 
     * @since       Jentil 0.1.0
     * @access      public
     * 
     * @action      jentil_inside_footer
     */
    public function colophon() {
    	$colophon = new Colophon();
    	
    	echo '<div id="colophon"><small>' . $colophon->get() . '</small></div><!-- #colophon -->';
    }
    
    /**
     * Body class
     * 
     * Add classes to <body>
     * 
     * @since       Jentil 0.1.0
     * @access      public
     * 
     * @filter      body_class
     */
    public function body_class( $classes ) {
        global $post; //, $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;
    	
    	if ( $this->template->is( 'singular' ) ) {
            if ( is_post_type_hierarchical( $post->post_type ) ) {
                if ( ! empty( $post->post_parent ) ) {
        			$parent_id = $post->post_parent;
        			
        			while ( $parent_id ) {
        				$page = get_post( $parent_id );
        				$classes[] = sanitize_title( $post_type . '-parent-' . $page->ID );
        				$parent_id = $page->post_parent;
        			}
        		}
    	    }
    	    
    	    $template = get_page_template_slug( $post->ID );
    	    
    	    if ( ! empty( $template ) ) {
    			$classes[] = sanitize_title( $template );
    		}
    	    
    	    if ( post_type_supports( $post->post_type, 'comments' ) ) {
        	    $classes[] = get_option( 'show_avatars' ) ? 'show-avatars' : 'hide-avatars';
        	    $classes[] = get_option( 'thread_comments' ) ? 'threaded-comments' : 'unthreaded-comments';
        	    $classes[] = comments_open( $post->ID ) ? 'comments-open' : 'comments-closed';
    	    }
    	}
    	
    	$template = new \GrottoPress\Jentil\Template\Template();
        $layout = $template->layout()->get();
        $layout_column = $template->layout()->column();
    	
    	if ( ! empty( $layout ) ) {
    		$classes[] = sanitize_title( 'layout-' . $layout );
    		$classes[] = sanitize_title( 'layout-' . $layout_column );
    	}
    	
    	return $classes;
    }
    
    /**
     * Dynamic styles
     * 
     * Add dynamic styles to theme
     *
     * @since       Jentil 0.1.0
     * @access      public
     * 
     * @action      wp_head
     */
    public function dynamic_styles() {
    	echo '<style type="text/css" media="all">
    		.comment.depth-' . absint( get_option( 'thread_comments_depth' ) ) . ' {
    			padding-bottom: 15px;
    		}
    	</style>';
    }
}