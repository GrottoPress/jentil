<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Customizer\Posts;

use GrottoPress\Jentil\Setups\Customizer\Posts;
use GrottoPress\Jentil\Setups\Customizer\AbstractSection as Section;
use WP_Customize_Manager as WPCustomizer;

abstract class AbstractSection extends Section
{
    /**
     * @var mixed[string]
     */
    protected $themeModArgs = [];

    public function __construct(Posts $posts)
    {
        parent::__construct($posts->customizer);

        $this->args['title'] = \esc_html__('Posts', 'jentil');
        $this->args['panel'] = $posts->id;
    }

    /**
     * @return mixed[string]
     */
    protected function getThemeModArgs(): array
    {
        return $this->themeModArgs;
    }

    public function add(WPCustomizer $wp_customizer)
    {
        $this->setSettings();

        parent::add($wp_customizer);
    }

    protected function setSettings()
    {
        $this->settings['StickyPosts'] = new Settings\StickyPosts($this);
        $this->controls['StickyPosts'] = new Controls\StickyPosts($this);

        $this->settings['Number'] = new Settings\Number($this);
        $this->controls['Number'] = new Controls\Number($this);

        $this->settings['Heading'] = new Settings\Heading($this);
        $this->controls['Heading'] = new Controls\Heading($this);

        $this->settings['WrapClass'] = new Settings\WrapClass($this);
        $this->controls['WrapClass'] = new Controls\WrapClass($this);

        // $this->settings['WrapTag'] = new Settings\WrapTag($this);
        // $this->controls['WrapTag'] = new Controls\WrapTag($this);

        // $this->settings['Layout'] = new Settings\Layout($this);
        // $this->controls['Layout'] = new Controls\Layout($this);

        $this->settings['TitleWords'] = new Settings\TitleWords($this);
        $this->controls['TitleWords'] = new Controls\TitleWords($this);

        $this->settings['TitlePosition'] = new Settings\TitlePosition($this);
        $this->controls['TitlePosition'] = new Controls\TitlePosition($this);

        $this->settings['Image'] = new Settings\Image($this);
        $this->controls['Image'] = new Controls\Image($this);

        $this->settings['ImageAlignment'] = new Settings\ImageAlignment($this);
        $this->controls['ImageAlignment'] = new Controls\ImageAlignment($this);

        $this->settings['ImageMargin'] = new Settings\ImageMargin($this);
        $this->controls['ImageMargin'] = new Controls\ImageMargin($this);

        $this->settings['TextOffset'] = new Settings\TextOffset($this);
        $this->controls['TextOffset'] = new Controls\TextOffset($this);

        $this->settings['Excerpt'] = new Settings\Excerpt($this);
        $this->controls['Excerpt'] = new Controls\Excerpt($this);

        $this->settings['MoreText'] = new Settings\MoreText($this);
        $this->controls['MoreText'] = new Controls\MoreText($this);

        $this->settings['BeforeTitle'] = new Settings\BeforeTitle($this);
        $this->controls['BeforeTitle'] = new Controls\BeforeTitle($this);

        $this->settings['BeforeTitleSeparator'] =
            new Settings\BeforeTitleSeparator($this);
        $this->controls['BeforeTitleSeparator'] =
            new Controls\BeforeTitleSeparator($this);

        $this->settings['AfterTitle'] = new Settings\AfterTitle($this);
        $this->controls['AfterTitle'] = new Controls\AfterTitle($this);

        $this->settings['AfterTitleSeparator'] =
            new Settings\AfterTitleSeparator($this);
        $this->controls['AfterTitleSeparator'] =
            new Controls\AfterTitleSeparator($this);

        $this->settings['AfterContent'] = new Settings\AfterContent($this);
        $this->controls['AfterContent'] = new Controls\AfterContent($this);

        $this->settings['AfterContentSeparator'] =
            new Settings\AfterContentSeparator($this);
        $this->controls['AfterContentSeparator'] =
            new Controls\AfterContentSeparator($this);

        // $this->settings['Pagination'] = new Settings\Pagination($this);
        // $this->controls['Pagination'] = new Controls\Pagination($this);

        // $this->settings['PaginationMaximum'] =
        //     new Settings\PaginationMaximum($this);
        // $this->controls['PaginationMaximum'] =
        //     new Controls\PaginationMaximum($this);

        $this->settings['PaginationPosition'] =
            new Settings\PaginationPosition($this);
        $this->controls['PaginationPosition'] =
            new Controls\PaginationPosition($this);

        $this->settings['PaginationPreviousText'] =
            new Settings\PaginationPreviousText($this);
        $this->controls['PaginationPreviousText'] =
            new Controls\PaginationPreviousText($this);

        $this->settings['PaginationNextText'] =
            new Settings\PaginationNextText($this);
        $this->controls['PaginationNextText'] =
            new Controls\PaginationNextText($this);
    }
}
