<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Tests\Unit\Utilities\Page\Posts;

use Codeception\Util\Stub;
use GrottoPress\Jentil\Tests\Unit\AbstractTestCase;
use GrottoPress\Jentil\Utilities\ThemeMods\Posts as PostsMod;
use GrottoPress\Jentil\Utilities\Page\Posts\Posts;
use GrottoPress\Jentil\Utilities\Page\Posts\Related;
use GrottoPress\Jentil\Utilities\Page\Posts\Singular;
use tad\FunctionMocker\FunctionMocker;

class RelatedTest extends AbstractTestCase
{
    public function testThemeMod()
    {
        $this->markTestSkipped();

        $posts = Stub::makeEmpty(Posts::class, [
            'themeMod' => Stub::constructEmpty(
                PostsMod::class,
                [Stub::makeEmpty(ThemeMods::class), $setting, $args],
                [
                    'get' => \json_encode([$setting, $args]),
                ]
            ),
        ]);

        $posts->singular = Stub::makeEmpty(Singular::class, [
            'postType' => 'post',
        ]);

        $related = new Related($posts);

        $this->assertSame(
            ['setting', ['context' => 'related', 'specific' => 'post']],
            $related->themeMod('heading')
        );
    }
}
