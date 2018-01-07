<?php

/**
 * Language
 *
 * @package GrottoPress\Jentil\Setups
 * @since 0.1.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kus Adusei
 */

declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups;

use GrottoPress\WordPress\SUV\Setups\AbstractSetup;

/**
 * Language
 *
 * @since 0.1.0
 */
final class Language extends AbstractSetup
{
    /**
     * Run setup
     *
     * @since 0.1.0
     * @access public
     */
    public function run()
    {
        \add_action('after_setup_theme', [$this, 'loadTextDomain' ]);
    }

    /**
     * Load textdomain.
     *
     * Make theme available for translation. Translations can
     * be filed in the '/languages' directory.
     *
     * @since 0.1.0
     * @access public
     *
     * @action after_setup_theme
     */
    public function loadTextDomain()
    {
        \load_theme_textdomain(
            'jentil',
            $this->app->utilities->fileSystem->dir(
                'path',
                '/languages'
            )
        );
    }
}
