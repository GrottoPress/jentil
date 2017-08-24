<?php

/**
 * Jentil
 *
 * @package GrottoPress\Jentil
 * @since 0.1.0
 *
 * @author GrottoPress (https://www.grottopress.com)
 * @author N Atta Kus Adusei (https://twitter.com/akadusei)
 */

declare ( strict_types = 1 );

namespace GrottoPress\Jentil;

if ( ! \defined( 'WPINC' ) ) {
    die;
}

use GrottoPress\Jentil\Setup;
use GrottoPress\Jentil\Utilities\Utilities;
use FlorianWolters\Component\Util\Singleton\SingletonTrait;

/**
 * Jentil
 *
 * @since 0.1.0
 */
final class Jentil {
    /**
     * Import traits
     *
     * @since 0.1.0 Added SingletonTrait.
     */
    use SingletonTrait;

    /**
     * Theme directory path
     *
     * @since 0.1.0
     * @access private
     * 
     * @var string $dir_path Theme directory path.
     */
    private $dir_path;

    /**
     * Theme directory URI
     *
     * @since 0.1.0
     * @access private
     * 
     * @var string $dir_url Theme directory URI.
     */
    private $dir_url;

    /**
     * Theme setups
     *
     * @since 0.1.0
     * @access private
     * 
     * @var array $setup Setups.
     */
    private $setup = [];

    /**
     * Theme utilities
     *
     * @since 0.1.0
     * @access private
     * 
     * @var GrottoPress\Jentil\Utilities\Utilities $utilities Utilities.
     */
    private $utilities;

    /**
     * Theme Name
     *
     * @since 0.1.0
     */
    const NAME = 'Jentil';

    /**
     * Theme website URL
     *
     * @since 0.1.0
     */
    const WEBSITE = 'https://jentil.grottopress.com';

    /**
     * Theme documentation URL
     *
     * @since 0.1.0
     */
    const DOCUMENTATION = 'https://www.grottopress.com/docs/themes/jentil/';

    /**
     * Constructor
     *
     * @since 0.1.0
     * @access protected
     */
    protected function __construct() {
        $this->dir_url = \get_template_directory_uri();
        $this->dir_path = \get_template_directory();

        $this->utilities = new Utilities( $this );

        $this->setup['language'] = new Setup\Language( $this );
        $this->setup['styles'] = new Setup\Styles( $this );
        $this->setup['thumbnails'] = new Setup\Thumbnails( $this );
        $this->setup['feeds'] = new Setup\Feeds( $this );
        $this->setup['html5'] = new Setup\HTML5( $this );
        $this->setup['title'] = new Setup\Title( $this );
        $this->setup['layout'] = new Setup\Layout( $this );
        $this->setup['logo'] = new Setup\Logo( $this );
        $this->setup['archives'] = new Setup\Archives( $this );
        $this->setup['search'] = new Setup\Search( $this );
        $this->setup['menus'] = new Setup\Menus( $this );
        // $this->setup['breadcrumbs'] = new Setup\Breadcrumbs( $this );
        $this->setup['posts'] = new Setup\Posts( $this );
        $this->setup['comments'] = new Setup\Comments( $this );
        $this->setup['widgets'] = new Setup\Widgets( $this );
        $this->setup['colophon'] = new Setup\Colophon( $this );
        $this->setup['customizer'] = new Setup\Customizer\Customizer( $this );
        // $this->setup['metaboxes'] = new Setup\Metaboxes( $this );
        // $this->setup['updater'] = new Setup\Updater( $this );
    }

    /**
     * Run theme
     *
     * @since 0.1.0
     * @access public
     */
    public function run() {
        if ( ! $this->setup ) {
            return;
        }

        foreach ( $this->setup as $setup ) {
            $setup->run();
        }
    }

    /**
     * Utilities
     *
     * @since 0.1.0
     * @access public
     *
     * @return GrottoPress\Jentil\Utilities\Utilities Utilities.
     */
    public function utilities(): Utilities {
        return $this->utilities;
    }

    /**
     * Setup
     *
     * @var string $setup Setup type
     *
     * @since 0.1.0
     * @access public
     *
     * @return GrottoPress\Jentil\Setup\Setup Setup.
     */
    public function setup( string $setup ): Setup\Setup {
        return $this->setup[ $setup ];
    }

    /**
     * Get theme directory
     *
     * @var string $type 'path' or 'url'.
     * @var string $append Filepath to append to URL.
     *
     * @since 0.1.0
     * @access public
     *
     * @return string Path or URL.
     */
    public function dir( string $type, string $append = '' ): string {
        return $this->_dir( $type, '', $append );
    }

    /**
     * Get JavaScript directory
     *
     * @var string $type 'path' or 'url'.
     * @var string $append Filepath to append to URL.
     * @var string $form 'relative' or 'absolute'.
     *
     * @since 0.1.0
     * @access public
     *
     * @return string Path or URL.
     */
    public function js_dir( string $type, string $append = '', string $form = '' ): string {
        return $this->_dir( $type, '/dist/assets/javascript', $append, $form );
    }

    /**
     * Get CSS directory
     *
     * @var string $type 'path' or 'url'.
     * @var string $append Filepath to append to URL.
     * @var string $form 'relative' or 'absolute'.
     *
     * @since 0.1.0
     * @access public
     *
     * @return string Path or URL.
     */
    public function styles_dir( string $type, string $append = '', string $form = '' ): string {
        return $this->_dir( $type, '/dist/assets/styles', $append, $form );
    }

    /**
     * Get partials directory
     *
     * @var string $type 'path' or 'url'.
     * @var string $append Filepath to append to URL.
     * @var string $form 'relative' or 'absolute'.
     *
     * @since 0.1.0
     * @access public
     *
     * @return string Path or URL.
     */
    public function partials_dir( string $type, string $append = '', string $form = '' ): string {
        return $this->_dir( $type, '/src/includes/partials', $append, $form );
    }

    /**
     * Get templates directory
     *
     * @var string $type 'path' or 'url'.
     * @var string $append Filepath to append to URL.
     * @var string $form 'relative' or 'absolute'.
     *
     * @since 0.1.0
     * @access public
     *
     * @return string Path or URL.
     */
    public function templates_dir( string $type, string $append = '', string $form = '' ): string {
        return $this->_dir( $type, '/src/includes/templates', $append, $form );
    }

    /**
     * Get directory URL/path
     *
     * @var string $type 'path' or 'url'.
     * @var string $append Filepath to prepend to URL/path.
     * @var string $append Filepath to append to URL/path.
     * @var string $form 'relative' or 'absolute'.
     *
     * @since 0.1.0
     * @access private
     *
     * @return string Path or URL.
     */
    private function _dir( string $type, string $prepend = '', string $append = '', string $form = '' ) {
        $relative = $prepend . $append;

        if ( 'relative' == $form ) {
            return $relative;
        }

        return $this->{'dir_' . $type} . $relative;
    }
}
