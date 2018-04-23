<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups;

final class HTML5 extends AbstractSetup
{
    public function run()
    {
        \add_action('after_setup_theme', [$this, 'addSupport']);
        \add_filter('language_attributes', [$this, 'addMicrodata']);
        \add_filter('wp_kses_allowed_html', [$this, 'ksesWhitelist'], 10, 2);
    }

    /**
     * @action after_setup_theme
     */
    public function addSupport()
    {
        \add_theme_support('html5', [
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'widgets',
        ]);
    }

    /**
     * @filter language_attributes
     */
    public function addMicrodata(string $output): string
    {
        $page = $this->app->utilities->page;

        if ($page->is('admin') || $page->is('login') || $page->is('register')) {
            return $output;
        }

        $output .= ' itemscope itemtype="http://schema.org/';

        if ($page->is('home')) {
            $output .= 'Blog';
        } elseif ($page->is('author')) {
            $output .= 'ProfilePage';
        } elseif ($page->is('search')) {
            $output .= 'SearchResultsPage';
        } elseif ($page->is('singular', 'post')) {
            $output .= 'BlogPosting';
        } elseif ($page->is('attachment')) {
            $output .= 'MediaObject';
        } else {
            $output .= 'WebPage';
        }

        $output .= '"';

        return $output;
    }

    /**
     * @filter wp_kses_allowed_html
     * @return bool[string][string]
     */
    public function ksesWhitelist(array $allowed, string $context): array
    {
        if (!isset($allowed['span'])) {
            $allowed['span'] = [
                'dir' => true,
                'align' => true,
                'lang' => true,
                'xml:lang' => true,
            ];
        }

        foreach ($allowed as $tag => $atts) {
            $allowed[$tag]['itemprop'] = true;
            $allowed[$tag]['itemscope'] = true;
            $allowed[$tag]['itemtype'] = true;
            $allowed[$tag]['itemref'] = true;
            $allowed[$tag]['itemid'] = true;
        }

        return $allowed;
    }
}
