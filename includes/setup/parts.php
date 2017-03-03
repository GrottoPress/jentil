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

namespace GrottoPress\Jentil\Setup;

if ( ! defined( 'WPINC' ) ) {
    wp_die( esc_html__( 'Do not load this file directly!', 'jentil' ) );
}

use GrottoPress\MagPack;
use GrottoPress\Jentil\Utilities;

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
final class Parts extends MagPack\Utilities\Singleton {
    /**
     * Template
	 *
	 * @since       MagPack 0.1.0
	 * @access      protected
	 *
	 * @var    \GrottoPress\Jentil\Utilities\Template\Template      $template       Template
	 */
	protected $template;

    /**
     * Pagination
     *
     * @since       MagPack 0.1.0
     * @access      protected
     *
     * @var     \GrottoPress\MagPack\Utilities\Pagination\Pagination    $pagination     Pagination
     */
    protected $pagination;

	/**
	 * Constructor
	 *
	 * @since       MagPack 0.1.0
	 * @access      public
	 */
	protected function __construct() {
	    $this->template = new Utilities\Template\Template();
        $this->pagination = new MagPack\Utilities\Pagination\Pagination();
	}

    /**
     * Title tag
     * 
     * Add backwards compatibility for wp_title().
     *
     * @deprecated  WordPress 4.4
     * @see         https://make.wordpress.org/core/2015/10/20/document-title-in-4-4/
     *
     * @since       jentil 0.1.0
     * @access      public
     * 
     * @action      wp_head
     */
    public function render_title() {
        if ( function_exists( 'wp_get_document_title' ) ) {
            return;
        }
    
        echo '<title itemprop="name">'; wp_title(); echo '</title>';
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
                    <button type="submit" class="button submit">
                        <span class="fa fa-search" aria-hidden="true"></span> <span class="search-button-text">' . esc_html__( 'Search', 'jentil' ) . '</span>
                    </button>
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
    	$logo = new Utilities\Logo();

    	echo $logo->markup();
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
    	echo '<nav role="navigation" class="site-navigation main-navigation screen-min-wide">
    	    <div class="screen-reader-text skip-link">
    	        <a href="#menu-screen-max-wide">' . esc_html__( 'Skip to content', 'jentil' ) . '</a>
            </div>';

            wp_nav_menu( array( 'theme_location' => 'primary-menu' ) );

        echo '</nav>';
    }

