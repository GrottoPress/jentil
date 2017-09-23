<?php

/**
 * Scripts (JavaScript)
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
 * Scripts (JavaScript)
 *
 * @since 0.1.0
 */
final class Scripts extends AbstractSetup
{
    /**
     * Run setup
     *
     * @since 0.1.0
     * @access public
     */
    public function run()
    {
        \add_action('wp_footer', [$this, 'enqueue']);
        \add_filter('body_class', [$this, 'addBodyClasses']);
    }

    /**
     * Enqueue Styles
     *
     * @since 0.1.0
     * @access public
     *
     * @action wp_footer
     */
    public function enqueue()
    {
        \wp_enqueue_script(
            'jentil',
            $this->jentil->utilities()->fileSystem()->scriptsDir(
                'url',
                '/jentil.min.js'
            ),
            ['jquery'],
            '',
            true
        );
    }

    /**
     * Add 'no-js' class to body
     *
     * This should be removed by javascript if
     * javascript is supported by client.
     *
     * @since 0.1.0
     * @access public
     *
     * @filter body_class
     */
    public function addBodyClasses(array $classes): array
    {
        $classes[] = 'no-js';

        return $classes;
    }
}
