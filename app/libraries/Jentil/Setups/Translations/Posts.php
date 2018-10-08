<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Translations;

use GrottoPress\Jentil\AbstractTheme;

final class Posts extends AbstractTranslation
{
    public function __construct(AbstractTheme $jentil)
    {
        parent::__construct($jentil);

        $this->textDomain = 'grotto-wp-posts';
    }

    public function run()
    {
        \add_action('after_setup_theme', [$this, 'loadTextDomain' ]);
    }

    /**
     * @action after_setup_theme
     */
    public function loadTextDomain()
    {
        \load_theme_textdomain(
            $this->textDomain,
            $this->app->utilities->fileSystem->vendorDir(
                'path',
                '/grottopress/wordpress-posts/src/lang'
            )
        );
    }
}
