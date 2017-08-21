<?php

/**
 * Author
 *
 * @package GrottoPress\Jentil\Setup\Customizer\Title\Settings
 * @since 0.1.0
 *
 * @author GrottoPress (https://www.grottopress.com)
 * @author N Atta Kus Adusei (https://twitter.com/akadusei)
 */

declare ( strict_types = 1 );

namespace GrottoPress\Jentil\Setup\Customizer\Title\Settings;

if ( ! \defined( 'WPINC' ) ) {
    die;
}

use GrottoPress\Jentil\Setup\Customizer\Title\Title;

/**
 * Author
 *
 * @since 0.1.0
 */
final class Author extends Setting {
    /**
     * Constructor
     *
     * @var GrottoPress\Jentil\Setup\Customizer\Customizer\Title\Title $title Title.
     *
     * @since 0.1.0
     * @access public
     */
    public function __construct( Title $title ) {
        parent::__construct( $title );

        $this->mod = $this->title->customizer()->jentil()->utilities()->mods()->title( [
            'context' => 'author',
        ] );

        $this->name = $this->mod->name();
        
        $this->args['default'] = $this->mod->default();

        $this->control['label'] = \esc_html__( 'Author Archives', 'jentil' );
        $this->control['active_callback'] = function (): bool {
            return $this->title->customizer()->jentil()->utilities()->page()->is( 'author' );
        };
    }
}
