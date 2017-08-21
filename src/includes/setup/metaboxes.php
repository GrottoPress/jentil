<?php

/**
 * Metaboxes
 *
 * @package GrottoPress\Jentil\Setup
 * @since 0.1.0
 *
 * @author GrottoPress (https://www.grottopress.com)
 * @author N Atta Kus Adusei (https://twitter.com/akadusei)
 */

declare ( strict_types = 1 );

namespace GrottoPress\Jentil\Setup;

if ( ! \defined( 'WPINC' ) ) {
    die;
}

use \WP_Post;

/**
 * Metaboxes
 *
 * @since 0.1.0
 */
final class Metaboxes extends Setup {
    /**
     * Boxes
     *
     * @since 0.1.0
     * @access private
     * 
     * @var array $boxes Boxes.
     */
    private $boxes;

    /**
     * Run setup
     *
     * @see http://omfgitsnater.com/2013/05/adding-meta-boxes-to-attachments-in-wordpress/
     *
     * @since 0.1.0
     * @access public
     */
    public function run() {
        \add_action( 'add_meta_boxes', [ $this, 'add' ], 10, 2 );
		\add_action( 'save_post', [ $this, 'save' ] );
		\add_action( 'edit_attachment', [ $this, 'save' ] );
    }

	/**
	 * Add meta boxes.
	 *
	 * Create one or more meta boxes to be displayed 
	 * on the editor screens.
	 *
	 * @action add_meta_boxes
	 *
	 * @since 0.1.0
	 * @access public
	 */
	public function add( string $post_type, WP_Post $post ) {
		if ( null === $this->boxes ) {
            $this->boxes = $this->boxes( $post->ID );
        }

        if ( ! $this->boxes ) {
			return;
		}
		
		foreach ( $boxes as $id => $attr ) {
			$this->jentil->utilities->metabox( $attr )->add();
		}
	}

	/**
	 * Save meta boxes as custom fields.
	 *
	 * @var integer $post_id Post ID.
	 *
	 * @since 0.1.0
	 * @access public
	 *
	 * @action save_post
	 * @action edit_attachment
	 */
	public function save( int $post_id ) {
		if ( null === $this->boxes ) {
            $this->boxes = $this->boxes( $post->ID );
        }

        if ( ! $this->boxes ) {
            return;
        }
		
		foreach ( $boxes as $id => $attr ) {
			$this->jentil->utilities->metabox( $attr )->save( $post_id );
		}
	}

	/**
	 * Meta boxes.
	 * 
	 * @since 0.1.0
	 * @access private
	 *
	 * @return array Metaboxes.
	 */
	private function boxes( int $post_id ): array {
	    $post_type = \get_post_type( $post_id );

	    $layouts = $this->setups->jentil->utilities->page->layout->layouts_ids_names();
        $mod = $this->setups->jentil->utilities->mods->layout( 'singular', $post_type, $post_id );

        $boxes = [];
	    
	    if ( \is_post_type_hierarchical( $post_type ) ) {
			if ( $layouts ) {
		        $boxes['jentil-layout'] = [
					'id' => 'jentil-layout',
					'title' => \esc_html__( 'Layout', 'jentil' ),
					'context' => 'side',
					'priority' => 'default',
					'callback' => '',
					'fields' => [
						$mod->name => [
							'id' => $mod->name,
							'type' => 'select',
							'choices' => $layouts,
							'label' => \esc_html__( 'Select layout', 'jentil' ),
						],
					],
					'notes' => \sprintf( \__( 'Need help? Check out the <a href="%s" target="_blank" rel="noreferrer noopener nofollow">documentation</a>.', Jentil::DOCUMENTATION ) ),
				];
		    }
	    }
	    
        /**
         * @filter jentil_metaboxes
         *
         * @var array $boxes Metaboxes.
         * @var string $post_type Post type.
         * @var integer $post_id Post ID.
         *
         * @since 0.1.0
         */
	    return \apply_filters( 'jentil_metaboxes', $boxes, $post_type, $post_id );
	}
}
