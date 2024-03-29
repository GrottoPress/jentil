<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Utilities\ThemeMods;

use GrottoPress\Jentil\Utilities\ThemeMods;

class Posts extends AbstractThemeMod
{
    /**
     * @var string $setting Post setting to retrieve
     */
    private $setting;

    /**
     * @var string
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
    public function __construct(
        ThemeMods $theme_mods,
        string $setting,
        array $args = []
    ) {
        parent::__construct($theme_mods);

        $this->setting = \sanitize_key($setting);
        $this->context = \sanitize_key($args['context'] ?? '');
        $this->specific = \sanitize_key($args['specific'] ?? '');
        $this->moreSpecific = (int)($args['more_specific'] ?? 0);

        $this->id = $this->id();
        $this->default = $this->default();
    }

    private function id(): string
    {
        return \sanitize_key(\apply_filters(
            'jentil_posts_mod_id',
            ($this->ids()[$this->context] ?? ''),
            $this->setting,
            $this->context,
            $this->specific,
            $this->moreSpecific
        ));
    }

    private function default()
    {
        return \apply_filters(
            'jentil_posts_mod_default',
            ($this->defaults()[$this->setting] ?? null),
            $this->setting,
            $this->context,
            $this->specific,
            $this->moreSpecific
        );
    }

    /**
     * @return array<string, string>
     */
    private function ids(): array
    {
        return \array_map(function (string $value): string {
            $value .= "_{$this->setting}";
            $value = \str_replace(['__', '_0_'], '_', $value);
            return \trim($value, '_');
        }, [
            'home' => 'post_post_type_posts',
            'singular' => "singular_{$this->specific}_{$this->moreSpecific}_posts",
            'author' => 'author_posts',
            'category' => "category_{$this->moreSpecific}_taxonomy_posts",
            'date' => 'date_posts',
            'post_type_archive' => "{$this->specific}_post_type_posts",
            'tag' => "post_tag_{$this->moreSpecific}_taxonomy_posts",
            'tax' => "{$this->specific}_{$this->moreSpecific}_taxonomy_posts",
            'search' => 'search_posts',
            'sticky' => "{$this->specific}_sticky_posts",
            'related' => "{$this->specific}_related_posts",
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    private function defaults(): array
    {
        $defaults = [
            'wrap_class' => 'archive-posts big',
            'wrap_tag' => 'div',
            'layout' => '',
            'number' => (int)\get_option('posts_per_page'),
            'before_title' => '',
            'before_title_separator' => ' | ',
            'title_words' => -1,
            'title_position' => 'side',
            'after_title' => 'published_date, comments_link',
            'after_title_separator' => ' | ',
            'image' => $this->themeMods->utilities->app
                ->setups['Thumbnails\Mini']->id,
            'image_alignment' => 'left',
            'image_margin' => '',
            'text_offset' => 0,
            'excerpt' => -1,
            'more_text' => \esc_html__('read more', 'jentil'),
            'after_content' => 'category, post_tag',
            'after_content_separator' => ' | ',
            'pagination' => '',
            'pagination_maximum' => -1,
            'pagination_position' => 'bottom',
            'pagination_previous_text' => \esc_html__(
                '&larr; Previous',
                'jentil'
            ),
            'pagination_next_text' => \esc_html__('Next &rarr;', 'jentil'),
            'sticky_posts' => 0,
        ];

        if ('search' === $this->context) {
            $defaults['wrap_class'] = 'archive-posts';
            $defaults['image'] = $this->themeMods->utilities->app
                ->setups['Thumbnails\Nano']->id;
            $defaults['title_position'] = 'top';
            $defaults['after_title'] = 'post_type, comments_link';
            $defaults['excerpt'] = 40;
        }

        if (\in_array($this->context, ['sticky', 'related'])) {
            unset(
                $defaults['pagination'],
                $defaults['pagination_maximum'],
                $defaults['pagination_position'],
                $defaults['pagination_previous_text'],
                $defaults['pagination_next_text']
            );
        }

        if ('sticky' === $this->context) {
            $defaults['wrap_class'] = 'sticky-posts big';

            unset($defaults['number']);
        }

        if ('related' === $this->context) {
            $defaults['wrap_class'] = 'related-posts layout-grid';
            $defaults['before_title'] = '';
            $defaults['after_title'] = '';
            $defaults['after_content'] = '';
            $defaults['image'] = 'post-thumbnail';
            $defaults['image_alignment'] = 'none';
            $defaults['image_margin'] = '0 0 3px';
            $defaults['heading'] = \esc_html__('Recommended', 'jentil');
            $defaults['excerpt'] = 0;
            $defaults['number'] = ('post' === $this->specific ? 6 : 0);
        }

        if ('singular' === $this->context) {
            if ('post' === $this->specific) {
                $defaults['after_title'] = 'jentil_byline';
            } else {
                $defaults['after_title'] = '';
            }

            $defaults['after_content'] = '';
        }

        if (!\in_array($this->context, [
            'post_type_archive',
            'home',
        ])) {
            unset($defaults['sticky_posts']);
        }

        if (\in_array($this->context, [
            'home',
        ])) {
            $defaults['sticky_posts'] = 1;
        }

        return $defaults;
    }
}
