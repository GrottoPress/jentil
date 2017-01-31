<?php

/**
 * Metaboxes
 *
 * @link            http://example.com
 * @since           Jentil 0.1.0
 *
 * @package         jentil
 * @subpackage      jentil/includes
 */

namespace GrottoPress\Jentil\Setup;

if ( ! defined( 'WPINC' ) ) {
    wp_die( esc_html__( 'Do not load this file directly!', 'jentil' ) );
}

use GrottoPress\MagPack;
use GrottoPress\Jentil\Utilities;

if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Metaboxes
 * 
 * Render and process meta boxes
 *
 * @package         jentil
 * @subpackage      jentil/includes
 * @author          N Atta Kusi Adusei
 */
final class Metaboxes extends MagPack\Utilities\Singleton {
    /**
     * Layouts
	 *
	 * @since       Jentil 0.1.0
	 * @access      private
	 * 
	 * @var         array         $layouts       Associative array of layouts ids to layouts names
	 */
    private $layouts;
    
    /**
	 * Constructor
	 *
	 * @since       Jentil 0.1.0
	 * @access      public
	 */
	protected function __construct() {}
    
    /**
	 * Meta boxes setup.
	 *
	 * @since    	Jentil 0.1.0
	 * @access  	public
	 * 
	 * @action      load-post.php
	 * @action      load-post-new.php
	 */
	public function setup() {
		$template = new Utilities\Template\Template();
        $this->layouts = $template->get( 'layout' )->layouts_ids_names();

        add_action( 'add_meta_boxes', array( $this, 'add' ), 10, 2 );
		add_action( 'save_post', array( $this, 'save' ) );
		
		/**
		 * For attachemnet post type
		 * 
		 * @link 		http://omfgitsnater.com/2013/05/adding-meta-boxes-to-attachments-in-wordpress/
		 */
		add_action( 'edit_attachment', array( $this, 'save' ) );
	}
	
	/**
	 * Add meta boxes.
	 *
	 * Create one or more meta boxes to be displayed 
	 * on the editor screens.
	 * 
	 * @see 		$this->setup()
	 *
	 * @since    	Jentil 0.1.0
	 * @access  	public
	 */
	public function add( $post_type, $post ) {
		$boxes = $this->boxes( $post_type );
		
		foreach ( $boxes as $id => $attr ) {
			$args = array();
			
			$args['type'] = isset( $boxes[ $id ]['type'] ) ? sanitize_key( $boxes[ $id ]['type'] ) : null;
			
			if ( doing_action( 'add_meta_boxes' ) && 'inbuilt' == $args['type'] ) {
				continue;
			}
			
			$args['id'] = sanitize_key( $id );
			$args['title'] = isset( $boxes[ $id ]['title'] ) ? sanitize_text_field( $boxes[ $id ]['title'] ) : null;
			$args['callback'] = ! empty( $boxes[ $id ]['callback'] ) ? $boxes[ $id ]['callback'] : null;
			$args['context'] = isset( $boxes[ $id ]['context'] ) ? sanitize_key( $boxes[ $id ]['context'] ) : null;
			$args['priority'] = isset( $boxes[ $id ]['priority'] ) ? sanitize_key( $boxes[ $id ]['priority'] ) : null;
			$args['callback_args'] = isset( $boxes[ $id ]['callback_args'] ) ? (array) $boxes[ $id ]['callback_args'] : null;
			$args['screen'] = $post_type;
			$args['fields'] = isset( $boxes[ $id ]['fields'] ) ? (array) $boxes[ $id ]['fields'] : array();
			$args['notes'] = isset( $boxes[ $id ]['notes'] ) ? $boxes[ $id ]['notes'] : null;
			
			$metabox = new MagPack\Utilities\Metabox( $args );
			$metabox->add();
		}
	}
	
	/**
	 * Save meta boxes as custom fields.
	 *
	 * @var 		$post_id 		integer 		The post ID
	 *
	 * @since    	Jentil 0.1.0
	 * @access  	public
	 */
	public function save( $post_id ) {
		$post_type = get_post_type( $post_id );
		$boxes = $this->boxes( $post_type );
		
		foreach ( $boxes as $id => $attr ) {
			$args = array();
			
			$args['id'] = $id;
			$args['type'] = isset( $boxes[ $id ]['type'] ) ? sanitize_key( $boxes[ $id ]['type'] ) : '';
			$args['fields'] = isset( $boxes[ $id ]['fields'] ) ? (array) $boxes[ $id ]['fields'] : array();
			
			$metabox = new MagPack\Utilities\Metabox( $args );
			$metabox->save( $post_id );
		}
	}
	
	/**
	 * Meta boxes.
	 * 
	 * @since    	Jentil 0.1.0
	 * @access  	private
	 */
	private function boxes( $post_type ) {
	    $boxes = array();
	    
	    if ( is_post_type_hierarchical( $post_type ) ) {
	        $boxes['jentil-layout'] = array(
				'title' => esc_html__( 'Layout', 'jentil' ),
				'context' => 'side',
				'priority' => 'default',
				'callback' => '',
				'fields' => array(
					'layout' => array(
						'type' => 'select',
						'choices' => $this->layouts,
						'label' => esc_html__( 'Select layout', 'jentil' ),
					),
				),
				'notes' => __( 'Need help? Check out the <a href="#" target="_blank">documentation</a>.' ),
			);
	    }
	    
	    return $boxes;
	}
}