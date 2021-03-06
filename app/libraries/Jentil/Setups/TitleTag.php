<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups;

final class TitleTag extends AbstractSetup
{
    public function run()
    {
        \add_action('after_setup_theme', [$this, 'addSupport']);
    }

    /**
     * @action after_setup_theme
     */
    public function addSupport()
    {
        \add_theme_support('title-tag');
    }
}
