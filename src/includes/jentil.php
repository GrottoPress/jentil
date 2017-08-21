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
     * @var string $path Theme directory path.
     */
    private $path;

    /**
     * Theme directory URI
     *
     * @since 0.1.0
     * @access private
     * 
     * @var string $url Theme directory URI.
     */
    private $url;

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
        $this->url = \get_template_directory_uri();
        $this->path = \get_template_directory();

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
     * @since 0.1.0
     * @access public
     *
     * @return GrottoPress\Jentil\Setup\Setup Setup.
     */
    public function setup( string $setup ): Setup\Setup {
        return $this->setup[ $setup ];
    }

    /**
     * Path
     *
     * @since 0.1.0
     * @access public
     *
     * @return string Path.
     */
    public function path(): string {
        return $this->path;
    }

    /**
     * URL
     *
     * @since 0.1.0
     * @access public
     *
     * @return string URL.
     */
    public function url(): string {
        return $this->url;
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
}
