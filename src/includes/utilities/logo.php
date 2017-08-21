<?php

/**
 * Logo
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
 * Logo
 * 
 * @since 0.1.0
 */
final class Logo {
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
     * @since 0.1.0
     * @access public
     */
    public function __construct( Utilities $utilities ) {
        $this->utilities = $utilities;
    }

    /**
     * Get logo mod
     *
     * @since 0.1.0
     * @access public
     *
     * @return integer Custom logo mod
     */
    public function mod(): int {
        return $this->utilities->mods()->logo()->get();
    }

    /**
     * Logo size
     * 
     * @since 0.1.0
     * @access public
     * 
     * @return array The logo size.
     */
    public function size(): array {
        return ( array ) \apply_filters( 'jentil_logo_size', [
            'height' => 60,
            'width' => 180,
            'flex-width' => false,
            'flex-height' => false,
        ] );
    }
}
