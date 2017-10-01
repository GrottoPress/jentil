<?php

/**
 * Post Type
 *
 * @package GrottoPress\Jentil\Setup\Customizer\Title\Settings
 * @since 0.1.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kus Adusei
 */

declare (strict_types = 1);

namespace GrottoPress\Jentil\Setup\Customizer\Title\Settings;

use GrottoPress\Jentil\Setup\Customizer\Title\Title;
use WP_Post_Type;

/**
 * Post Type
 *
 * @since 0.1.0
 */
final class PostType extends AbstractSetting
{
    /**
     * Constructor
     *
     * @param Title $title Title.
     *
     * @since 0.1.0
     * @access public
     */
    public function __construct(Title $title, WP_Post_Type $post_type)
    {
        parent::__construct($title);

        $mod_context = (
            'post' == $post_type->name ? 'home' : 'post_type_archive'
        );

        $this->mod = $this->title->customizer()->jentil()->utilities()
            ->mods()->title([
                'context' => $mod_context,
                'specific' => $post_type->name,
            ]);

        $this->name = $this->mod->name();
        
        $this->args['default'] = $this->mod->default();

        $this->control['active_callback'] = function () use ($post_type): bool {
            $page = $this->title->customizer()->jentil()->utilities()
                ->page();

            if ('post' == $post_type->name) {
                return $page->is('home');
            }

            return $page->is('post_type_archive', $post_type->name);
        };

        $this->control['label'] = \sprintf(\esc_html__('%s Archive', 'jentil'), $post_type->labels->name);
    }
}
