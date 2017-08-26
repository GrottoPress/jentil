<?php

/**
 * Functions API
 *
 * @package GrottoPress\Jentil
 * @since 0.1.0
 *
 * @author GrottoPress (https://www.grottopress.com)
 * @author N Atta Kus Adusei (https://twitter.com/akadusei)
 */

declare ( strict_types = 1 );

if ( ! \defined( 'WPINC' ) ) {
    die;
}

use GrottoPress\Jentil\Jentil;

/**
 * Jentil
 * 
 * @since 0.1.0
 *
 * @return GrottoPress\Jentil\Jentil Jentil.
 */
function Jentil(): Jentil {
    return Jentil::getInstance();
}
