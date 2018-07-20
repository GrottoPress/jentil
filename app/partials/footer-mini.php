<?php
declare (strict_types = 1); ?>

</main><!-- #main -->

<?php \do_action('jentil_before_footer'); ?>

<footer id="footer" class="site-footer" itemscope itemtype="http://schema.org/WPFooter">
    <?php \do_action('jentil_inside_footer'); ?>
</footer><!-- #footer -->

<?php \Jentil()->utilities->loader->loadPartial('footer', 'micro');
