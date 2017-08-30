<?php

/**
 * Loader
 *
 * Loads templates/partials.
 *
 * @package GrottoPress\Jentil\Utilities
 * @since 0.1.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kus Adusei
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
     * @param GrottoPress\Jentil\Utilities\Utilities $utilities Utilities.
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
     * @param string $slug Partial slug to load.
     * @param string $name Name to append to filename before loading.
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
     * @param string $slug Template slug.
     * @param string $name Name to append to filename before loading.
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
     * @param bool $separated Whether or not to separate comments by type.
     *
     * @since 0.1.0
     * @access public
     */
    public function load_comments( bool $separated = false ) {
        \comments_template( $this->utilities->filesystem()->partials_dir( 'path', '/comments.php', 'relative' ), $separated );
    }
}
