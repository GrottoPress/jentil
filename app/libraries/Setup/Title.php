<?php

/**
 * Title Tag
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
 * Title Tag
 *
 * @since 0.1.0
 */
final class Title extends Setup {
    /**
     * Run setup
     *
     * @since 0.1.0
     * @access public
     */
    public function run() {
        \add_action( 'after_setup_theme', [ $this, 'add_support' ] );
        \add_action( 'wp_head', [ $this, 'render' ] );
    }

    /**
     * Title tag.
     * 
     * Add support for the title tag.
     *
     * @since 0.1.0
     * @since WordPress 4.1
     *
     * @access public
     * 
     * @action after_setup_theme
     */
    public function add_support() {
        if ( ! \function_exists( 'wp_get_document_title' ) ) {
            return;
        }
    
        \add_theme_support( 'title-tag' );
    }

    /**
     * Title tag
     * 
     * Add backwards compatibility for \wp_title().
     *
     * @deprecated WordPress 4.4
     * @see https://make.wordpress.org/core/2015/10/20/document-title-in-4-4/
     *
     * @since 0.1.0
     * @access public
     * 
     * @action wp_head
     */
    public function render() {
        if ( \function_exists( 'wp_get_document_title' ) ) {
            return;
        }
    
        echo '<title itemprop="name">'; \wp_title(); echo '</title>';
    }
}
