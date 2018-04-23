<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Utilities\Page\Posts;

use GrottoPress\Jentil\Utilities\Page\Page;
use GrottoPress\Jentil\Utilities\ThemeMods\Posts as PostsMod;
use GrottoPress\Getter\GetterTrait;

class Posts
{
    use GetterTrait;

    /**
     * @var Page
     */
    private $page;

    /**
     * @var Sticky
     */
    private $sticky;

    /**
     * @var Related
     */
    private $related;

    /**
     * @var Singular
     */
    private $singular;

    /**
     * @var Archive
     */
    private $archive;

    public function __construct(Page $page)
    {
        $this->page = $page;
    }

    private function getPage(): Page
    {
        return $this->page;
    }

    private function getSingular(): Singular
    {
        if (null === $this->singular) {
            return new Singular($this);
        }

        return $this->singular;
    }

    private function getSticky(): Sticky
    {
        if (null === $this->sticky) {
            return new Sticky($this);
        }

        return $this->sticky;
    }

    private function getRelated(): Related
    {
        if (null === $this->related) {
            return new Related($this);
        }

        return $this->related;
    }

    private function getArchive(): Archive
    {
        if (null === $this->archive) {
            return new Archive($this);
        }

        return $this->archive;
    }

    public function render(): string
    {
        if ($this->page->is('singular')) {
            return $this->getSingular()->posts()->render();
        }

        $out = '';

        if (!$this->getArchive()->isPaged() &&
            $this->getSticky()->isSet() &&
            $this->getSticky()->get($this->getArchive()->postType())
        ) {
            $out .= $this->getSticky()->posts()->render();
        }

        $out .= $this->getArchive()->posts()->render();

        return $out;
    }

    /**
     * @return \WP_Post_Type[] Public post types.
     */
    public function postTypes(): array
    {
        return \get_post_types(['public' => true], 'objects');
    }

    /**
     * @return \WP_Taxonomy[] Public taxonomies.
     */
    public function taxonomies(): array
    {
        return \get_taxonomies(['public' => true], 'objects');
    }

    public function themeMod(string $setting, array $args = []): PostsMod
    {
        if (!empty($args['context'])) {
            return $this->page->utilities->themeMods->posts(
                $setting,
                $args
            );
        }

        $page = $this->page->type;

        $specific = '';
        $more_specific = 0;

        foreach ($page as $type) {
            if ('post_type_archive' === $type) {
                $specific = \get_query_var('post_type');
            } elseif ('tax' === $type) {
                $specific = \get_query_var('taxonomy');
            } elseif ('category' === $type) {
                $specific = 'category';
            } elseif ('tag' === $type) {
                $specific = 'post_tag';
            }

            if (\is_array($specific)) {
                $specific = $specific[0];
            }

            if (\is_array($more_specific)) {
                $more_specific = $more_specific[0];
            }

            $mod = $this->page->utilities->themeMods->posts($setting, [
                'context' => $type,
                'specific' => $specific,
                'more_specific' => $more_specific,
            ]);

            if ($mod->id) {
                return $mod;
            }
        }

        return $mod;
    }

    public function isPagelike(string $post_type = '', int $post_id = 0): bool
    {
        $check = (
            \is_post_type_hierarchical($post_type) &&
            !\get_post_type_archive_link($post_type)
        );

        if ($check && $post_id && ('page' === \get_option('show_on_front'))) {
            return ($post_id !== (int)\get_option('page_for_posts'));
        }

        return $check;
    }
}
