<?php
declare (strict_types = 1);

/**
 * This is for plugins that use their own template loaders,
 * thereby bypassing the `{$type}_template_hierarchy` filter.
 */
if (\Jentil()->utilities->page->is('singular')) {
    \Jentil()->utilities->loader->loadTemplate('singular');
} else {
    \Jentil()->utilities->loader->loadTemplate('index');
}
