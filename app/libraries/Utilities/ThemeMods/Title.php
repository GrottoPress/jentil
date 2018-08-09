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

    /**
     * @param mixed[string] $args
     */
    public function __construct(ThemeMods $theme_mods, array $args = [])
    {
        $this->themeMods = $theme_mods;

        $this->context = \sanitize_key($args['context'] ?? '');
        $this->specific = \sanitize_key($args['specific'] ?? '');
        $this->moreSpecific = (int)($args['more_specific'] ?? 0);

        if (!\post_type_exists($this->specific) &&
            !\taxonomy_exists($this->specific)
        ) {
            $this->specific = '';
        }

        $this->id = \sanitize_key($this->ids()[$this->context] ?? '');
        $this->default = $this->defaults()[$this->context] ?? '';
    }

    public function get(): string
    {
        return $this->themeMods->utilities->shortTags->replace(parent::get());
    }

    /**
     * @return string[string]
     */
    private function ids(): array
    {
        $ids = [
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

        $ids = \array_map(function (string $value): string {
            $value = \str_replace(['__', '_0_'], '_', $value);
            return \trim($value, '_');
        }, $ids);

        return \apply_filters(
            'jentil_title_mod_id',
            $ids,
            $this->context,
            $this->specific,
            $this->moreSpecific
        );
    }

    /**
     * @return string[string]
     */
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

        return \apply_filters(
            'jentil_title_mod_default',
            $defaults,
            $this->context,
            $this->specific,
            $this->moreSpecific
        );
    }
}
