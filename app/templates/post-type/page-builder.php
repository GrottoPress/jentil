<?php
declare (strict_types = 1);

\Jentil()->utilities->loader->loadPartial('header', 'mini');

\the_post();

\the_content();

\Jentil()->utilities->loader->loadPartial('footer', 'mini');
