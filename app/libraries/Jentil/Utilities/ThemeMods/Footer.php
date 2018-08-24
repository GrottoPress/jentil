<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Utilities\ThemeMods;

use GrottoPress\Jentil\Utilities\ThemeMods;
use GrottoPress\Jentil;

class Footer extends AbstractThemeMod
{
    /**
     * @var ThemeMods
     */
    private $themeMods;

    /**
     * @var string
     */
    private $setting;

    public function __construct(ThemeMods $theme_mods, string $setting)
    {
        $this->themeMods = $theme_mods;
        $this->setting = \sanitize_key($setting);

        $this->id = $this->id();
        $this->default = $this->default();
    }

    public function get()
    {
        if ('colophon' === $this->setting) {
            return $this->themeMods->utilities->shortTags->replace(
                parent::get()
            );
        }

        return parent::get();
    }

    private function id(): string
    {
        return \sanitize_key(\apply_filters(
            'jentil_footer_mod_id',
            "footer_{$this->setting}",
            $this->setting
        ));
    }

    private function default()
    {
        return \apply_filters(
            'jentil_footer_mod_default',
            ($this->defaults()[$this->setting] ?? null),
            $this->setting
        );
    }

    /**
     * @return mixed[string]
     */
    private function defaults(): array
    {
        return [
            'colophon' => $this->colophonDefault(),
        ];
    }

    private function colophonDefault(): string
    {
        return \sprintf(
            \esc_html__('&copy; %1$s %2$s. Built with %3$s on %4$s', 'jentil'),
            '<span itemprop="copyrightYear">{{this_year}}</span>',
            '<a class="blog-name" itemprop="url" href="{{site_url}}">'.
                '<span itemprop="copyrightHolder">{{site_name}}</span></a>',
            '<em><a itemprop="url" rel="nofollow" href="'.
                Jentil::URI.'">'.Jentil::NAME.'</a></em>',
            '<a itemprop="url" rel="nofollow" href="https://wordpress.org">WordPress</a>.'
        );
    }
}
