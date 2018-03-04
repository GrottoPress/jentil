<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Customizer\Posts;

use WP_Customize_Manager as WPCustomizer;

final class Date extends AbstractSection
{
    public function __construct(Posts $posts)
    {
        parent::__construct($posts);

        $this->id = 'date_posts';

        $this->modArgs['context'] = 'date';

        $this->args['title'] = \esc_html__('Date Archives', 'jentil');
        $this->args['active_callback'] = function (): bool {
            return $this->customizer->app->utilities->page->is('date');
        };
    }

    public function add(WPCustomizer $WPCustomizer)
    {
        $this->settings = $this->settings();

        parent::add($WPCustomizer);
    }

    /**
     * @return Settings\AbstractSetting[]
     */
    protected function settings(): array
    {
        $settings = parent::settings();

        unset($settings['StickyPosts'], $settings['Heading']);

        return $settings;
    }
}
