<?php

/**
 * Logo Setting
 *
 * @package GrottoPress\Jentil\Setup\Customizer\Logo\Settings
 * @since 0.1.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kus Adusei
 */

namespace GrottoPress\Jentil\Setup\Customizer\Logo\Settings;

use GrottoPress\Jentil\Setup\Customizer\Setting;
use GrottoPress\Jentil\Setup\Customizer\Logo\Logo as Section;
use \WP_Customize_Manager as WP_Customizer;

/**
 * Logo Setting
 *
 * @since 0.1.0
 */
final class Logo extends Setting
{
    /**
     * Logo section
     *
     * @since 0.1.0
     * @access private
     *
     * @var Logo $logo Logo section.
     */
    private $logo;
    
    /**
     * Constructor
     *
     * @param Logo $logo Logo section.
     *
     * @since 0.1.0
     * @access public
     */
    public function __construct(Section $logo)
    {
        $this->logo = $logo;

        $mod = $this->logo->customizer()->jentil()->utilities()->mods()->logo();

        $this->name = $mod->name();
        $this->args = [
            // 'transport' => 'postMessage',
            'default' => $mod->default(),
            'sanitize_callback' => function ($logo): int {
                if (($id = \absint($logo))) {
                    return $id;
                }

                return \attachment_url_to_postid($logo);
            },
        ];

        $this->setControl();
    }

    /**
     * Add setting
     *
     * @since 0.1.0
     * @access public
     */
    public function add(WP_Customizer $wp_customize)
    {
        if (\function_exists('get_custom_logo')) {
            return;
        }

        $wp_customize->add_setting($this->name, $this->args);

        if (\class_exists('\WP_Customize_Cropped_Image_Control')) {
            $wp_customize->add_control(new \WP_Customize_Cropped_Image_Control(
                $wp_customize,
                $this->name,
                $this->control
            ));
        } else { // Saves image URL (not ID)
            $wp_customize->add_control(new \WP_Customize_Image_Control(
                $wp_customize,
                $this->name,
                $this->control
            ));
        }

        if (isset($wp_customize->selective_refresh)) {
            $wp_customize->selective_refresh->add_partial($this->name, [
                'settings' => [$this->name],
                'selector' => '.custom-logo-link',
                'render_callback' =>
                    [$this->logo->customizer()->jentil()->utilities()->logo(), 'HTML'],
                'container_inclusive' => true,
            ]);
        }
    }

    /**
     * Set control
     *
     * @since 0.1.0
     * @access private
     */
    private function setControl()
    {
        $size = $this->logo->customizer()->jentil()->utilities()
            ->logo()->size();

        $this->control = [
            'label' => \esc_html__('Logo', 'jentil'),
            'section' => 'title_tagline',
            'settings' => $this->name,
            'priority' => 8,
            'height' => \absint($size['height']),
            'width' => \absint($size['width']),
            'flex_height' => (bool) $size['flex-height'],
            'flex_width' => (bool) $size['flex-width'],
            'button_labels' => [
                'select' => \esc_html__('Select logo', 'jentil'),
                'change' => \esc_html__('Change logo', 'jentil'),
                'remove' => \esc_html__('Remove', 'jentil'),
                'default' => \esc_html__('Default', 'jentil'),
                'placeholder' => \esc_html__('No logo selected', 'jentil'),
                'frame_title' => \esc_html__('Select logo', 'jentil'),
                'frame_button' => \esc_html__('Choose logo', 'jentil'),
            ],
        ];
    }
}
