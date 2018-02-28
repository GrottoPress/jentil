<?php

/**
 * Customize preview script
 *
 * @package GrottoPress\Jentil\Setups\Scripts
 * @since 0.6.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kusi Adusei
 */

declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Scripts;

use GrottoPress\Jentil\AbstractTheme;

/**
 * Customize preview script
 *
 * @since 0.6.0
 */
final class CustomizePreview extends AbstractScript
{
    /**
     * Constructor
     *
     * @param AbstractTheme $jentil
     *
     * @since 0.6.0
     * @access public
     */
    public function __construct(AbstractTheme $jentil)
    {
        parent::__construct($jentil);

        $this->id = 'jentil-customize-preview';
    }

    /**
     * Run setup
     *
     * @since 0.1.0
     * @access public
     */
    public function run()
    {
        \add_action('customize_preview_init', [$this, 'enqueue']);
        \add_action('customize_preview_init', [$this, 'addInlineScript']);
    }

    /**
     * Enqueue
     *
     * @since 0.6.0
     * @access public
     *
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
     * Pass data to our script via PHP
     *
     * @since 0.6.0
     * @access public
     *
     * @action customize_preview_init
     */
    public function addInlineScript()
    {
        $script = 'var shortTags = '.\json_encode(
            $this->app->utilities->shortTags->get()
        ).';
        var colophonModName = "'.$this->app->setups['Customizer\Customizer']
            ->sections['Colophon\Colophon']->settings['Colophon']->name.'";
        var titleModNames = '.\json_encode($this->pageTitles()).';
        var relatedPostsHeadingModNames = '.\json_encode(
            $this->postsHeadings()
        ).';';

        \wp_add_inline_script($this->id, $script, 'before');
    }

    /**
     * Page titles
     *
     * @since 0.6.0
     * @access private
     *
     * @return string[]
     */
    private function pageTitles(): array
    {
        $titles = [];

        foreach ($this->app->setups['Customizer\Customizer']
            ->sections['Title\Title']->settings as $setting) {
            $titles[] = $setting->name;
        }

        return $titles;
    }

    /**
     * Posts headings
     *
     * @since 0.6.0
     * @access private
     *
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
                    ->settings['Heading']->name;
            }
        }

        return $headings;
    }
}
