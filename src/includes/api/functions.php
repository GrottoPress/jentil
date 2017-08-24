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

/**
 * Get partial
 *
 * @var string $partial Partial basename (without .php extension)
 * @var string $name The name of the specialised template.
 * 
 * @since 0.1.0
 */
// function jentil_get_partial( string $partial, string $name = '' ) {
//     \get_template_part( ltrim( \Jentil()->partials_dir( 'path',
//         '/' . $partial, 'relative' ), '/' ), $name );
// }

/**
 * Comments template
 *
 * @var string $file Comments file to load, relative to partials directory.
 * @var bool $separated Whether to separate the comments by comment type.
 * 
 * @since 0.1.0
 */
// function jentil_comments_template( string $file, bool $separated = false ) {
//     \comments_template( \Jentil()->partials_dir( 'path', $file, 'relative' ), $separated );
// }
