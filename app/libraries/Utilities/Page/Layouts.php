<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Utilities\Page;

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

    public function get(): array
    {
        $layouts = [
            'columns-1' => [
                'content' => \esc_html__('content', 'jentil'),
            ],
            'columns-2' => [
                'content-sidebar' => \esc_html__('content / sidebar', 'jentil'),
                'sidebar-content' => \esc_html__('sidebar / content', 'jentil'),
            ],
            'columns-3' => [
                'sidebar-content-sidebar' => \esc_html__(
                    'sidebar / content / sidebar',
                    'jentil'
                ),
                'content-sidebar-sidebar' => \esc_html__(
                    'content / sidebar / sidebar',
                    'jentil'
                ),
                'sidebar-sidebar-content' => \esc_html__(
                    'sidebar / sidebar / content',
                    'jentil'
                ),
            ],
        ];

        /**
         * @var array $layouts
         */
        return \apply_filters('jentil_page_layouts', $layouts);
    }

    /**
     * @return array Layout IDs: [ID => Name].
     */
    public function IDs(): array
    {
        $return = [];

        foreach ($this->get() as $column_type => $layouts) {
            foreach ($layouts as $layout_id => $layout_name) {
                $return[\sanitize_title($layout_id)] = \sanitize_text_field(
                    $layout_name
                );
            }
        }

        return $return;
    }
}
