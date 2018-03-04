<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Customizer\Posts;

use WP_Customize_Manager as WPCustomizer;

final class Search extends AbstractSection
{
    public function __construct(Posts $posts)
    {
        parent::__construct($posts);

        $this->id = 'search_posts';

        $this->modArgs['context'] = 'search';

        $this->args['title'] = \esc_html__('Search Results', 'jentil');
        $this->args['active_callback'] = function (): bool {
            return $this->customizer->app->utilities
                ->page->is('search');
        };
    }

    public function add(WPCustomizer $WPCustomizer)
    {
        $this->settings = $this->settings();

        parent::add($WPCustomizer);
    }

    protected function settings(): array
    {
        $settings = parent::settings();

        unset($settings['StickyPosts'], $settings['Heading']);

        return $settings;
    }
}
