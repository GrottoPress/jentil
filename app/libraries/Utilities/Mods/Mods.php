<?php

/**
 * Theme Mods
 *
 * @package GrottoPress\Jentil\Utilities\Mods
 * @since 0.1.0
 *
 * @author GrottoPress (https://www.grottopress.com)
 * @author N Atta Kus Adusei (https://twitter.com/akadusei)
 */

declare ( strict_types = 1 );

namespace GrottoPress\Jentil\Utilities\Mods;

if ( ! \defined( 'WPINC' ) ) {
    die;
}

use GrottoPress\Jentil\Utilities\Utilities;

/**
 * Theme Mods
 *
 * @since 0.1.0
 */
final class Mods {
    /**
     * Utilities
     *
     * @since 0.1.0
     * @access private
     * 
     * @var \GrottoPress\Jentil\Utilites\Utilities $utilities Utilities.
     */
    private $utilities;

    /**
     * Colophon
     *
     * @since 0.1.0
     * @access private
     * 
     * @var \GrottoPress\Jentil\Utilites\Mods\Colophon $colophon Colophon.
     */
    private $colophon;

    /**
     * Logo
     *
     * @since 0.1.0
     * @access private
     * 
     * @var \GrottoPress\Jentil\Utilites\Mods\Logo $logo Logo.
     */
    private $logo;

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
     * Logo
     *
     * @since 0.1.0
     * @access public
     *
     * @return GrottoPress\Jentil\Utilities\Mods\Logo Logo.
     */
    public function logo(): Logo {
        if ( null === $this->logo ) {
            $this->logo = new Logo( $this );
        }

        return $this->logo;
    }

    /**
     * Colophon
     *
     * @since 0.1.0
     * @access public
     *
     * @return GrottoPress\Jentil\Utilities\Mods\Colophon Colophon.
     */
    public function colophon(): Colophon {
        if ( null === $this->colophon ) {
            $this->colophon = new Colophon( $this );
        }

        return $this->colophon;
    }

    /**
     * Layout Mod
     * 
     * @var array $args Mod args.
     * 
     * @since 0.1.0
     * @access public
     *
     * @return \GrottoPress\Jentil\Utilities\Mods\Layout Layout mod.
     */
    public function layout( array $args = [] ): Layout {
        return new Layout( $this, $args );
    }

    /**
     * Posts Mod
     * 
     * @var string $setting Setting to retrieve.
     * @var array $args Mod args.
     * 
     * @since 0.1.0
     * @access public
     *
     * @return \GrottoPress\Jentil\Utilities\Mods\Posts Posts mod.
     */
    public function posts( string $setting, array $args = [] ): Posts {
        return new Posts( $this, $setting, $args );
    }

    /**
     * Title Mod
     * 
     * @var array $args Mod args.
     * 
     * @since 0.1.0
     * @access public
     *
     * @return \GrottoPress\Jentil\Utilities\Mods\Title Title mod.
     */
    public function title( array $args = [] ): Title {
        return new Title( $this, $args );
    }
}
