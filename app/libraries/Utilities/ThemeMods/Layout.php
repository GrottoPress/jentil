<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Utilities\ThemeMods;

class Layout extends AbstractThemeMod
{
    /**
     * @var ThemeMods
     */
    private $themeMods;

    /**
     * @var string $context Page type.
     */
    private $context;

    /**
     * @var string $specific Post type or taxonomy name.
     */
    private $specific;

    /**
     * @var int $moreSpecific Post ID or term ID.
     */
    private $moreSpecific;

    public function __construct(ThemeMods $theme_mods, array $args = [])
    {
        $this->themeMods = $theme_mods;

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
        $this->default = \apply_filters('jentil_layout_mod_default', 'content');

        $this->specific = \post_type_exists($args['specific']) ||
            \taxonomy_exists($args['specific']) ? $args['specific'] : '';

        $ids = $this->ids();
        $this->id = isset($ids[$this->context])
            ? \sanitize_key($ids[$this->context]) : '';
    }

    private function ids(): array
    {
        $ids = [
            'home' => 'post_post_type_layout',
            'singular' => (
                $this->isPagelike() ? '_jentil-layout' :
                "singular_{$this->specific}_{$this->moreSpecific}_layout"
            ),
            'author' => 'author_layout',
            'category' => "category_{$this->moreSpecific}_taxonomy_layout",
            'date' => 'date_layout',
            'post_type_archive' => "{$this->specific}_post_type_layout",
            'tag' => "post_tag_{$this->moreSpecific}_taxonomy_layout",
            'tax' => "{$this->specific}_{$this->moreSpecific}_taxonomy_layout",
            '404' => 'error_404_layout',
            'search' => 'search_layout',
        ];

        $ids = \array_map(function (string $value): string {
            $value = \str_replace(['__', '_0_'], '_', $value);
            return ($this->isPagelike() ? $value : \trim($value, '_'));
        }, $ids);

        return $ids;
    }

    public function get(): string
    {
        if (!$this->id) {
            return '';
        }

        if ($this->isPagelike()) {
            return $this->validate(\get_post_meta(
                $this->moreSpecific,
                $this->id,
                true
            ));
        }

        return $this->validate(parent::get());
    }

    public function isPagelike(): bool
    {
        if ('singular' !== $this->context) {
            return false;
        }

        return $this->themeMods->utilities->page->posts->isPagelike(
            $this->specific,
            $this->moreSpecific
        );
    }

    private function validate(string $mod): string
    {
        if (\array_key_exists(
            $mod,
            $this->themeMods->utilities->page->layouts->IDs()
        )) {
            return \sanitize_title($mod);
        }

        return $this->default;
    }
}
