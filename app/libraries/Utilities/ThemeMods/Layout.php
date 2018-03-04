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
     * @var int $more_specific Post ID or term ID.
     */
    private $more_specific;

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
        $this->more_specific = (int)$args['more_specific'];
        $this->default = 'content-sidebar';

        $this->specific = \post_type_exists($args['specific']) ||
            \taxonomy_exists($args['specific']) ? $args['specific'] : '';

        $names = $this->names();
        $this->id = isset($names[$this->context])
            ? \sanitize_key($names[$this->context]) : '';
    }

    private function names(): array
    {
        $names = [
            'home' => 'post_post_type_layout',
            'singular' => (
                $this->isPagelike() ? 'layout' :
                "singular_{$this->specific}_{$this->more_specific}_layout"
            ),
            'author' => 'author_layout',
            'category' => "category_{$this->more_specific}_taxonomy_layout",
            'date' => 'date_layout',
            'post_type_archive' => "{$this->specific}_post_type_layout",
            'tag' => "post_tag_{$this->more_specific}_taxonomy_layout",
            'tax' => "{$this->specific}_{$this->more_specific}_taxonomy_layout",
            '404' => 'error_404_layout',
            'search' => 'search_layout',
        ];

        $names = \array_map(function (string $value): string {
            $value = \str_replace(['__', '_0_'], '_', $value);
            $value = \trim($value, '_');

            return $value;
        }, $names);

        return $names;
    }

    public function get(): string
    {
        if (!$this->id) {
            return '';
        }

        if ($this->isPagelike()) {
            if (($mod = \get_post_meta(
                $this->more_specific,
                $this->id,
                true
            ))) {
                return \sanitize_title($mod);
            }

            return $this->default;
        }

        return \sanitize_title(parent::get());
    }

    public function isPagelike(): bool
    {
        if ('singular' !== $this->context) {
            return false;
        }

        return $this->themeMods->utilities->page->posts->isPagelike(
            $this->specific,
            $this->more_specific
        );
    }
}
