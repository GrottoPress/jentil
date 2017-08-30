<?php

/**
 * Search
 *
 * @package GrottoPress\Jentil\Setup
 * @since 0.1.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kus Adusei
 */

declare ( strict_types = 1 );

namespace GrottoPress\Jentil\Setup;

if ( ! \defined( 'WPINC' ) ) {
    die;
}

/**
 * Search
 *
 * @since 0.1.0
 */
final class Search extends Setup {
    /**
     * Run setup
     *
     * @since 0.1.0
     * @access public
     */
    public function run() {
        \add_action( 'get_search_form', [ $this, 'form' ] );
        \add_action( 'jentil_inside_header', [ $this, 'render' ] );
        \add_action( 'jentil_before_content', [ $this, 'render_on_search_page' ] );
    }

    /**
     * Search form
     *
     * @see https://developers.google.com/structured-data/slsb-overview
     *
     * @since 0.1.0
     * @access public
     *
     * @filter get_search_form
     */
    public function form( string $searchform ): string {
        $home_url = \home_url( '/' );

        $searchform = '<div class="search-wrap" itemscope itemtype="http://schema.org/WebSite">
            <meta itemprop="url" content="' . $home_url . '"/>

            <form role="search" method="get" class="form search self-clear" action="' . $home_url . '" itemprop="potentialAction" itemscope itemtype="http://schema.org/SearchAction">
                <meta itemprop="target" content="' . $home_url . '?s={s}" />
                <label><span class="screen-reader-text">' . \esc_html__( 'Search for:', 'jentil' ) . '</span>

                <input itemprop="query-input" type="search" placeholder="' . \esc_attr__( 'Search', 'jentil' ) . '" class="input search" name="s" value="';

                    if ( ( $query = \get_search_query() ) ) {
                        $searchform .= $query;
                    }

                $searchform .= '" required /></label>

                <button type="submit" class="button submit">
                    <span class="fa fa-search" aria-hidden="true"></span> <span class="search-button-text icon-text">' . \esc_html__( 'Search', 'jentil' ) . '</span>
                </button>
            </form>
        </div>';

        return $searchform;
    }

    /**
     * Render search form on search page
     *
     * @since 0.1.0
     * @access public
     *
     * @action jentil_before_content
     */
    public function render_on_search_page() {
        if ( ! $this->jentil->utilities()->page()->is( 'search' ) ) {
            return;
        }

        $this->render();
    }

    /**
     * Render search form
     *
     * @since 0.1.0
     * @access public
     *
     * @action jentil_inside_header
     */
    public function render() {
        \get_search_form();
    }
}
