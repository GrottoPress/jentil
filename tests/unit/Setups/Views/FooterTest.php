<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Tests\Unit\Setups\Views;

use Codeception\Util\Stub;
use GrottoPress\Jentil\Tests\Unit\TestCase;
use GrottoPress\Jentil\Setups\Views\Footer;
use GrottoPress\WordPress\SUV\AbstractTheme;
use tad\FunctionMocker\FunctionMocker;

class FooterTest extends TestCase
{
    public function testRun()
    {
        $footer = new Footer(Stub::makeEmpty(AbstractTheme::class));

        $add_action = FunctionMocker::replace('add_action');

        $footer->run();

        $add_action->wasCalledTimes(2);

        $add_action->wasCalledWithOnce([
            'jentil_inside_footer',
            [$footer, 'renderWidgets']
        ]);

        $add_action->wasCalledWithOnce([
            'jentil_inside_footer',
            [$footer, 'renderColophon']
        ]);
    }
}
