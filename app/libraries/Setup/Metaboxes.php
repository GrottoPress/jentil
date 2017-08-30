<?php

/**
 * Metaboxes
 *
 * @package GrottoPress\Jentil\Setup
 * @since 0.1.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kus Adusei
 */

declare ( strict_types = 1 );

namespace GrottoPress\Jentil\Setup;

if ( ! \defined( 'WPINC' ) ) {
    die;
}

use GrottoPress\Jentil\Jentil;
use GrottoPress\WordPress\Metaboxes\Metaboxes as G_Metaboxes;
use \WP_Post;

/**
 * Metaboxes
 *
 * @since 0.1.0
 */
final class Metaboxes extends Setup {
    /**
     * Import traits
     *
     * @since 0.1.0 Added G_Metaboxes.
     */
    use G_Metaboxes;

    /**
     * Run setup
     *
     * @since 0.1.0
     * @access public
     */
    public function run() {
        $this->setup();
    }

	/**
	 * Meta boxes.
     *
     * @param \WP_Post $post Post.
	 * 
	 * @since 0.1.0
	 * @access protected
	 *
	 * @return array Metaboxes.
	 */
	protected function metaboxes( WP_Post $post ): array {
	    $boxes = [];

        if ( ( $layout = $this->layout_metabox( $post ) ) ) {
            $boxes[] = $layout;
        }
	    
        /**
         * @filter jentil_metaboxes
         *
         * @var array $boxes Metaboxes.
         * @var \WP_Post $post Post.
         *
         * @since 0.1.0
         */
	    return \apply_filters( 'jentil_metaboxes', $boxes, $post );
	}

    /**
     * Layout metabox
     *
     * @param \WP_Post $post Post.
     * 
     * @since 0.1.0
     * @access private
     *
     * @return array Layout metabox.
     */
    private function layout_metabox( WP_Post $post ): array {
        if ( ! \is_post_type_hierarchical( $post->post_type ) ) {
            return [];
        }
        
        if (
            ! ( $layouts = $this->jentil->utilities()->page()
                ->layout()->layouts_ids_names() )
        ) {
            return [];
        }

        if (
            ! ( $mod = $this->jentil->utilities()->mods()->layout( [
                    'context' => 'singular',
                    'specific' => $post->post_type,
                    'more_specific' => $post->ID,
                ] ) )
        ) {
            return [];
        }

        if ( ! $mod->is_pagelike() ) {
            return [];
        }

        return [
            'id' => 'jentil-layout',
            'title' => \esc_html__( 'Layout', 'jentil' ),
            'context' => 'side',
            'priority' => 'default',
            'callback' => '',
            'fields' => [
                [
                    'id' => $mod->name(),
                    'type' => 'select',
                    'choices' => $layouts,
                    'label' => \esc_html__( 'Select layout', 'jentil' ),
                    'label_pos' => 'before_field',
                ],
            ],
            'notes' => '<p>' . \sprintf( \__( 'Need help? Check out the <a href="%s" target="_blank" rel="noreferrer noopener nofollow">documentation</a>.', 'jentil' ), Jentil::DOCUMENTATION ) . '</p>',
        ];
    }
}
