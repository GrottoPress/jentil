<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Styles;

use GrottoPress\Jentil\AbstractTheme;

final class FontAwesome extends AbstractStyle
{
    public function __construct(AbstractTheme $jentil)
    {
        parent::__construct($jentil);

        $this->id = 'font-awesome';
    }

    public function run()
    {
        \add_action('wp_enqueue_scripts', [$this, 'enqueue']);
    }

    /**
     * @action wp_enqueue_scripts
     */
    public function enqueue()
    {
        \wp_enqueue_style(
            $this->id,
            $this->app->utilities->fileSystem->dir(
                'url',
                '/assets/vendor/font-awesome/css/font-awesome.min.css'
            ),
            ['normalize']
        );
    }
}
