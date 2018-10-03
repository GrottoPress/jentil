<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Scripts;

use GrottoPress\Jentil\AbstractTheme;

final class Menu extends AbstractScript
{
    public function __construct(AbstractTheme $jentil)
    {
        parent::__construct($jentil);

        $this->id = "{$this->app->theme->stylesheet}-menu";
    }

    public function run()
    {
        \add_action('wp_enqueue_scripts', [$this, 'enqueue']);
        \add_action('wp_enqueue_scripts', [$this, 'localize']);
    }

    /**
     * @action wp_enqueue_scripts
     */
    public function enqueue()
    {
        $file_system = $this->app->utilities->fileSystem;
        $file = '/dist/scripts/menu.min.js';

        \wp_enqueue_script(
            $this->id,
            $file_system->dir('url', $file),
            ['jquery'],
            \filemtime($file_system->dir('path', $file)),
            true
        );
    }

    /**
     * @action wp_enqueue_scripts
     */
    public function localize()
    {
        \wp_localize_script($this->id, 'jentilMenuL10n', [
            'submenu' => \esc_html__('Sub-menu', 'jentil')
        ]);
    }
}
