<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Utilities\ThemeMods;

class Title extends AbstractThemeMod
{
    /**
     * @var ThemeMods
     */
    private $themeMods;

    /**
     * @var string $context Page type
     */
    private $context;

    /**
     * @var string $specific Post type name or taxonomy name
     */
    private $specific;

    /**
     * @var int $moreSpecific Post ID or term ID
     */
    private $moreSpecific;

    public function __construct(ThemeMods $themeMods, array $args = [])
    {
        $this->themeMods = $themeMods;

        $this->setAttributes($args);
    }

    private function setAttributes(array $args)
    {
        $args = \wp_parse_args($args, [
            'context' => '',
            'specific' => '',
            'more_specific' => 0,
        ]);

        $this->context = \sanitize_key($args['context']);
        $this->moreSpecific = (int)$args['more_specific'];

        $this->specific = \post_type_exists($args['specific']) ||
            \taxonomy_exists($args['specific']) ? $args['specific'] : '';

        $names = $this->names();
        $this->id = isset($names[$this->context])
            ? \sanitize_key($names[$this->context]) : '';

        $defaults = $this->defaults();
        $this->default = $defaults[$this->context] ?? '';
    }

    private function names(): array
    {
        $names = [
            'home' => 'post_post_type_title',
            'author' => 'author_title',
            'category' => "category_{$this->moreSpecific}_taxonomy_title",
            'date' => 'date_title',
            'post_type_archive' => "{$this->specific}_post_type_title",
            'tag' => "post_tag_{$this->moreSpecific}_taxonomy_title",
            'tax' => "{$this->specific}_{$this->moreSpecific}_taxonomy_title",
            '404' => 'error_404_title',
            'search' => 'search_title',
        ];

        $names = \array_map(function (string $value): string {
            $value = \str_replace(['__', '_0_'], '_', $value);
            $value = \trim($value, '_');

            return $value;
        }, $names);

        return $names;
    }

    private function defaults(): array
    {
        $defaults = [
            'home' => \esc_html__('Latest Posts', 'jentil'),
            // 'singular' => '',
            'author' => '{{author_name}}',
            'category' => '{{category_name}}',
            'date' => '{{date}}',
            'post_type_archive' => '{{post_type_name}}',
            'tag' => '{{tag_name}}',
            'tax' => '{{term_name}}',
            '404' => \esc_html__('Not Found', 'jentil'),
            'search' => '&ldquo;{{search_query}}&rdquo;',
        ];

        /**
         * @var string $defaults Posts mod defaults.
         */
        return \apply_filters(
            'jentil_title_mod_defaults',
            $defaults,
            $this->context,
            $this->specific,
            $this->moreSpecific
        );
    }

    public function get(): string
    {
        return $this->themeMods->utilities->shortTags->replace(parent::get());
    }
}
