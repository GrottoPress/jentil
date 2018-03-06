<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil;

use GrottoPress\Jentil\Utilities\Utilities;
use GrottoPress\Jentil\AbstractTheme;

final class Jentil extends AbstractTheme
{
    /**
     * @var Utilities
     */
    private $utilities = null;

    /**
     * Theme Name
     */
    const NAME = 'Jentil';

    /**
     * Theme website URL
     */
    const WEBSITE = 'https://www.grottopress.com/jentil/';

    /**
     * Theme documentation URL
     */
    const DOCUMENTATION = 'https://www.grottopress.com/jentil/';

    protected function __construct()
    {
        $this->setups['Loader'] = new Setups\Loader($this);
        // $this->setups['Updater'] = new Setups\Updater($this);

        $this->setups['Language'] = new Setups\Language($this);
        $this->setups['Thumbnail'] = new Setups\Thumbnail($this);
        $this->setups['Feed'] = new Setups\Feed($this);
        $this->setups['HTML5'] = new Setups\HTML5($this);
        $this->setups['TitleTag'] = new Setups\TitleTag($this);
        $this->setups['Layout'] = new Setups\Layout($this);
        $this->setups['Search'] = new Setups\Search($this);
        $this->setups['Mobile'] = new Setups\Mobile($this);

        $this->setups['MetaBoxes\Layout'] = new Setups\MetaBoxes\Layout($this);

        $this->setups['Styles\Style'] = new Setups\Styles\Style($this);
        $this->setups['Styles\Normalize'] = new Setups\Styles\Normalize($this);
        $this->setups['Styles\FontAwesome'] =
            new Setups\Styles\FontAwesome($this);
        $this->setups['Styles\WordPressPosts'] =
            new Setups\Styles\WordPressPosts($this);

        $this->setups['Scripts\Script'] = new Setups\Scripts\Script($this);
        $this->setups['Scripts\Menu'] = new Setups\Scripts\Menu($this);
        $this->setups['Scripts\CommentReply'] =
            new Setups\Scripts\CommentReply($this);
        $this->setups['Scripts\CustomizePreview'] =
                new Setups\Scripts\CustomizePreview($this);

        $this->setups['Menus\Primary'] = new Setups\Menus\Primary($this);

        $this->setups['Customizer\Customizer'] =
            new Setups\Customizer\Customizer($this);

        $this->setups['PostTypeTemplates\PageBuilder'] =
            new Setups\PostTypeTemplates\PageBuilder($this);
        $this->setups['PostTypeTemplates\PageBuilderBlank'] =
            new Setups\PostTypeTemplates\PageBuilderBlank($this);

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

    protected function getUtilities(): Utilities
    {
        if (null === $this->utilities) {
            $this->utilities = new Utilities($this);
        }

        return $this->utilities;
    }

    /**
     * @return Setups\AbstractSetup[]
     */
    protected function getSetups(): array
    {
        $setups = $this->setups;

        unset($setups['Loader'], $setups['Updater']);

        return $setups;
    }

    /**
     * Checks if installed as 'theme' or as 'package'
     */
    public function is(string $mode): bool
    {
        $relDir = (bool)$this->getUtilities()->fileSystem->relativeDir();

        return 'package' === $mode ? $relDir : ('theme' === $mode && !$relDir);
    }
}
