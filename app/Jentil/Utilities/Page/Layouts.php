<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Utilities\Page;

use GrottoPress\Jentil\Utilities\Page;

class Layouts
{
    /**
     * @var Page
     */
    private $page;

    public function __construct(Page $page)
    {
        $this->page = $page;
    }

    /**
     * @return array<string, array<string, string>>
     */
    public function get(): array
    {
        $layouts = [
            'columns-1' => [
                'content' => \esc_html__('Content', 'jentil'),
            ],
            'columns-2' => [
                'content-sidebar' => \esc_html__('Content / Sidebar', 'jentil'),
                'sidebar-content' => \esc_html__('Sidebar / Content', 'jentil'),
            ],
            'columns-3' => [
                'sidebar-content-sidebar' => \esc_html__(
                    'Sidebar / Content / Sidebar',
                    'jentil'
                ),
                'content-sidebar-sidebar' => \esc_html__(
                    'Content / Sidebar / Sidebar',
                    'jentil'
                ),
                'sidebar-sidebar-content' => \esc_html__(
                    'Sidebar / Sidebar / Content',
                    'jentil'
                ),
            ],
        ];

        /**
         * @var array<string, array<string, string>> $layouts
         */
        return \apply_filters('jentil_page_layouts', $layouts);
    }

    /**
     * @return array<string, string>
     */
    public function IDs(): array
    {
        $return = [];

        foreach ($this->get() as $layouts) {
            foreach ($layouts as $layout_id => $layout_name) {
                $return[\sanitize_title($layout_id)] = \sanitize_text_field(
                    $layout_name
                );
            }
        }

        return $return;
    }
}
