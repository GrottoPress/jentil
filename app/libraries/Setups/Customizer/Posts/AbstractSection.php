<?php

/**
 * Abstract Posts Section
 *
 * @package GrottoPress\Jentil\Setups\Customizer\Posts
 * @since 0.1.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kusi Adusei
 */

declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Customizer\Posts;

use GrottoPress\WordPress\SUV\Setups\Customizer\AbstractSection as Section;

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

        $settings['StickyPosts'] = new Settings\StickyPosts($this);
        $settings['WrapClass'] = new Settings\WrapClass($this);
        $settings['Number'] = new Settings\Number($this);
        // $settings['WrapTag'] = new Settings\WrapTag($this);
        // $settings['Layout'] = new Settings\Layout($this);

        $settings['TitleWords'] = new Settings\TitleWords($this);
        $settings['TitlePosition'] = new Settings\TitlePosition($this);
        $settings['Image'] = new Settings\Image($this);
        $settings['ImageAlignment'] = new Settings\ImageAlignment($this);
        $settings['ImageMargin'] = new Settings\ImageMargin($this);
        $settings['TextOffset'] = new Settings\TextOffset($this);
        $settings['Excerpt'] = new Settings\Excerpt($this);
        $settings['MoreText'] = new Settings\MoreText($this);

        $settings['BeforeTitle'] = new Settings\BeforeTitle($this);
        $settings['BeforeTitleSeparator'] =
            new Settings\BeforeTitleSeparator($this);
        $settings['AfterTitle'] = new Settings\AfterTitle($this);
        $settings['AfterTitleSeparator'] =
            new Settings\AfterTitleSeparator($this);
        $settings['AfterContent'] = new Settings\AfterContent($this);
        $settings['AfterContentSeparator'] =
            new Settings\AfterContentSeparator($this);

        // $settings['Pagination'] = new Settings\Pagination($this);
        // $settings['PaginationMaximum'] =
            // new Settings\PaginationMaximum($this);
        $settings['PaginationPosition'] =
            new Settings\PaginationPosition($this);
        $settings['PaginationPreviousText'] =
            new Settings\PaginationPreviousText($this);
        $settings['PaginationNextText'] =
            new Settings\PaginationNextText($this);

        return $settings;
    }
}
