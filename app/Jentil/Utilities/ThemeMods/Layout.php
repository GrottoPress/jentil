<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Utilities\ThemeMods;

use GrottoPress\Jentil\Utilities\ThemeMods;

class Layout extends AbstractThemeMod
{
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

    /**
     * @param array<string, mixed> $args
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
        if (!$this->id) {
            return '';
        }

        if ($this->isPagelike()) {
            return $this->validate((string)\get_post_meta(
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

        return $this->themeMods->utilities->page->layout->isPagelike(
            $this->specific,
            $this->moreSpecific
        );
    }

    private function id(): string
    {
        return \sanitize_key(\apply_filters(
            'jentil_layout_mod_id',
            ($this->ids()[$this->context] ?? ''),
            $this->context,
            $this->specific,
            $this->moreSpecific
        ));
    }

    private function default(): string
    {
        return \sanitize_title(\apply_filters(
            'jentil_layout_mod_default',
            'content',
            $this->context,
            $this->specific,
            $this->moreSpecific
        ));
    }

    /**
     * @return array<string, string>
     */
    private function ids(): array
    {
        return \array_map(function (string $value): string {
            $value = \str_replace(['__', '_0_'], '_', $value);
            return ($this->isPagelike() ? $value : \trim($value, '_'));
        }, [
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
        ]);
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
