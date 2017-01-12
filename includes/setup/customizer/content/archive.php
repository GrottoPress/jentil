<?php

/**
 * Archive content customizer
 *
 * The sections, settings and controls for our category
 * options in the customizer
 *
 * @link            https://jentil.grotttopress.com
 * @package		    jentil
 * @subpackage 	    jentil/includes
 * @since		    Jentil 0.1.0
 */

namespace GrottoPress\Jentil\Setup\Customizer\Content;

if ( ! defined( 'WPINC' ) ) {
    wp_die( esc_html__( 'Do not load this file directly!', 'jentil' ) );
}

/**
 * Archive customizer
 *
 * The sections, settings and controls for our category
 * options in the customizer
 *
 * @link			https://jentil.grotttopress.com
 * @package			jentil
 * @subpackage 	    jentil/includes
 * @since			Jentil 0.1.0
 */
class Archive {
    /**
     * Content customizer
     *
     * @since       Jentil 0.1.0
     * @access      private
     * 
     * @var     \GrottoPress\Jentil\Setup\Customizer\Content\Content      $content    Content customizer object
     */
    private $content;

    /**
     * Post types
     *
     * @since       Jentil 0.1.0
     * @access      private
     * 
     * @var     array      $post_types    Post types
     */
    private $post_types;
    
    /**
	 * Constructor
	 *
	 * @since       Jentil 0.1.0
	 * @access      public
	 */
	public function __construct( Content $content ) {
	    $this->content = $content;

        $this->post_types = get_post_types( array( 'public' => true, '_builtin' => false ) );
        $this->post_types[] = post_type_exists( 'post' ) ? 'post' : null;
	}
    
    /**
     * Add archive content section
     * 
     * @see         https://code.tutsplus.com/tutorials/wordpress-theme-customizer-methodology-for-sections-settings-and-controls-part-1--wp-33238
     * 
     * @since       Jentil 0.1.0
	 * @access      public
     */
    public function add_section( $wp_customize ) {
        if ( empty( $this->post_types ) ) {
            return;
        }

        foreach ( $this->post_types as $post_type ) {
            $object = get_post_type_object( $post_type );

            $wp_customize->add_section(
                $this->section( $post_type ),
                array(
                    'title'     => sprintf( esc_html__( '%s Content', 'jentil' ), $object->labels->singular_name ),
                    //'priority'  => 99,
                )
            );
        }
    }
    
    /**
     * Add archive content settings
     * 
     * @since       Jentil 0.1.0
     * @access      public
     */
    public function add_settings( $wp_customize ) {
        if ( empty( $this->post_types ) ) {
            return;
        }

        $this->add_sticky_posts_setting( $wp_customize );
        $this->add_class_setting( $wp_customize );
        $this->add_layout_setting( $wp_customize );
        $this->add_number_setting( $wp_customize );
        $this->add_before_title_setting( $wp_customize );
        $this->add_title_setting( $wp_customize );
        $this->add_title_position_setting( $wp_customize );
        $this->add_after_title_setting( $wp_customize );
        $this->add_thumbnail_setting( $wp_customize );
        $this->add_thumbnail_alignment_setting( $wp_customize );
        $this->add_text_offset_setting( $wp_customize );
        $this->add_excerpt_setting( $wp_customize );
        $this->add_after_content_setting( $wp_customize );
        $this->add_pagination_setting( $wp_customize );
    }

    /**
     * Add sticky posts setting
     * 
     * @since       Jentil 0.1.0
     * @access      private
     */
    private function add_sticky_posts_setting( $wp_customize ) {
        foreach ( $this->post_types as $post_type ) {
            if ( 'post' == $post_type ) {
                $wp_customize->add_setting(
                    $this->content->template()->content()->sticky_posts_name( $post_type ),
                    array(
                        'default'    =>  1,
                        //'transport'  =>  'postMessage',
                    )
                );

                break;
            }
        }
    }
    
    /**
     * Add wrapper class setting
     * 
     * @since       Jentil 0.1.0
     * @access      private
     */
    private function add_class_setting( $wp_customize ) {
        foreach ( $this->post_types as $post_type ) {
            $wp_customize->add_setting(
                $this->content->template()->content()->class_name( $post_type ),
                array(
                    'default'    =>  'archive-posts big',
                    //'transport'  =>  'postMessage',
                )
            );
        }
    }

    /**
     * Add layout setting
     * 
     * @since       Jentil 0.1.0
     * @access      private
     */
    private function add_layout_setting( $wp_customize ) {
        foreach ( $this->post_types as $post_type ) {
            $wp_customize->add_setting(
                $this->content->template()->content()->layout_name( $post_type ),
                array(
                    'default'    =>  'stack',
                    //'transport'  =>  'postMessage',
                )
            );
        }
    }

