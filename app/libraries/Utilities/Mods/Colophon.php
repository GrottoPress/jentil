<?php

/**
 * Colophon
 *
 * @package GrottoPress\Jentil\Utilities\Mods
 * @since 0.1.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kus Adusei
 */

declare (strict_types = 1);

namespace GrottoPress\Jentil\Utilities\Mods;

use GrottoPress\Jentil\Jentil;

/**
 * Colophon
 *
 * @since 0.1.0
 */
final class Colophon extends Mod
{
    /**
     * Constructor
     *
     * @param Mods $mods
     *
     * @since 0.1.0
     * @access public
     */
    public function __construct(Mods $mods)
    {
        $this->name = 'colophon';

        $this->default = \sprintf(
            \esc_html__(
                'Copyright &copy; %1$s %2$s. All rights reserved. Built with %3$s',
                'jentil'
            ),
            '<span itemprop="copyrightYear">{{this_year}}</span>',
            '<a class="blog-name" itemprop="url" href="{{site_url}}"><span itemprop="copyrightHolder">{{site_name}}</span></a>',
            '<em><a itemprop="url" rel="nofollow" href="'.Jentil::WEBSITE.'">'.Jentil::NAME.'</a></em>.'
        );

        parent::__construct($mods);
    }

    /**
     * Get mod
     *
     * @since 0.1.0
     * @access public
     *
     * @return string Mod
     */
    public function get(): string
    {
        return $this->replacePlaceholders(parent::get());
    }

    /**
     * Replace placeholders
     *
     * @since 0.1.0
     * @access private
     *
     * @return string Mod with placeholders replaced.
     */
    private function replacePlaceholders(string $mod): string
    {
        return \str_ireplace(
            [
                '{{site_name}}',
                '{{site_url}}',
                '{{this_year}}',
                '{{site_description}}',
            ],
            [
                \esc_attr(\get_bloginfo('name')),
                \esc_attr(\home_url('/')),
                \esc_attr(\date('Y', \current_time('timestamp'))),
                \esc_attr(\get_bloginfo('description')),
            ],
            $mod
        );
    }
}
