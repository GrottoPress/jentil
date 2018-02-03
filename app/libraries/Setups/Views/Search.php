<?php

/**
 * Search
 *
 * @package GrottoPress\Jentil\Setups\Views
 * @since 0.1.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kusi Adusei
 */

declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Views;

use GrottoPress\Jentil\Setups\AbstractSetup;

/**
 * Search
 *
 * @since 0.1.0
 */
final class Search extends AbstractSetup
{
    /**
     * Run setup
     *
     * @since 0.1.0
     * @access public
     */
    public function run()
    {
        \add_action('template_redirect', [$this, 'redirect']);
        \add_action('jentil_before_content', [$this, 'render']);
    }

    /**
     * Redirect
     *
     * Redirect `/?s={query}` to `/search/{query}`
     *
     * @since 0.6.0
     * @access public
     *
     * @action template_redirect
     */
    public function redirect()
    {
        if (!$this->app->utilities->page->is('search')) {
            return;
        }

        if (!$this->searchQuery()) {
            return;
        }

        global $wp_rewrite;

        if (!$wp_rewrite->using_permalinks()) {
            return;
        }

        \wp_redirect(\get_search_link(), 301);

        exit;
    }

    /**
     * Render search form on search page
     *
     * @since 0.1.0
     * @access public
     *
     * @action jentil_before_content
     */
    public function render()
    {
        if (!$this->app->utilities->page->is('search')) {
            return;
        }

        \get_search_form();
    }

    /**
     * Search query
     *
     * Returns the value of the 's' query parameter in the
     * current page's URL.
     *
     * Unlike WordPress' `get_search_query()`, this looks for
     * the presence of 's' query parameter in the URL, and
     * ignores any URL rewrites of the search page URL.
     *
     * @since 0.6.0
     * @access private
     *
     * @return string
     */
    private function searchQuery(): string
    {
        $url = \parse_url($this->app->utilities->page->URL('full'));
        \parse_str((string)$url['query'], $query_params);

        return $query_params['s'] ?? '';
    }
}