    /**
     * Add number setting
     * 
     * @since       Jentil 0.1.0
     * @access      private
     */
    private function add_number_setting( $wp_customize ) {
        foreach ( $this->post_types as $post_type ) {
            $wp_customize->add_setting(
                $this->content->template()->content()->number_name( $post_type ),
                array(
                    'default'    =>  ( int ) get_option( 'posts_per_page' ),
                    //'transport'  =>  'postMessage',
                )
            );
        }
    }
    
    /**
     * Add before title setting
     * 
     * @since       Jentil 0.1.0
     * @access      private
     */
    private function add_before_title_setting( $wp_customize ) {
        foreach ( $this->post_types as $post_type ) {
            $wp_customize->add_setting(
                $this->content->template()->content()->before_title_name( $post_type ),
                array(
                    'default'    =>  '',
                    //'transport'  =>  'postMessage',
                )
            );
        }
    }
    
    /**
     * Add title length setting
     * 
     * @since       Jentil 0.1.0
     * @access      private
     */
    private function add_title_setting( $wp_customize ) {
        foreach ( $this->post_types as $post_type ) {
            $wp_customize->add_setting(
                $this->content->template()->content()->title_words_name( $post_type ),
                array(
                    'default'    =>  -1,
                    //'transport'  =>  'postMessage',
                )
            );
        }
    }
    
    /**
     * Add title position setting
     * 
     * @since       Jentil 0.1.0
     * @access      private
     */
    private function add_title_position_setting( $wp_customize ) {
        foreach ( $this->post_types as $post_type ) {
            $wp_customize->add_setting(
                $this->content->template()->content()->title_position_name( $post_type ),
                array(
                    'default'    =>  'side',
                    //'transport'  =>  'postMessage',
                )
            );
        }
    }
    
    /**
     * Add after title setting
     * 
     * @since       Jentil 0.1.0
     * @access      private
     */
    private function add_after_title_setting( $wp_customize ) {
        foreach ( $this->post_types as $post_type ) {
            $wp_customize->add_setting(
                $this->content->template()->content()->after_title_name( $post_type ),
                array(
                    'default'    =>  'published_date, comments_link',
                    //'transport'  =>  'postMessage',
                )
            );
        }
    }
    
    /**
     * Add image size setting
     * 
     * @since       Jentil 0.1.0
     * @access      private
     */
    private function add_thumbnail_setting( $wp_customize ) {
        foreach ( $this->post_types as $post_type ) {
            $wp_customize->add_setting(
                $this->content->template()->content()->thumbnail_name( $post_type ),
                array(
                    'default'    =>  'post-thumbnail',
                    //'transport'  =>  'postMessage',
                )
            );
        }
    }
    
    /**
     * Add image alignment setting
     * 
     * @since       Jentil 0.1.0
     * @access      private
     */
    private function add_thumbnail_alignment_setting( $wp_customize ) {
        foreach ( $this->post_types as $post_type ) {
            $wp_customize->add_setting(
                $this->content->template()->content()->thumbnail_alignment_name( $post_type ),
                array(
                    'default'    =>  'left',
                    //'transport'  =>  'postMessage',
                )
            );
        }
    }
    
    /**
     * Add text offset setting
     * 
     * @since       Jentil 0.1.0
     * @access      private
     */
    private function add_text_offset_setting( $wp_customize ) {
        foreach ( $this->post_types as $post_type ) {
            $wp_customize->add_setting(
                $this->content->template()->content()->text_offset_name( $post_type ),
                array(
                    'default'    =>  0,
                    //'transport'  =>  'postMessage',
                )
            );
        }
    }
    
    /**
     * Add excerpt length setting
     * 
     * @since       Jentil 0.1.0
     * @access      private
     */
    private function add_excerpt_setting( $wp_customize ) {
        foreach ( $this->post_types as $post_type ) {
            $wp_customize->add_setting(
                $this->content->template()->content()->excerpt_name( $post_type ),
                array(
                    'default'    =>  '300',
                    //'transport'  =>  'postMessage',
                )
            );
        }
    }
    
    /**
     * Add after content setting
     * 
     * @since       Jentil 0.1.0
     * @access      private
     */
    private function add_after_content_setting( $wp_customize ) {
        foreach ( $this->post_types as $post_type ) {
            $wp_customize->add_setting(
                $this->content->template()->content()->after_content_name( $post_type ),
                array(
                    'default'    =>  'category,post_tag',
                    //'transport'  =>  'postMessage',
                )
            );
        }
    }
    
