<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Tests\Unit\Setups\CustomTemplates;

use Codeception\Util\Stub;
use GrottoPress\Jentil\Tests\Unit\TestCase;
use GrottoPress\Jentil\Setups\CustomTemplates\PageBuilderBlank;
use GrottoPress\WordPress\SUV\AbstractTheme;
use tad\FunctionMocker\FunctionMocker;

class PageBuildersBlankTest extends TestCase
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
            $pageBuilder->add(['my-template.php' => 'My template'], null, null, '')
        );
    }
}
