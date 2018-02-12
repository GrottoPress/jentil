<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Tests\Unit\Setups\CustomTemplates;

use Codeception\Util\Stub;
use GrottoPress\Jentil\Tests\Unit\TestCase;
use GrottoPress\Jentil\Setups\CustomTemplates\PageBuilder;
use GrottoPress\WordPress\SUV\AbstractTheme;
use tad\FunctionMocker\FunctionMocker;

class PageBuildersTest extends TestCase
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
