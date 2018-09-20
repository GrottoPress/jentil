<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Styles;

use GrottoPress\Jentil\AbstractTheme;

final class Gutenberg extends AbstractStyle
{
    public function __construct(AbstractTheme $jentil)
    {
        parent::__construct($jentil);

        $this->id = 'jentil-gutenberg';
    }

    public function run()
    {
        \add_action('enqueue_block_editor_assets', [$this, 'enqueue']);
    }

    /**
     * @action enqueue_block_editor_assets
     */
    public function enqueue()
    {
        if (\is_rtl()) {
            $file = '/dist/styles/gutenberg-rtl.min.css';
        } else {
            $file = '/dist/styles/gutenberg.min.css';
        }

        \wp_enqueue_style(
            $this->id,
            $this->app->utilities->fileSystem->dir('url', $file),
            [],
            \filemtime($this->app->utilities->fileSystem->dir('path', $file))
        );
    }
}
