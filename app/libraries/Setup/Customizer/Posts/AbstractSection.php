<?php

/**
 * Abstract Posts Section
 *
 * @package GrottoPress\Jentil\Setup\Customizer\Posts
 * @since 0.1.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kus Adusei
 */

declare (strict_types = 1);

namespace GrottoPress\Jentil\Setup\Customizer\Posts;

use GrottoPress\Jentil\Setup\Customizer\AbstractSection as Section;

/**
 * Abstract Posts Section
 *
 * @since 0.1.0
 */
abstract class AbstractSection extends Section
{
    /**
     * Panel
     *
     * @since 0.1.0
     * @access protected
     *
     * @var Posts $panel Posts panel.
     */
    protected $panel;

    /**
     * Constructor
     *
     * @since 0.1.0
     * @access protected
     *
     * @var array $modArgs Mod args.
     */
    protected $modArgs = [];

    /**
     * Constructor
     *
     * @param Posts $posts Posts panel.
     *
     * @since 0.1.0
     * @access public
     */
    public function __construct(Posts $posts)
    {
        $this->panel = $posts;

        parent::__construct($this->panel->customizer);

        $this->args['title'] = \esc_html__('Posts', 'jentil');
        $this->args['panel'] = $this->panel->name;
    }

    /**
     * Panel
     *
     * @since 0.1.0
     * @access protected
     *
     * @return Posts Posts panel.
     */
    final protected function getPanel(): Posts
    {
        return $this->panel;
    }

    /**
     * Mod args
     *
     * @since 0.1.0
     * @access protected
     *
     * @return array Mod args.
     */
    protected function getModArgs(): array
    {
        return $this->modArgs;
    }

    /**
     * Settings
     *
     * @since 0.1.0
     * @access protected
     *
     * @return array
     */
    protected function settings(): array
    {
        $settings = [];

        $settings['sticky_posts'] = new Settings\StickyPosts($this);
        $settings['wrap_class'] = new Settings\WrapClass($this);
        $settings['number'] = new Settings\Number($this);
        // $settings['wrap_tag'] = new Settings\WrapTag($this);
        // $settings['layout'] = new Settings\Layout($this);
        $settings['before_title'] = new Settings\BeforeTitle($this);
        $settings['before_title_separator'] =
            new Settings\BeforeTitleSeparator($this);
        $settings['title_words'] = new Settings\TitleWords($this);
        $settings['title_position'] = new Settings\TitlePosition($this);
        $settings['after_title'] = new Settings\AfterTitle($this);
        $settings['after_title_separator'] =
            new Settings\AfterTitleSeparator($this);
        $settings['image'] = new Settings\Image($this);
        $settings['image_alignment'] = new Settings\ImageAlignment($this);
        $settings['image_margin'] = new Settings\ImageMargin($this);
        $settings['text_offset'] = new Settings\TextOffset($this);
        $settings['excerpt'] = new Settings\Excerpt($this);
        $settings['more_link'] = new Settings\MoreText($this);
        $settings['after_content'] = new Settings\AfterContent($this);
        $settings['after_content_separator'] =
            new Settings\AfterContentSeparator($this);
        // $settings['pagination'] = new Settings\Pagination($this);
        // $settings['pagination_maximum'] = new Settings\PaginationMaximum($this);
        $settings['pagination_position'] =
            new Settings\PaginationPosition($this);
        $settings['pagination_previous_label'] =
            new Settings\PaginationPreviousLabel($this);
        $settings['pagination_next_label'] =
            new Settings\PaginationNextLabel($this);
        
        return $settings;
    }
}
