<?php

/**
 * Pagebuilder (blank) template
 *
 * @package GrottoPress\Jentil
 * @since 0.5.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kusi Adusei
 */

declare (strict_types = 1);

/**
 * Load header template
 *
 * @since 0.5.0
 */
\Jentil()->utilities->loader->loadPartial('header', 'micro');

\the_post();

\the_content();

/**
 * Load footer template
 *
 * @since 0.5.0
 */
\Jentil()->utilities->loader->loadPartial('footer', 'micro');
