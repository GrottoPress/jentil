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
     */
    public function testDir(string $append)
    {
        $this->markTestSkipped();

        $fileSystem = Stub::make(FileSystem::class, [
            'dirPath' => '/var/www/vendor/jentil',
            'dirUrl' => 'http://my.site/themes/vendor/jentil',
        ]);
        $fileSystem->dirPath = '/var/www/vendor/jentil';
        $fileSystem->dirUrl = 'http://my.site/themes/vendor/jentil';

        $this->assertSame(
            "/var/www/vendor/jentil{$append}",
            $fileSystem->dir('path', $append)
        );

        $this->assertSame(
            "http://my.site/themes/vendor/jentil{$append}",
            $fileSystem->dir('url', $append)
        );
    }

    public function dirProvider(): array
    {
        return [
            'no append' => [''],
            'with append' => ['/hello'],
        ];
    }
}
