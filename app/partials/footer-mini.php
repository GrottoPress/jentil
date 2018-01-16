<?php

/**
 * Footer Template: Reduced
 *
 * @package GrottoPress\Jentil
 * @since 0.1.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kusi Adusei
 */

declare (strict_types = 1); ?>

</div><!-- #main -->

<?php
/**
 * @action jentil_before_footer
 *
 * @since 0.1.0
 */
\do_action('jentil_before_footer'); ?>

<footer id="footer" class="site-footer" itemscope itemtype="http://schema.org/WPFooter">
    <?php
    /**
     * @action jentil_inside_footer
     *
     * @since 0.1.0
     */
    \do_action('jentil_inside_footer'); ?>
</footer><!-- #footer -->

<?php
/**
 * Load footer: Micro
 *
 * @since 0.5.0
 */
\Jentil()->utilities->loader->loadPartial('footer', 'micro');
