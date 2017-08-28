<?php

/**
 * Loader
 *
 * Loads templates/partials.
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
 * Loader
 * 
 * @since 0.1.0
 */
final class Loader {
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
     * Constructor
     * 
     * @var GrottoPress\Jentil\Utilities\Utilities $utilities Utilities.
     *
     * @since 0.1.0
     * @access public
     */
    public function __construct( Utilities $utilities ) {
        $this->utilities = $utilities;
    }

    /**
     * Load partial
     *
     * @var string $slug Partial slug to load.
     * @var string $name Name to append to filename before loading.
     *
     * @since 0.1.0
     * @access public
     */
    public function load_partial( string $slug, string $name = '' ) {
        \get_template_part( \ltrim( $this->utilities->filesystem()->partials_dir( 'path', "/{$slug}", 'relative' ), '/' ), $name );
    }

    /**
     * Load template
     *
     * @var string $slug Template slug.
     * @var string $name Name to append to filename before loading.
     *
     * @since 0.1.0
     * @access public
     */
    public function load_template( string $slug, string $name = '' ) {
        \get_template_part( \ltrim( $this->utilities->filesystem()->templates_dir( 'path', "/{$slug}", 'relative' ), '/' ), $name );
    }

    /**
     * Load comments template
     *
     * @var bool $separated Whether or not to separate comments by type.
     *
     * @since 0.1.0
     * @access public
     */
    public function load_comments( bool $separated = false ) {
        \comments_template( $this->utilities->filesystem()->partials_dir( 'path', '/comments.php', 'relative' ), $separated );
    }

    /**
     * Locate template
     *
     * Check if template exists in child or parent theme.
     *
     * @var string $slug Template slug.
     * @var string $name Name to append to filename before loading.
     *
     * @since 0.1.0
     * @access private
     *
     * @return string Located template filename.
     */
    private function locate_template( string $slug, string $name = '' ): string {
        $files = [];

        if ( $name ) {
            $files[] = "{$slug}-{$name}.php";
        }

        $files[] = "{$slug}.php";

        $located = \locate_template( $files );

        if ( false !== stripos( $located, '/theme-compat/' ) ) {
            return '';
        }

        return $located;
    }
}
