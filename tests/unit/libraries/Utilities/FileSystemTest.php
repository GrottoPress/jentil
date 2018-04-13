<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Utilities;

use Codeception\Util\Stub;
use GrottoPress\Jentil\AbstractTestCase;
use tad\FunctionMocker\FunctionMocker;

class FileSystemTest extends AbstractTestCase
{
    /**
     * @dataProvider dirProvider
     * @var string $mode 'package' or 'theme'
     */
    public function testDir(string $append, string $mode)
    {
        $this->markTestSkipped('Mock `dirname()` not working');

        $dir_name = (
            'theme' === $mode ?
            '/var/www/themes/jentil' :
            '/var/www/themes/kuul/vendor/jentil'
        );

        FunctionMocker::replace('dirname', $dir_name);
        FunctionMocker::replace('get_theme_root', '/var/www/themes');
        FunctionMocker::replace('get_theme_root_uri', 'http://my.site/themes');

        $fileSystem = new FileSystem(Stub::makeEmpty(Utilities::class));

        $this->assertSame(
            (
                'theme' === $mode ?
                "/var/www/themes/jentil{$append}" :
                "/var/www/themes/kuul/vendor/jentil{$append}"
            ),
            $fileSystem->dir('path', $append)
        );

        $this->assertSame(
            (
                'theme' === $mode ?
                "http://my.site/themes/jentil{$append}" :
                "http://my.site/themes/kuul/vendor/jentil{$append}"
            ),
            $fileSystem->dir('url', $append)
        );
    }

    public function dirProvider(): array
    {
        return [
            'jentil installed as theme' => ['/assets', 'theme'],
        ];
    }
}
