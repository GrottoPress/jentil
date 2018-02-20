<?php

/**
 * Jentil
 *
 * @package GrottoPress\Jentil
 * @since 0.1.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kusi Adusei
 */

declare (strict_types = 1);

namespace GrottoPress\Jentil;

use GrottoPress\Jentil\Utilities\Utilities;
use GrottoPress\Jentil\AbstractTheme;

/**
 * Jentil
 *
 * @since 0.1.0
 */
final class Jentil extends AbstractTheme
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
        $this->setups['Loader'] = new Setups\Loader($this);
        // $this->setups['Updater'] = new Setups\Updater($this);
        $this->setups['Language'] = new Setups\Language($this);
        $this->setups['Styles'] = new Setups\Styles($this);
        $this->setups['Scripts'] = new Setups\Scripts($this);
        $this->setups['Thumbnails'] = new Setups\Thumbnails($this);
        $this->setups['Feeds'] = new Setups\Feeds($this);
        $this->setups['HTML5'] = new Setups\HTML5($this);
        $this->setups['Title'] = new Setups\Title($this);
        $this->setups['Layout'] = new Setups\Layout($this);
        $this->setups['Search'] = new Setups\Search($this);
        $this->setups['Menu'] = new Setups\Menu($this);
        $this->setups['Comments'] = new Setups\Comments($this);
        $this->setups['Customizer\Customizer'] =
            new Setups\Customizer\Customizer($this);
        $this->setups['Metaboxes'] = new Setups\Metaboxes($this);
        $this->setups['Mobile'] = new Setups\Mobile($this);

        $this->setups['CustomTemplates\PageBuilder'] =
            new Setups\CustomTemplates\PageBuilder($this);
        $this->setups['CustomTemplates\PageBuilderBlank'] =
            new Setups\CustomTemplates\PageBuilderBlank($this);

        $this->setups['Sidebars\Primary'] =
            new Setups\Sidebars\Primary($this);
        $this->setups['Sidebars\Secondary'] =
            new Setups\Sidebars\Secondary($this);
        $this->setups['Sidebars\Footer'] = new Setups\Sidebars\Footer($this);

        $this->setups['Views\Archive'] = new Setups\Views\Archive($this);
        $this->setups['Views\Search'] = new Setups\Views\Search($this);
        $this->setups['Views\Singular'] = new Setups\Views\Singular($this);
        $this->setups['Views\Breadcrumbs'] =
            new Setups\Views\Breadcrumbs($this);
        $this->setups['Views\Header'] = new Setups\Views\Header($this);
        $this->setups['Views\Footer'] = new Setups\Views\Footer($this);
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

        unset($setups['Loader'], $setups['Updater']);

        return $setups;
    }

    /**
     * Check install mode
     *
     * Checks if installed as 'theme' or as 'package'.
     *
     * @param string $type
     *
     * @since 0.6.0
     * @access public
     *
     * @return bool
     */
    public function is(string $type): bool
    {
        $relDir = (bool)$this->getUtilities()->fileSystem->relativeDir();

        return 'package' === $type ? $relDir : ('theme' === $type && !$relDir);
    }
}
