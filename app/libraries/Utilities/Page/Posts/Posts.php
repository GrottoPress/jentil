<?php

/**
 * Posts
 *
 * @package GrottoPress\Jentil\Utilities\Page\Posts
 * @since 0.1.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kusi Adusei
 */

declare (strict_types = 1);

namespace GrottoPress\Jentil\Utilities\Page\Posts;

use GrottoPress\Jentil\Utilities\Page\Page;
use GrottoPress\Jentil\Utilities\ThemeMods\Posts as PostsMod;
use GrottoPress\Getter\Getter;

/**
 * Posts
 *
 * @since 0.1.0
 */
class Posts
{
    use Getter;

    /**
     * Page
     *
     * @since 0.1.0
     * @access private
     *
     * @var Page
     */
    private $page;

    /**
     * Query ID
     *
     * @since 0.6.0
     * @access private
     *
     * @var string
     */
    private $id;

    /**
     * Sticky Posts
     *
     * @since 0.1.0
     * @access private
     *
     * @var Sticky
     */
    private $sticky;

    /**
     * Related Posts
     *
     * @since 0.6.0
     * @access private
     *
     * @var Related
     */
    private $related;

    /**
     * Singular Posts
     *
     * @since 0.1.0
     * @access private
     *
     * @var Singular
     */
    private $singular;

    /**
     * Archive Posts
     *
     * @since 0.1.0
     * @access private
     *
     * @var Archive
     */
    private $archive;

    /**
     * Constructor
     *
     * @param Page $page
     *
     * @since 0.1.0
     * @access public
     */
    public function __construct(Page $page)
    {
        $this->page = $page;

        $this->id = 'main-query';
    }

    /**
     * Get Page
     *
     * @since 0.1.0
     * @access private
     *
     * @return Page
     */
    private function getPage(): Page
    {
        return $this->page;
    }

    /**
     * Get ID
     *
     * @since 0.6.0
     * @access private
     *
     * @return string
     */
    private function getID(): string
    {
        return $this->id;
    }

    /**
     * Get singular posts
     *
     * @since 0.6.0
     * @access private
     *
     * @return Singular
     */
    private function getSingular(): Singular
    {
        if (null === $this->singular) {
            return new Singular($this);
        }

        return $this->singular;
    }

    /**
     * Get Sticky Posts
     *
     * @since 0.1.0
     * @access private
     *
     * @return Sticky
     */
    private function getSticky(): Sticky
    {
        if (null === $this->sticky) {
            return new Sticky($this);
        }

        return $this->sticky;
    }

    /**
     * Get related posts
     *
     * @since 0.6.0
     * @access private
     *
     * @return Related
     */
    private function getRelated(): Related
    {
        if (null === $this->related) {
            return new Related($this);
        }

        return $this->related;
    }

    /**
     * Get Archive Posts
     *
     * @since 0.1.0
     * @access private
     *
     * @return Archive
     */
    private function getArchive(): Archive
    {
        if (null === $this->archive) {
            return new Archive($this);
        }

        return $this->archive;
    }

    /**
     * Render posts
     *
     * @since 0.1.0
     * @access public
     *
     * @return string Posts.
     */
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
     * Post types
     *
     * @since 0.1.0
     * @access public
     *
     * @return \WP_Post_Type[] Public post types.
     */
    public function postTypes(): array
    {
        return \get_post_types(['public' => true], 'objects');
    }

    /**
     * Taxonomies
     *
     * @since 0.1.0
     * @access public
     *
     * @return \WP_Taxonomy[] Public taxonomies.
     */
    public function taxonomies(): array
    {
        return \get_taxonomies(['public' => true], 'objects');
    }

    /**
     * Posts mods
     *
     * @param string $setting
     * @param array $args
     *
     * @since 0.1.0
     * @access public
     *
     * @return mixed Posts mod.
     */
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

            if ($mod->name) {
                return $mod;
            }
        }

        return $mod;
    }

    /**
     * Is post type pagelike?
     *
     * Determines if post type behaves like
     * the page post type.
     *
     * @param string $post_type
     * @param int $post_id
     *
     * @since 0.1.0
     * @access public
     *
     * @return bool
     */
    public function isPagelike(string $post_type = '', int $post_id = 0): bool
    {
        $check = (
            \is_post_type_hierarchical($post_type) &&
            !\get_post_type_archive_link($post_type)
        );

        if ($check && $post_id) {
            return ($post_id !== (int)\get_option('page_for_posts'));
        }

        return $check;
    }
}
