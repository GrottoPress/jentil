<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Tests\Unit\Setups\Sidebars;

use Codeception\Util\Stub;
use GrottoPress\Jentil\Tests\Unit\TestCase;
use GrottoPress\Jentil\Setups\Sidebars\Secondary;
use GrottoPress\WordPress\SUV\AbstractTheme;
use tad\FunctionMocker\FunctionMocker;

class SecondaryTest extends TestCase
{
    public function testRegister()
    {
        $secondary = new Secondary(Stub::makeEmpty(AbstractTheme::class));

        $register_sidebar = FunctionMocker::replace('register_sidebar');
        $esc_html = FunctionMocker::replace('esc_html__', 'Secondary');

        $secondary->register();

        $register_sidebar->wasCalledOnce();
        $esc_html->wasCalledTimes(2);
        $register_sidebar->wasCalledWithOnce([[
            'name'          => 'Secondary',
            'id'            => 'secondary-widget-area',
            'description'   => 'Secondary',
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        ]]);
    }
}
