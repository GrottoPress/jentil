<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Scripts;

use GrottoPress\Jentil\AbstractTheme;
use GrottoPress\Jentil\Setups\Customizer\AbstractSetting;

final class CustomizePreview extends AbstractScript
{
    public function __construct(AbstractTheme $jentil)
    {
        parent::__construct($jentil);

        $this->id = 'jentil-customize-preview';
    }

    public function run()
    {
        \add_action('customize_preview_init', [$this, 'enqueue']);
        \add_action('customize_preview_init', [$this, 'addInlineScript']);
        \add_action('wp_enqueue_scripts', [$this, 'addFrontEndInlineScript']);
    }

    /**
     * @action customize_preview_init
     */
    public function enqueue()
    {
        \wp_enqueue_script(
            $this->id,
            $this->app->utilities->fileSystem->dir(
                'url',
                '/dist/scripts/customize-preview.min.js'
            ),
            ['customize-preview'],
            '',
            true
        );
    }

    /**
     * @action customize_preview_init
     */
    public function addInlineScript()
    {
        $script = 'var jentilColophonModId = "'.$this->colophonModID().'";
        var jentilPageTitleModIds = '.\wp_json_encode(
            $this->pageTitleModIDs()
        ).';
        var jentilRelatedPostsHeadingModIds = '.\wp_json_encode(
            $this->relatedPostsHeadingModIDs()
        ).';
        var jentilPageLayoutModIds = '.\wp_json_encode(
            $this->pageLayoutModIDs()
        ).';';

        \wp_add_inline_script($this->id, $script, 'before');
    }

    /**
     * ShortTags uses page-specific functions that won't work
     * in the customizer, so we're adding this inline script to
     * the front end (after those functions are ready).
     *
     * @action wp_enqueue_scripts
     */
    public function addFrontEndInlineScript()
    {
        $script = 'var jentilShortTags = '.\wp_json_encode(
            $this->app->utilities->shortTags->get()
        ).';';

        \wp_add_inline_script($this->id, $script, 'before');
    }

    private function colophonModID(): string
    {
        return $this->app->setups['Customizer\Customizer']
            ->sections['Colophon\Colophon']->settings['Colophon']->id;
    }

    /**
     * @return string[int]
     */
    private function pageTitleModIDs(): array
    {
        return $this->modIDs($this->app->setups['Customizer\Customizer']
            ->sections['Title\Title']->settings);
    }

    /**
     * @return string[int]
     */
    private function pageLayoutModIDs(): array
    {
        return $this->modIDs($this->app->setups['Customizer\Customizer']
            ->sections['Layout\Layout']->settings);
    }

    /**
     * @return string[int]
     */
    private function relatedPostsHeadingModIDs(): array
    {
        $ids = [];

        if ($post_types = $this->app->utilities->page->posts->postTypes()) {
            foreach ($post_types as $post_type) {
                $ids[] = $this->app->setups['Customizer\Customizer']
                    ->panels['Posts\Posts']
                    ->sections["Related_{$post_type->name}"]
                    ->settings['Heading']->id;
            }
        }

        return $ids;
    }

    /**
     * @param AbstractSetting[int] $settings
     * @return string[int]
     */
    private function modIDs(array $settings): array
    {
        return \array_map(function (AbstractSetting $setting): string {
            return $setting->id;
        }, $settings);
    }
}
