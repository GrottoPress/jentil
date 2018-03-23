<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Customizer\Posts\Settings;

use GrottoPress\Jentil\Setups\Customizer\Posts\AbstractSection;

final class PaginationPreviousText extends AbstractSetting
{
    public function __construct(AbstractSection $section)
    {
        parent::__construct($section);

        $themeMod = $this->themeMod('pagination_previous_text');

        $this->id = $themeMod->id;

        $this->args['default'] = $themeMod->default;
        $this->args['sanitize_callback'] = 'sanitize_text_field';

        $this->control['label'] = \esc_html__(
            'Previous page link label',
            'jentil'
        );
        $this->control['type'] = 'text';
    }
}
