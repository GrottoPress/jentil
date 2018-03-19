<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Utilities\ThemeMods;

use GrottoPress\Jentil\Jentil;

class Colophon extends AbstractThemeMod
{
    /**
     * @var ThemeMods
     */
    private $themeMods;

    public function __construct(ThemeMods $themeMods)
    {
        $this->themeMods = $themeMods;

        $this->id = 'colophon';

        $this->default = \sprintf(
            \esc_html__(
                '&copy; %1$s %2$s. Built with %3$s on %4$s',
                'jentil'
            ),
            '<span itemprop="copyrightYear">{{this_year}}</span>',
            '<a class="blog-name" itemprop="url" href="{{site_url}}"><span itemprop="copyrightHolder">{{site_name}}</span></a>',
            '<em><a itemprop="url" rel="nofollow" href="'.Jentil::WEBSITE.'">'.Jentil::NAME.'</a></em>',
            '<a itemprop="url" rel="nofollow" href="https://wordpress.org">WordPress</a>.'
        );
    }

    public function get(): string
    {
        return $this->themeMods->utilities->shortTags->replace(parent::get());
    }
}
