<?php
declare (strict_types = 1);

\Jentil()->utilities->loader->loadPartial('header', 'micro');

\the_post();

\the_content();

\Jentil()->utilities->loader->loadPartial('footer', 'micro');