    /**
     * Add pagination setting
     * 
     * @since       Jentil 0.1.0
     * @access      private
     */
    private function add_pagination_setting( $wp_customize ) {
        foreach ( $this->post_types as $post_type ) {
            $wp_customize->add_setting(
                $this->content->template()->content()->pagination_name( $post_type ),
                array(
                    'default'    =>  'bottom',
                    //'transport'  =>  'postMessage',
                )
            );
        }
    }
    
    /**
     * Add controls
     * 
     * @since       Jentil 0.1.0
     * @access      public
     */
    public function add_controls( $wp_customize ) {
        if ( empty( $this->post_types ) ) {
            return;
        }

        $this->add_sticky_posts_control( $wp_customize );
        $this->add_class_control( $wp_customize );
        $this->add_layout_control( $wp_customize );
        $this->add_number_control( $wp_customize );
        $this->add_before_title_control( $wp_customize );
        $this->add_title_control( $wp_customize );
        $this->add_title_position_control( $wp_customize );
        $this->add_after_title_control( $wp_customize );
        $this->add_thumbnail_control( $wp_customize );
        $this->add_thumbnail_alignment_control( $wp_customize );
        $this->add_text_offset_control( $wp_customize );
        $this->add_excerpt_control( $wp_customize );
        $this->add_after_content_control( $wp_customize );
        $this->add_pagination_control( $wp_customize );
    }

    /**
     * Add sticky posts control
     * 
     * @since       Jentil 0.1.0
     * @access      private
     */
    private function add_sticky_posts_control( $wp_customize ) {
        foreach ( $this->post_types as $post_type ) {
            if ( 'post' == $post_type ) {
                $wp_customize->add_control(
                    $this->content->template()->content()->sticky_posts_name( $post_type ),
                    array(
                        'section'   => $this->section( $post_type ),
                        'label'     => esc_html__( 'Show sticky posts', 'jentil' ),
                        'type'      => 'checkbox',
                    )
                );

                break;
            }
        }
    }
    
    /**
     * Add 'class' control
     * 
     * @since       Jentil 0.1.0
     * @access      private
     */
    private function add_class_control( $wp_customize ) {
        foreach ( $this->post_types as $post_type ) {
            $wp_customize->add_control(
                $this->content->template()->content()->class_name( $post_type ),
                array(
                    'section'   => $this->section( $post_type ),
                    'label'     => esc_html__( 'Wrapper class', 'jentil' ),
                    'type'      => 'text',
                )
            );
        }
    }

    /**
     * Add 'layout' control
     * 
     * @since       Jentil 0.1.0
     * @access      private
     */
    private function add_layout_control( $wp_customize ) {
        foreach ( $this->post_types as $post_type ) {
            $wp_customize->add_control(
                $this->content->template()->content()->layout_name( $post_type ),
                array(
                    'section'   => $this->section( $post_type ),
                    'label'     => esc_html__( 'Layout', 'jentil' ),
                    'type'      => 'select',
                    'choices'   => $this->content->layouts()
                )
            );
        }
    }

    /**
     * Add 'number' control
     * 
     * @since       Jentil 0.1.0
     * @access      private
     */
    private function add_number_control( $wp_customize ) {
        foreach ( $this->post_types as $post_type ) {
            $wp_customize->add_control(
                $this->content->template()->content()->number_name( $post_type ),
                array(
                    'section'   => $this->section( $post_type ),
                    'label'     => esc_html__( 'Number', 'jentil' ),
                    'type'      => 'number',
                )
            );
        }
    }
    
    /**
     * Add 'before title' control
     * 
     * @since       Jentil 0.1.0
     * @access      private
     */
    private function add_before_title_control( $wp_customize ) {
        foreach ( $this->post_types as $post_type ) {
            $wp_customize->add_control(
                $this->content->template()->content()->before_title_name( $post_type ),
                array(
                    'section'   => $this->section( $post_type ),
                    'label'     => esc_html__( 'Before title', 'jentil' ),
                    'type'      => 'text',
                )
            );
        }
    }
    
    /**
     * Add title control
     * 
     * @since       Jentil 0.1.0
     * @access      private
     */
    private function add_title_control( $wp_customize ) {
        foreach ( $this->post_types as $post_type ) {
            $wp_customize->add_control(
                $this->content->template()->content()->title_words_name( $post_type ),
                array(
                    'section'   => $this->section( $post_type ),
                    'label'     => esc_html__( 'Title length', 'jentil' ),
                    'type'      => 'number',
                )
            );
        }
    }
    
