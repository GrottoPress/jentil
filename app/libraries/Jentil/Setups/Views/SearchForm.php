<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Views;

use GrottoPress\Jentil\Setups\AbstractSetup;

final class SearchForm extends AbstractSetup
{
    public function run()
    {
        \add_filter('get_search_form', [$this, 'render']);
    }

    /**
     * @see https://developers.google.com/structured-data/slsb-overview
     *
     * @filter get_search_form
     */
    public function render(string $searchform): string
    {
        $home_url = \home_url('/');

        return '<div class="search-wrap" itemscope itemtype="http://schema.org/WebSite">
            <meta itemprop="url" content="'.$home_url.'"/>

            <form role="search" method="get" class="form search" action="'.
                $home_url.'" itemprop="potentialAction" itemscope itemtype="http://schema.org/SearchAction">
                <meta itemprop="target" content="'.$home_url.'?s={s}" />

                <label>
                    <span class="screen-reader-text">'.
                        \esc_html__('Search for:', 'jentil').'</span>

                    <input itemprop="query-input" type="search" placeholder="'.
                        \esc_attr__('Search', 'jentil').
                        '" class="input search" name="s" value="'.
                        (\get_search_query() ?: '').'" />
                </label>

                <button type="submit" class="button submit">
                    <span class="fas fa-search fa-sm" aria-hidden="true"></span>

                    <span class="search-button-text icon-text">'.
                        \esc_html__('Search', 'jentil').'</span>
                </button>
            </form>
        </div>';
    }
}
