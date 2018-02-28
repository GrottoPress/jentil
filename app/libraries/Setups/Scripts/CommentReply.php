<?php

/**
 * Comment reply script
 *
 * @package GrottoPress\Jentil\Setups\Scripts
 * @since 0.6.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kusi Adusei
 */

declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Scripts;

use GrottoPress\Jentil\AbstractTheme;

/**
 * Comment reply script
 *
 * @since 0.6.0
 */
final class CommentReply extends AbstractScript
{
    /**
     * Constructor
     *
     * @param AbstractTheme $jentil
     *
     * @since 0.6.0
     * @access public
     */
    public function __construct(AbstractTheme $jentil)
    {
        parent::__construct($jentil);

        $this->id = 'comment-reply';
    }

    /**
     * Enqueue
     *
     * @since 0.6.0
     * @access public
     *
     * @action wp_enqueue_scripts
     */
    public function enqueue()
    {
        if (!$this->app->utilities->page->is('singular') ||
            !\comments_open() ||
            !\get_option('thread_comments')
        ) {
            return;
        }

        \wp_enqueue_script($this->id);
    }
}
