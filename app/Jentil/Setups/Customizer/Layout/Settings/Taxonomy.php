<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Customizer\Layout\Settings;

use GrottoPress\Jentil\Setups\Customizer\Layout;
use WP_Taxonomy;
use WP_Term;

final class Taxonomy extends AbstractSetting
{
    public function __construct(
        Layout $layout,
        WP_Taxonomy $taxonomy,
        WP_Term $term = null
    ) {
        parent::__construct($layout);

        $theme_mod = $this->getThemeMod($taxonomy, $term);

        $this->id = $theme_mod->id;

        $this->args['default'] = $theme_mod->default;
    }

    private function getThemeMod(WP_Taxonomy $taxonomy, WP_Term $term = null)
    {
        $mod_context = 'tax';

        if ('post_tag' === $taxonomy->name) {
            $mod_context = 'tag';
        } elseif ('category' === $taxonomy->name) {
            $mod_context = 'category';
        }

        if ($term) {
            return $this->themeMod([
                'context' => $mod_context,
                'specific' => $taxonomy->name,
                'more_specific' => $term->term_id,
            ]);
        }

        return $this->themeMod([
            'context' => $mod_context,
            'specific' => $taxonomy->name,
        ]);
    }
}
