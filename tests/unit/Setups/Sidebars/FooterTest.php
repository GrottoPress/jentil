<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Tests\Unit\Setups\Sidebars;

use Codeception\Util\Stub;
use GrottoPress\Jentil\Tests\Unit\TestCase;
use GrottoPress\Jentil\Setups\Sidebars\Footer;
use GrottoPress\WordPress\SUV\AbstractTheme;
use tad\FunctionMocker\FunctionMocker;

class FooterTest extends TestCase
{
    public function testRegister()
    {
        $footer = new Footer(Stub::makeEmpty(AbstractTheme::class));

        $register_sidebar = FunctionMocker::replace('register_sidebar');
        $esc_html = FunctionMocker::replace('esc_html__', 'Footer');

        $footer->register();

        $register_sidebar->wasCalledOnce();
        $esc_html->wasCalledTimes(2);
        $register_sidebar->wasCalledWithOnce([[
            'name'          => 'Footer',
            'id'            => 'footer-widget-area',
            'description'   => 'Footer',
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        ]]);
    }
}
