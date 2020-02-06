<?php
declare (strict_types = 1);

    \do_action('jentil_before_before_footer'); ?>
</main><!-- #main -->

<?php \do_action('jentil_before_footer'); ?>

<footer id="footer" class="site-footer">
    <?php \do_action('jentil_inside_footer'); ?>
</footer><!-- #footer -->

<?php \Jentil()->utilities->loader->loadPartial('footer', 'micro');
