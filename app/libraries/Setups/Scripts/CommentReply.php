<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Scripts;

use GrottoPress\Jentil\AbstractTheme;

final class CommentReply extends AbstractScript
{
    public function __construct(AbstractTheme $jentil)
    {
        parent::__construct($jentil);

        $this->id = 'comment-reply';
    }

    /**
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
