<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Styles;

use GrottoPress\Jentil\AbstractTheme;

final class Editor extends AbstractStyle
{
    public function __construct(AbstractTheme $jentil)
    {
        parent::__construct($jentil);

        $this->id = "{$this->app->meta['slug']}-editor";
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
        $file_system = $this->app->utilities->fileSystem;
        $file = \is_rtl() ? '/dist/css/editor-rtl.css' : '/dist/css/editor.css';

        \wp_enqueue_style(
            $this->id,
            $file_system->dir('url', $file),
            [],
            \filemtime($file_system->dir('path', $file))
        );
    }
}
