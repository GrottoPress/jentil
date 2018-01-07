<?php

/**
 * Comments
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
 * Comments
 *
 * @since 0.1.0
 */
final class Comments extends AbstractSetup
{
    /**
     * Run setup
     *
     * @since 0.1.0
     * @access public
     */
    public function run()
    {
        \add_action('wp_enqueue_scripts', [$this, 'enqueueJS']);
    }
    
    /**
     * Enqueue JS
     *
     * @since 0.1.0
     * @access public
     *
     * @action wp_enqueue_scripts
     */
    public function enqueueJS()
    {
        if (!$this->app->utilities->page->is('singular')
            || !\comments_open()
            || !\get_option('thread_comments')
        ) {
            return;
        }

        \wp_enqueue_script('comment-reply');
    }
}
