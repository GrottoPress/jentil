<?php

/**
 * Filesystem
 *
 * @package GrottoPress\Jentil\Utilities
 * @since 0.1.0
 *
 * @author GrottoPress (https://www.grottopress.com)
 * @author N Atta Kus Adusei (https://twitter.com/akadusei)
 */

declare ( strict_types = 1 );

namespace GrottoPress\Jentil\Utilities;

if ( ! \defined( 'WPINC' ) ) {
    die;
}

/**
 * Filesystem
 * 
 * @since 0.1.0
 */
final class Filesystem {
    /**
     * Utilities
     *
     * @since 0.1.0
     * @access private
     * 
     * @var GrottoPress\Jentil\Utilites\Utilities $utilities Utilities.
     */
    private $utilities;

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
     * Constructor
     * 
     * @var GrottoPress\Jentil\Utilities\Utilities $utilities Utilities.
     *
     * @since 0.1.0
     * @access public
     */
    public function __construct( Utilities $utilities ) {
        $this->utilities = $utilities;

        $this->dir_url = \get_template_directory_uri();
        $this->dir_path = \get_template_directory();
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
    public function scripts_dir( string $type, string $append = '', string $form = '' ): string {
        return $this->_dir( $type, '/dist/assets/scripts', $append, $form );
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
    private function _dir( string $type, string $prepend = '', string $append = '', string $form = '' ): string {
        $relative = $prepend . $append;

        if ( 'relative' == $form ) {
            return $relative;
        }

        return $this->{'dir_' . $type} . $relative;
    }
}
