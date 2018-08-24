<?php
namespace GrottoPress\Jentil\Setups\Customizer\Layout\Settings;

use GrottoPress\Jentil\Setups\Customizer\Layout;
use WP_Post_Type;
use WP_Post;

final class Singular extends AbstractSetting
{
    public function __construct(
        Layout $layout,
        WP_Post_Type $post_type,
        WP_Post $post = null
    ) {
        parent::__construct($layout);

        $theme_mod = $this->getThemeMod($post_type, $post);

        $this->id = $theme_mod->id;

        $this->args['default'] = $theme_mod->default;
    }

    private function getThemeMod(WP_Post_Type $post_type, WP_Post $post = null)
    {
        if ($post) {
            return $this->themeMod([
                'context' => 'singular',
                'specific' => $post_type->name,
                'more_specific' => $post->ID,
            ]);
        }

        return $this->themeMod([
            'context' => 'singular',
            'specific' => $post_type->name,
        ]);
    }
}
