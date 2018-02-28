<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Tests\Unit\Setups\Customizer;

use Codeception\Util\Stub;
use GrottoPress\Jentil\Tests\Unit\AbstractTestCase;
use GrottoPress\Jentil\Setups\Customizer\Customizer;
use GrottoPress\Jentil\Utilities\Utilities;
use GrottoPress\Jentil\Utilities\FileSystem;
use GrottoPress\Jentil\Utilities\ShortTags;
use GrottoPress\Jentil\AbstractTheme;
use tad\FunctionMocker\FunctionMocker;

class CustomizerTest extends AbstractTestCase
{
    public function testRun()
    {
        $customizer = new Customizer(Stub::makeEmpty(AbstractTheme::class));

        $add_action = FunctionMocker::replace('add_action');

        $customizer->run();

        $add_action->wasCalledWithOnce([
            'after_setup_theme',
            [$customizer, 'enableSelectiveRefresh'],
        ]);
    }

    public function testRegister()
    {
        $this->markTestSkipped();
    }

    public function testEnableSelectiveRefresh()
    {
        $customizer = new Customizer(Stub::makeEmpty(AbstractTheme::class));

        $add_theme_support = FunctionMocker::replace('add_theme_support');

        $customizer->enableSelectiveRefresh();

        $add_theme_support->wasCalledOnce();
        $add_theme_support->wasCalledWithOnce([
            'customize-selective-refresh-widgets'
        ]);
    }
}
