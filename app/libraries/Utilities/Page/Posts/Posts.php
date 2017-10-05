<?php

/**
 * Posts
 *
 * @package GrottoPress\Jentil\Utilities\Page\Posts
 * @since 0.1.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kus Adusei
 */

declare (strict_types = 1);

namespace GrottoPress\Jentil\Utilities\Page\Posts;

use GrottoPress\Jentil\Utilities\Page\Page;

/**
 * Posts
 *
 * @since 0.1.0
 */
final class Posts
{
    /**
     * Page
     *
     * @since 0.1.0
     * @access private
     *
     * @var Page $page Page.
     */
    private $page;

    /**
     * Sticky Posts
     *
     * @since 0.1.0
     * @access private
     *
     * @var Sticky $sticky Sticky posts.
     */
    private $sticky;

    /**
     * Singular Posts
     *
     * @since 0.1.0
     * @access private
     *
     * @var Singular $singular Singular posts.
     */
    private $singular;

    /**
     * Archive Posts
     *
     * @since 0.1.0
     * @access private
     *
     * @var Archive $archive Archive posts.
     */
    private $archive;
    
    /**
     * Constructor
     *
     * @param Page $page Page.
     *
     * @since 0.1.0
     * @access public
     */
    public function __construct(Page $page)
    {
        $this->page = $page;

        $this->sticky = new Sticky($this);
        $this->singular = new Singular($this);
        $this->archive =  new Archive($this);
    }

    /**
     * Get Page
     *
     * @since 0.1.0
     * @access public
     *
     * @return Page
     */
    public function page()
    {
        return $this->page;
    }

    /**
     * Get Sticky Posts
     *
     * @since 0.1.0
     * @access public
     *
     * @return Sticky
     */
    public function sticky()
    {
        return $this->sticky;
    }

    /**
     * Get Archive Posts
     *
     * @since 0.1.0
     * @access public
     *
     * @return Sticky
     */
    public function archive()
    {
        return $this->archive;
    }

    /**
     * Get Posts
     *
     * @since 0.1.0
     * @access public
     *
     * @return string Posts.
     */
    public function render(): string
    {
        $out = '';

        if (!$this->page->is('singular')
            && !$this->page->is('paged')
            && $this->sticky->isSet()
            && $this->sticky->get()
        ) {
            $out .= $this->page->utilities()->posts(
                $this->sticky->args()
            )->render();
        }

        if ($this->page->is('singular')) {
            $out .= $this->page->utilities()->posts(
                $this->singular->args()
            )->render();
        } else {
            $out .= $this->page->utilities()->posts(
                $this->archive->args()
            )->render();
        }

        return $out;
    }

    /**
     * Post types
     *
     * @since 0.1.0
     * @access public
     *
     * @return array Public post types.
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
     * @return array Public taxonomies.
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
    public function mod(string $setting, array $args = [])
    {
        if (!empty($args['context'])) {
            return $this->page->utilities()->mods()->posts(
                $setting,
                $args
            )->get();
        }

        $page = $this->page->type();

        $specific = '';
        $more_specific = '';

        foreach ($page as $type) {
            if ('post_type_archive' == $type) {
                $specific = \get_query_var('post_type');
            } elseif ('tax' == $type) {
                $specific = \get_query_var('taxonomy');
            } elseif ('category' == $type) {
                $specific = 'category';
            } elseif ('tag' == $type) {
                $specific = 'post_tag';
            }

            if (\is_array($specific)) {
                $specific = $specific[0];
            }

            if (\is_array($more_specific)) {
                $more_specific = $more_specific[0];
            }

            $mod = $this->page->utilities()->mods()->posts($setting, [
                'context' => $type,
                'specific' => $specific,
                'more_specific' => $more_specific,
            ]);

            if ($mod->name()) {
                return $mod->get();
            }
        }

        return $mod->default();
    }
}