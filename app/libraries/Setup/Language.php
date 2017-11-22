<?php

/**
 * Language
 *
 * @package GrottoPress\Jentil\Setup
 * @since 0.1.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kus Adusei
 */

declare (strict_types = 1);

namespace GrottoPress\Jentil\Setup;

/**
 * Language
 *
 * @since 0.1.0
 */
class Language extends AbstractSetup
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
            $this->theme->utilities->fileSystem->themeDir(
                'path',
                '/languages'
            )
        );
    }
}
