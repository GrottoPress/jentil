<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Styles;

use GrottoPress\Jentil\AbstractTheme;

final class Posts extends AbstractStyle
{
    public function __construct(AbstractTheme $jentil)
    {
        parent::__construct($jentil);

        $this->id = 'grotto-wp-posts';
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
        $file_system = $this->app->utilities->fileSystem;
        $file_name = \is_rtl() ? 'posts-rtl.css' : 'posts.css';
        $file = "/grottopress/wordpress-posts/dist/css/{$file_name}";

        \wp_enqueue_style(
            $this->id,
            $file_system->vendorDir('url', $file),
            [],
            \filemtime($file_system->vendorDir('path', $file))
        );
    }
}
