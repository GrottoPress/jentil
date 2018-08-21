<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups;

final class Mobile extends AbstractSetup
{
    public function run()
    {
        \add_filter('body_class', [$this, 'addBodyClasses']);
    }

    /**
     * @filter body_class
     * @param string[int] $classes
     * @return string[int]
     */
    public function addBodyClasses(array $classes): array
    {
        $detector = $this->app->utilities->mobileDetector;

        if (!$detector->isMobile()) {
            $classes[] = 'desktop';

            return $classes;
        }

        $classes[] = 'mobile';

        if ($detector->isTablet()) {
            $classes[] = 'tablet';
        } elseif ($detector->isPhone()) {
            $classes[] = 'phone';
        }

        if ($os = $detector->getOperatingSystem()) {
            $classes[] = \sanitize_html_class($os);
        }

        if ($browser = $detector->getBrowser()) {
            $classes[] = \sanitize_html_class($browser);
        }

        if ($device = $detector->getDevice()) {
            $classes[] = \sanitize_html_class($device);
        }

        return $classes;
    }
}
