<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\PostTypeTemplates;

use Codeception\Util\Stub;
use GrottoPress\Jentil\AbstractTestCase;
use GrottoPress\Jentil\AbstractTheme;
use tad\FunctionMocker\FunctionMocker;

class PageBuildersTest extends AbstractTestCase
{
    public function testAdd()
    {
        FunctionMocker::replace('esc_html__', 'Page builder');

        $pageBuilder = new PageBuilder(Stub::makeEmpty(AbstractTheme::class));

        $this->assertSame(
            [
                'my-template.php' => 'My template',
                'page-builder.php' => 'Page builder',
            ],
            $pageBuilder->add([
                'my-template.php' => 'My template',
            ], null, null, '')
        );
    }
}
