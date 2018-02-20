<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Tests\Unit\Setups\Sidebars;

use Codeception\Util\Stub;
use GrottoPress\Jentil\Tests\Unit\TestCase;
use GrottoPress\Jentil\Setups\Sidebars\Primary;
use GrottoPress\Jentil\AbstractTheme;
use tad\FunctionMocker\FunctionMocker;

class PrimaryTest extends TestCase
{
    public function testRegister()
    {
        $primary = new Primary(Stub::makeEmpty(AbstractTheme::class));

        $register_sidebar = FunctionMocker::replace('register_sidebar');
        $esc_html = FunctionMocker::replace('esc_html__', 'Primary');

        $primary->register();

        $register_sidebar->wasCalledOnce();
        $esc_html->wasCalledTimes(2);
        $register_sidebar->wasCalledWithOnce([[
            'name'          => 'Primary',
            'id'            => 'primary-widget-area',
            'description'   => 'Primary',
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        ]]);
    }
}
