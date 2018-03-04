<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Customizer\Posts;

use GrottoPress\Jentil\Setups\Customizer\AbstractSection as Section;

abstract class AbstractSection extends Section
{
    /**
     * @var Posts
     */
    protected $panel;

    /**
     * @var array
     */
    protected $modArgs = [];

    public function __construct(Posts $posts)
    {
        $this->panel = $posts;

        parent::__construct($this->panel->customizer);

        $this->args['title'] = \esc_html__('Posts', 'jentil');
        $this->args['panel'] = $this->panel->id;
    }

    protected function getPanel(): Posts
    {
        return $this->panel;
    }

    protected function getModArgs(): array
    {
        return $this->modArgs;
    }

    protected function settings(): array
    {
        $settings = [];

        $settings['StickyPosts'] = new Settings\StickyPosts($this);
        $settings['Heading'] = new Settings\Heading($this);
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
