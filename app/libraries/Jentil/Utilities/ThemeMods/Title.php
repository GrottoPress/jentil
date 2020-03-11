<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Utilities\ThemeMods;

use GrottoPress\Jentil\Utilities\ThemeMods;

class Title extends AbstractThemeMod
{
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
        parent::__construct($theme_mods);

        $this->context = \sanitize_key($args['context'] ?? '');
        $this->specific = \sanitize_key($args['specific'] ?? '');
        $this->moreSpecific = (int)($args['more_specific'] ?? 0);

        if (!\post_type_exists($this->specific) &&
            !\taxonomy_exists($this->specific)
        ) {
            $this->specific = '';
        }

        $this->id = $this->id();
        $this->default = $this->default();
    }

    public function get(): string
    {
        return $this->themeMods->utilities->shortTags->replace(parent::get());
    }

    private function id(): string
    {
        return \sanitize_key(\apply_filters(
            'jentil_title_mod_id',
            ($this->ids()[$this->context] ?? ''),
            $this->context,
            $this->specific,
            $this->moreSpecific
        ));
    }

    private function default(): string
    {
        return \apply_filters(
            'jentil_title_mod_default',
            ($this->defaults()[$this->context] ?? ''),
            $this->context,
            $this->specific,
            $this->moreSpecific
        );
    }

    /**
     * @return string[string]
     */
    private function ids(): array
    {
        return \array_map(function (string $value): string {
            $value = \str_replace(['__', '_0_'], '_', $value);
            return \trim($value, '_');
        }, [
            'home' => 'post_post_type_title',
            'author' => 'author_title',
            'category' => "category_{$this->moreSpecific}_taxonomy_title",
            'date' => 'date_title',
            'post_type_archive' => "{$this->specific}_post_type_title",
            'tag' => "post_tag_{$this->moreSpecific}_taxonomy_title",
            'tax' => "{$this->specific}_{$this->moreSpecific}_taxonomy_title",
            '404' => 'error_404_title',
            'search' => 'search_title',
        ]);
    }

    /**
     * @return string[string]
     */
    private function defaults(): array
    {
        return [
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
    }
}
