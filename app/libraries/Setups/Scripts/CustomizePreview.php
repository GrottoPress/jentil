<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Scripts;

use GrottoPress\Jentil\AbstractTheme;

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
            ['jquery', 'customize-preview'],
            '',
            true
        );
    }

    /**
     * @action customize_preview_init
     */
    public function addInlineScript()
    {
        $script = 'var shortTags = '.\json_encode(
            $this->app->utilities->shortTags->get()
        ).';
        var colophonModName = "'.$this->app->setups['Customizer\Customizer']
            ->sections['Colophon\Colophon']->settings['Colophon']->id.'";
        var titleModNames = '.\json_encode($this->pageTitles()).';
        var relatedPostsHeadingModNames = '.\json_encode(
            $this->postsHeadings()
        ).';';

        \wp_add_inline_script($this->id, $script, 'before');
    }

    /**
     * @return string[]
     */
    private function pageTitles(): array
    {
        $titles = [];

        foreach ($this->app->setups['Customizer\Customizer']
            ->sections['Title\Title']->settings as $setting) {
            $titles[] = $setting->id;
        }

        return $titles;
    }

    /**
     * @return string[]
     */
    private function postsHeadings(): array
    {
        $headings = [];

        if (($post_types = $this->app->utilities->page->posts->postTypes())) {
            foreach ($post_types as $post_type) {
                $headings[] = $this->app->setups['Customizer\Customizer']
                    ->panels['Posts\Posts']
                    ->sections["Related_{$post_type->name}"]
                    ->settings['Heading']->id;
            }
        }

        return $headings;
    }
}
