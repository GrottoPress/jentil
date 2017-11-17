<?php

/**
 * Comments
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
        if (!$this->jentil->utilities->page->is('singular')
            || !\comments_open()
            || !\get_option('thread_comments')
        ) {
            return;
        }

        \wp_enqueue_script('comment-reply');
    }
}
