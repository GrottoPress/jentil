<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Views;

use GrottoPress\Jentil\Setups\AbstractSetup;

final class Author extends AbstractSetup
{
    public function run()
    {
        \add_action('jentil_before_title', [$this, 'renderAvatar']);
    }

    /**
     * @action jentil_before_title
     */
    public function renderAvatar()
    {
        if (!$this->app->utilities->page->is('author')) {
            return;
        }

        echo \get_avatar(\get_query_var('author'), 60);
    }
}
