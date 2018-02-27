<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Tests\Unit\Setups\PostTypeTemplates;

use Codeception\Util\Stub;
use GrottoPress\Jentil\Tests\Unit\AbstractTestCase;
use GrottoPress\Jentil\Setups\PostTypeTemplates\PageBuilderBlank;
use GrottoPress\Jentil\AbstractTheme;
use tad\FunctionMocker\FunctionMocker;

class PageBuildersBlankTest extends AbstractTestCase
{
    public function testAdd()
    {
        $pageBuilder = new PageBuilderBlank(
            Stub::makeEmpty(AbstractTheme::class)
        );

        FunctionMocker::replace('esc_html__', 'Page builder (blank)');

        $this->assertSame(
            [
                'my-template.php' => 'My template',
                'page-builder-blank.php' => 'Page builder (blank)',
            ],
            $pageBuilder->add([
                'my-template.php' => 'My template',
            ], null, null, '')
        );
    }
}
