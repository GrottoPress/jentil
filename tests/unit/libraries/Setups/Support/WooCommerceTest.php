<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Support;

use Codeception\Util\Stub;
use GrottoPress\Jentil\AbstractTestCase;
use GrottoPress\Jentil\AbstractTheme;
use GrottoPress\Jentil\Setups\Customizer\AbstractCustomizer;
use GrottoPress\Jentil\Setups\Customizer\AbstractPanel;
use GrottoPress\Jentil\Setups\Customizer\AbstractSection;
use GrottoPress\Jentil\Setups\Customizer\AbstractSetting;
use tad\FunctionMocker\FunctionMocker;

class WooCommerceTest extends AbstractTestCase
{
    public function testRun()
    {
        $add_action = FunctionMocker::replace('add_action');

        $woo_commerce = new WooCommerce(Stub::makeEmpty(AbstractTheme::class));

        $woo_commerce->run();

        $add_action->wasCalledTimes(2);

        $add_action->wasCalledWithOnce([
            'after_setup_theme',
            [$woo_commerce, 'loadComments']
        ]);

        $add_action->wasCalledWithOnce([
            'customize_register',
            [$woo_commerce, 'removeCustomizerItems'],
            20
        ]);
    }

    public function testLoadComments()
    {
        $this->getMockBuilder('WC_Template_Loader')->getMock();

        $add_filter = FunctionMocker::replace('add_filter');

        $woo_commerce = new WooCommerce(Stub::makeEmpty(AbstractTheme::class));

        $woo_commerce->loadComments();

        $add_filter->wasCalledOnce();
        $add_filter->wasCalledWithOnce([
            'comments_template',
            ['WC_Template_Loader', 'comments_template_loader']
        ]);
    }

    public function testRemoveCustomizerItems()
    {
        $this->getMockBuilder('WooCommerce')->getMock();

        $WPCustomizer = $this->getMockBuilder('WP_Customize_Manager')
            ->getMock();

        $jentil = Stub::makeEmpty(AbstractTheme::class, [
            'setups' => ['Customizer\Customizer' => Stub::makeEmpty(
                AbstractCustomizer::class,
                [
                    'panels' => ['Posts\Posts' => Stub::makeEmpty(
                        AbstractPanel::class,
                        ['sections' => [
                            'Taxonomy_product_cat' => Stub::makeEmpty(
                                AbstractSection::class,
                                ['remove' => true]
                            ),
                            'Taxonomy_product_tag' => Stub::makeEmpty(
                                AbstractSection::class,
                                ['remove' => true]
                            ),
                        ]]
                    )],
                    'sections' => ['Title\Title' => Stub::makeEmpty(
                        AbstractSection::class,
                        ['settings' => [
                            'Taxonomy_product_cat' => Stub::makeEmpty(
                                AbstractSetting::class,
                                ['remove' => true]
                            ),
                            'Taxonomy_product_tag' => Stub::makeEmpty(
                                AbstractSetting::class,
                                ['remove' => true]
                            ),
                        ]]
                    )],
                ]
            )]
        ]);

        $woo_commerce = new WooCommerce($jentil);

        $taxes = ['product_tag', 'product_cat'];

        foreach ($taxes as $tax) {
            $jentil->setups['Customizer\Customizer']
                ->panels['Posts\Posts']->sections["Taxonomy_{$tax}"]
                ->expects($this->once())->method('remove')
                ->with($this->equalTo($WPCustomizer));

            $jentil->setups['Customizer\Customizer']
                ->sections['Title\Title']->settings["Taxonomy_{$tax}"]
                ->expects($this->once())->method('remove')
                ->with($this->equalTo($WPCustomizer));
        }

        $woo_commerce->removeCustomizerItems($WPCustomizer);
    }
}
