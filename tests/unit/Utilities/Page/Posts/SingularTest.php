<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Tests\Unit\Utilities\Page\Posts;

use Codeception\Util\Stub;
use GrottoPress\Jentil\Tests\Unit\TestCase;
use GrottoPress\Jentil\Utilities\Page\Posts\Posts;
use GrottoPress\Jentil\Utilities\Page\Posts\Singular;
use tad\FunctionMocker\FunctionMocker;

class SingularTest extends TestCase
{
    public function testPostType()
    {
        FunctionMocker::replace('get_post_type', 'tutorial');

        $singular = new Singular(Stub::makeEmpty(Posts::class));

        $this->assertSame('tutorial', $singular->postType());
    }
}