    /**
     * Add title position control
     * 
     * @since       Jentil 0.1.0
     * @access      private
     */
    private function add_title_position_control( $wp_customize ) {
        foreach ( $this->post_types as $post_type ) {
            $wp_customize->add_control(
                $this->content->template()->content()->title_position_name( $post_type ),
                array(
                    'section'   => $this->section( $post_type ),
                    'label'     => esc_html__( 'Title position', 'jentil' ),
                    'type'      => 'select',
                    'choices'   => $this->content->title_positions(),
                )
            );
        }
    }
    
    /**
     * Add 'after title' control
     * 
     * @since       Jentil 0.1.0
     * @access      private
     */
    private function add_after_title_control( $wp_customize ) {
        foreach ( $this->post_types as $post_type ) {
            $wp_customize->add_control(
                $this->content->template()->content()->after_title_name( $post_type ),
                array(
                    'section'   => $this->section( $post_type ),
                    'label'     => esc_html__( 'After title', 'jentil' ),
                    'type'      => 'text',
                )
            );
        }
    }
    
    /**
     * Add thumbnail control
     * 
     * @since       Jentil 0.1.0
     * @access      private
     */
    private function add_thumbnail_control( $wp_customize ) {
        foreach ( $this->post_types as $post_type ) {
            $wp_customize->add_control(
               $this->content->template()->content()->thumbnail_name( $post_type ),
                array(
                    'section'   => $this->section( $post_type ),
                    'label'     => esc_html__( 'Image size', 'jentil' ),
                    'type'      => 'text',
                )
            );
        }
    }
    
    /**
     * Add thumbnail alignment control
     * 
     * @since       Jentil 0.1.0
     * @access      private
     */
    private function add_thumbnail_alignment_control( $wp_customize ) {
        foreach ( $this->post_types as $post_type ) {
            $wp_customize->add_control(
                $this->content->template()->content()->thumbnail_alignment_name( $post_type ),
                array(
                    'section'   => $this->section( $post_type ),
                    'label'     => esc_html__( 'Align image', 'jentil' ),
                    'type'      => 'select',
                    'choices'   => $this->content->image_alignments(),
                )
            );
        }
    }
    
    /**
     * Add 'text offset' control
     * 
     * @since       Jentil 0.1.0
     * @access      private
     */
    private function add_text_offset_control( $wp_customize ) {
        foreach ( $this->post_types as $post_type ) {
            $wp_customize->add_control(
                $this->content->template()->content()->text_offset_name( $post_type ),
                array(
                    'section'   => $this->section( $post_type ),
                    'label'     => esc_html__( 'Text offset from image side', 'jentil' ),
                    'type'      => 'number',
                )
            );
        }
    }
    
    /**
     * Add excerpt control
     * 
     * @since       Jentil 0.1.0
     * @access      private
     */
    private function add_excerpt_control( $wp_customize ) {
        foreach ( $this->post_types as $post_type ) {
            $wp_customize->add_control(
                $this->content->template()->content()->excerpt_name( $post_type ),
                array(
                    'section'   => $this->section( $post_type ),
                    'label'     => esc_html__( 'Excerpt length', 'jentil' ),
                    'type'      => 'text',
                )
            );
        }
    }
    
    /**
     * Add 'after content' control
     * 
     * @since       Jentil 0.1.0
     * @access      private
     */
    private function add_after_content_control( $wp_customize ) {
        foreach ( $this->post_types as $post_type ) {
            $wp_customize->add_control(
                $this->content->template()->content()->after_content_name( $post_type ),
                array(
                    'section'   => $this->section( $post_type ),
                    'label'     => esc_html__( 'After content', 'jentil' ),
                    'type'      => 'text',
                )
            );
        }
    }
    
    /**
     * Add pagination control
     * 
     * @since       Jentil 0.1.0
     * @access      private
     */
    private function add_pagination_control( $wp_customize ) {
        foreach ( $this->post_types as $post_type ) {
            $wp_customize->add_control(
                $this->content->template()->content()->pagination_name( $post_type ),
                array(
                    'section'   => $this->section( $post_type ),
                    'label'     => esc_html__( 'Show pagination', 'jentil' ),
                    'type'      => 'select',
                    'choices'   => $this->content->pagination_positions(),
                )
            );
        }
    }

    /**
     * Section name
     * 
     * @var         string      $post_type      Post type name
     *
     * @since       Jentil 0.1.0
     * @access      private
     */
    private function section( $post_type ) {
        return sanitize_key( $post_type . '_content' );
    }
}