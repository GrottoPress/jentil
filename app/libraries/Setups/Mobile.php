<?php

/**
 * Mobile
 *
 * @package GrottoPress\Jentil\Setups
 * @since 0.1.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kusi Adusei
 */

declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups;

use GrottoPress\WordPress\SUV\Setups\AbstractSetup;

/**
 * Mobile
 *
 * @since 0.1.0
 */
final class Mobile extends AbstractSetup
{
    /**
     * Run setup
     *
     * @since 0.1.0
     * @access public
     */
    public function run()
    {
        \add_filter('body_class', [$this, 'addBodyClasses']);
    }

    /**
     * Add body classes
     *
     * Add classes to <body> tag based on device types.
     *
     * @since 0.1.0
     * @access public
     *
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
