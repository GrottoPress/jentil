<?php

/**
 * Colophon
 *
 * @package GrottoPress\Jentil\Utilities\ThemeMods
 * @since 0.1.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kusi Adusei
 */

declare (strict_types = 1);

namespace GrottoPress\Jentil\Utilities\ThemeMods;

use GrottoPress\Jentil\Jentil;

/**
 * Colophon
 *
 * @since 0.1.0
 */
class Colophon extends AbstractThemeMod
{
    /**
     * ThemeMods
     *
     * @since 0.1.0
     * @access private
     *
     * @var ThemeMods $themeMods ThemeMods.
     */
    private $themeMods;
    
    /**
     * Constructor
     *
     * @param ThemeMods $themeMods
     *
     * @since 0.1.0
     * @access public
     */
    public function __construct(ThemeMods $themeMods)
    {
        $this->themeMods = $themeMods;
        
        $this->id = 'colophon';
        $this->default = \sprintf(
            \esc_html__(
                '&copy; %1$s %2$s. Built with %3$s',
                'jentil'
            ),
            '<span itemprop="copyrightYear">{{this_year}}</span>',
            '<a class="blog-name" itemprop="url" href="{{site_url}}"><span itemprop="copyrightHolder">{{site_name}}</span></a>',
            '<em><a itemprop="url" rel="nofollow" href="'.Jentil::WEBSITE.'">'.Jentil::NAME.'</a></em>.'
        );
    }

    /**
     * Get mod
     *
     * @since 0.1.0
     * @access public
     *
     * @return string
     */
    public function get(): string
    {
        return $this->themeMods->utilities->shortTags->replace(parent::get());
    }
}
