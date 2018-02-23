<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Tests\Unit\Setups\PostTypeTemplates;

use Codeception\Util\Stub;
use GrottoPress\Jentil\Tests\Unit\AbstractTestCase;
use GrottoPress\Jentil\Setups\PostTypeTemplates\PageBuilder;
use GrottoPress\Jentil\AbstractTheme;
use tad\FunctionMocker\FunctionMocker;

class PageBuildersTest extends AbstractTestCase
{
    public function testAdd()
    {
        $pageBuilder = new PageBuilder(Stub::makeEmpty(AbstractTheme::class));

        FunctionMocker::replace('esc_html__', 'Page builder');

        $this->assertSame(
            [
                'my-template.php' => 'My template',
                'page-builder.php' => 'Page builder',
            ],
            $pageBuilder->add(['my-template.php' => 'My template'], null, null, '')
        );
    }
}