    /**
     * Mobile header menu button
     *
     * @since       Jentil 0.1.0
	 * @access      public
	 *
	 * @action      jentil_inside_header
     */
    public function mobile_header_menu_toggle() {
    	$status = isset( $_GET['menu'] ) ? sanitize_key( $_GET['menu'] ) : 'off';
    	
    	echo '<div class="menu-toggle screen-max-wide">
    	    <div class="screen-reader-text">
    	        <a href="#menu-screen-max-wide">' . esc_html__( 'Skip to menu', 'jentil' ) . '</a>
            </div>

            <div class="menu-mobile-menu-container">
    	        <ul class="menu">
    	            <li class="menu-item hamburger">
    	                <a href="' . esc_url( add_query_arg( array(
    		                'menu' => ( $status == 'off' ? 'on' : 'off' ),
    	                ), $this->pagination->page_url( true, true ) ) ) . '"><span class="fa fa fa-bars" aria-hidden="true"></span> ' . esc_html__( 'Menu', 'jentil' ) . '</a>
    	            </li>
    	        </ul>
            </div>
        </div>';
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
        
        echo '<div id="menu-screen-max-wide" class="navigation-wrap screen-max-wide"' . ( $status == 'off' ? ' style="display:none;"' : '' ) . '>
            <nav role="navigation" class="site-navigation main-navigation">';

            get_search_form(); wp_nav_menu( array( 'theme_location' => 'primary-menu' ) );

        echo '</nav>
        </div>';
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
    	if ( $this->template->is( 'front_page' ) && ! $this->pagination->is_paged() ) {
    	    return;
    	}

        $args = array(
            'before' => esc_html__( 'Path: ', 'jentil' ),
        );

    	echo $this->template->breadcrumbs( $args )->trail();
    }

    /**
     * Single post after title
     *
     * Used for single posts when using the index.php template.
     *
     * @since       Jentil 0.1.0
	 * @access      public
	 *
	 * @filter      jentil_singular_after_title
     */
    public function single_post_after_title( $output, $id, $separator ) {
    	if ( ! $this->template->is( 'singular', 'post' ) ) {
    	    return $output;
    	}

    	$magpack_post = new MagPack\Utilities\Post\Post( $id );
    	$avatar = $magpack_post->info( 'avatar__40', '' )->list();
    	$author = $magpack_post->info( 'author_link', '' )->list();

    	if ( ! empty( $avatar ) ) {
    	    $output .= $avatar;
    	}

    	if ( ! empty( $author ) ) {
    	    $output .= '<p>' . $author . '</p>';
    	}

    	$output .= '<p>' . $magpack_post->info( 'published_date, published_time, comments_link' )->list() . '</p>

        <div class="self-clear"></div>';

        return $output;
    }

    /**
     * Single post after title
     *
     * Replicates the functionality above for when
     * using the single.php template
     *
     * @since       Jentil 0.1.0
     * @access      public
     *
     * @action      jentil_after_title
     */
    public function single_post_after_title_echo() {
        if ( ! $this->template->is( 'singular', 'post' ) ) {
            return;
        }

        global $post;

        $magpack_post = new MagPack\Utilities\Post\Post( $post->ID );
        $avatar = $magpack_post->info( 'avatar__40', '' )->list();
        $author = $magpack_post->info( 'author_link', '' )->list();

        $output = '<div class="entry-meta after-title self-clear">';

        if ( ! empty( $avatar ) ) {
            $output .= $avatar;
        }

        if ( ! empty( $author ) ) {
            $output .= '<p>' . $author . '</p>';
        }

        $output .= '<p>'
            . $magpack_post->info( 'published_date, published_time, comments_link' )->list()
        . '</p>

        </div>';

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
    	$colophon = new Utilities\Colophon();

        if ( ! ( $mod = $colophon->mod() ) && ! $this->template->is( 'customize_preview' ) ) {
            return '';
        }

    	echo '<div id="colophon"><small>' . $mod . '</small></div><!-- #colophon -->';
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
        global $post;

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

            if ( has_shortcode( $post->post_content, 'magpack_posts' ) ) {
                $classes[] = 'has-magpack-posts';
            }
    	}

    	return $classes;
    }

    /**
     * Post parent link
     *
     * @since       Jentil 0.1.0
     * @access      public
     *
     * @action      jentil_before_title
     */
    public function post_parent_link() {
        global $post;

        if ( ! $post->post_parent ) {
            return;
        }

        echo '<h4 class="parent entry-title">
            <a href="' . get_permalink( $post->post_parent ) . '">
                <span class="meta-nav">&laquo;</span> ' . get_the_title( $post->post_parent )
            . '</a>
        </h4>';
    }

    /**
     * Attachment
     *
     * @since       Jentil 0.1.0
     * @access      public
     *
     * @action      jentil_before_content
     */
    public function attachment() {
        if ( ! $this->template->is( 'attachment' ) ) {
            return;
        }

        remove_filter( 'the_content', 'prepend_attachment' );

        global $post;

        if ( wp_attachment_is_image( $post->ID ) ) {
            get_template_part( 'parts/attachment', 'image' );
        } elseif ( wp_attachment_is( 'audio', $post->ID ) ) {
            get_template_part( 'parts/attachment', 'audio' );
        } elseif ( wp_attachment_is( 'video', $post->ID ) ) {
            get_template_part( 'parts/attachment', 'video' );
        } else {
            get_template_part( 'parts/attachment' );
        }
    }
}