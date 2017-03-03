<?php

/**
 * Search
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

/**
 * Search
 *
 * @link			https://jentil.grotttopress.com
 * @package			jentil
 * @subpackage 	    jentil/includes
 * @since			jentil 0.1.0
 */
final class Search extends MagPack\Utilities\Singleton {
    /**
	 * Constructor
	 *
	 * @since       MagPack 0.1.0
	 * @access      public
	 */
	protected function __construct() {}

    /**
     * Search form
     *
     * @see         https://developers.google.com/structured-data/slsb-overview
     *
     * @since       Jentil 0.1.0
     * @access      public
     *
     * @filter      get_search_form
     */
    public function form( $searchform ) {
        $searchform = '<div class="search-wrap" itemscope itemtype="http://schema.org/WebSite" itemref="">
            <meta id="meta-search-website" itemprop="url" content="' . home_url( '/' ) . '"/>

            <form role="search" method="get" class="form search self-clear" action="' . esc_attr( home_url( '/' ) ) . '" itemprop="potentialAction" itemscope itemtype="http://schema.org/SearchAction" itemref="">
                <meta id="meta-search-target" itemprop="target" content="' . esc_attr( home_url( '/' ) ) . '?s={s}" />
                <label class="screen-reader-text" for="s">' . esc_html__( 'Search for:', 'jentil' ) . '</label>

                <input itemprop="query-input" type="search" placeholder="' . esc_attr__( 'Search', 'jentil' ) . '" class="input search" name="s" id="s" value="';

                    if ( ( $query = get_search_query() ) ) {
                        $searchform .= $query;
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
     * Render search form
     *
     * @since       Jentil 0.1.0
	 * @access      public
	 *
	 * @action      jentil_inside_header
     */
    public function render() {
    	get_search_form();
    }
}