<?php

/**
 * Jentil
 *
 * @package GrottoPress\Jentil
 * @since 0.1.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kus Adusei
 */

declare (strict_types = 1);

namespace GrottoPress\Jentil;

use GrottoPress\Jentil\Utilities\Utilities;
use GrottoPress\WordPress\SUV\AbstractApp;

/**
 * Jentil
 *
 * @since 0.1.0
 */
final class Jentil extends AbstractApp
{
    /**
     * Theme utilities
     *
     * @since 0.1.0
     * @access private
     *
     * @var Utilities
     */
    private $utilities = null;

    /**
     * Theme Name
     *
     * @since 0.1.0
     */
    const NAME = 'Jentil';

    /**
     * Theme website URL
     *
     * @since 0.1.0
     */
    const WEBSITE = 'https://jentil.grottopress.com';

    /**
     * Theme documentation URL
     *
     * @since 0.1.0
     */
    const DOCUMENTATION = 'https://www.grottopress.com/docs/themes/jentil/';

    /**
     * Constructor
     *
     * @since 0.1.0
     * @access protected
     */
    protected function __construct()
    {
        $this->setups['loader'] = new Setups\Loader($this);
        // $this->setups['updater'] = new Setups\Updater($this);
        $this->setups['language'] = new Setups\Language($this);
        $this->setups['styles'] = new Setups\Styles($this);
        $this->setups['scripts'] = new Setups\Scripts($this);
        $this->setups['thumbnails'] = new Setups\Thumbnails($this);
        $this->setups['feeds'] = new Setups\Feeds($this);
        $this->setups['html5'] = new Setups\HTML5($this);
        $this->setups['title'] = new Setups\Title($this);
        $this->setups['layout'] = new Setups\Layout($this);
        $this->setups['archives'] = new Setups\Archives($this);
        $this->setups['search'] = new Setups\Search($this);
        $this->setups['menu'] = new Setups\Menu($this);
        $this->setups['breadcrumbs'] = new Setups\Breadcrumbs($this);
        $this->setups['singular'] = new Setups\Singular($this);
        $this->setups['comments'] = new Setups\Comments($this);
        $this->setups['widgets'] = new Setups\Widgets($this);
        $this->setups['colophon'] = new Setups\Colophon($this);
        $this->setups['customizer'] = new Setups\Customizer\Customizer($this);
        $this->setups['metaboxes'] = new Setups\Metaboxes($this);
        $this->setups['mobile'] = new Setups\Mobile($this);
        $this->setups['page_builder_templates'] =
            new Setups\PageBuilderTemplates($this);
    }

    /**
     * Get utilities
     *
     * @since 0.1.0
     * @access protected
     *
     * @return Utilities
     */
    protected function getUtilities(): Utilities
    {
        if (null === $this->utilities) {
            $this->utilities = new Utilities($this);
        }

        return $this->utilities;
    }

    /**
     * Get setups
     *
     * @since 0.1.0
     * @access protected
     *
     * @return Setups\AbstractSetups[]
     */
    protected function getSetups(): array
    {
        $setups = $this->setups;

        unset($setups['loader']);
        unset($setups['updater']);

        return $setups;
    }
}
