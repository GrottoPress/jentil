<?php

/**
 * HTML5
 *
 * @package GrottoPress\Jentil\Setup
 * @since 0.1.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kus Adusei
 */

declare (strict_types = 1);

namespace GrottoPress\Jentil\Setup;

/**
 * HTML5
 *
 * @since 0.1.0
 */
final class HTML5 extends AbstractSetup
{
    /**
     * Run setup
     *
     * @since 0.1.0
     * @access public
     */
    public function run()
    {
        \add_action('after_setup_theme', [$this, 'addSupport']);
        \add_filter('language_attributes', [$this, 'addMicrodata']);
        \add_action('wp_kses_allowed_html', [$this, 'ksesWhitelist'], 10, 2);
    }

    /**
     * Add support for html5
     *
     * @see https://codex.wordpress.org/Theme_Markup
     *
     * @since 0.1.0
     * @access public
     *
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
     * Add Microdata
     *
     * Use schema.org's vocabulary to provide microdata
     * markup for this theme.
     *
     * @see http://www.paulund.co.uk/add-schema-org-wordpress
     *
     * @since 0.1.0
     * @access public
     *
     * @filter language_attributes
     */
    public function addMicrodata(string $output): string
    {
        $page = $this->jentil->utilities->page;

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
        } else {
            $output .= 'WebPage';
        }

        $output .= '"';

        return $output;
    }

    /**
     * Whitelist attributes in WP kses
     *
     * Allow itemscope, itemtype, itemprop and other
     * html5 attributes to pass wp kses filters.
     *
     * @since 0.1.0
     * @access public
     *
     * @filter wp_kses_allowed_html
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
