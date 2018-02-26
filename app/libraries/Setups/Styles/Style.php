<?php

/**
 * Main theme stylesheet
 *
 * @package GrottoPress\Jentil\Setups\Styles
 * @since 0.6.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kusi Adusei
 */

declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Styles;

/**
 * Main theme stylesheet
 *
 * @since 0.6.0
 */
final class Style extends AbstractStyle
{
    /**
     * Enqueue Stylesheet
     *
     * @since 0.6.0
     * @access public
     *
     * @action wp_enqueue_scripts
     */
    public function enqueue()
    {
        $this->id = 'jentil';

        if (\is_rtl()) {
            $style = 'jentil-rtl.min.css';
        } else {
            $style = 'jentil.min.css';
        }

        \wp_enqueue_style(
            $this->id,
            $this->app->utilities->fileSystem->dir(
                'url',
                "/dist/styles/{$style}"
            ),
            ['normalize']
        );
    }
}
