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
            $classes[] = \sanitize_title($os);
        }

        if ($browser = $detector->getBrowser()) {
            $classes[] = \sanitize_title($browser);
        }

        if ($device = $detector->getDevice()) {
            $classes[] = \sanitize_title($device);
        }

        return $classes;
    }
}
