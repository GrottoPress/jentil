<?php

/**
 * File System
 *
 * @package GrottoPress\Jentil\Utilities
 * @since 0.1.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kus Adusei
 */

declare (strict_types = 1);

namespace GrottoPress\Jentil\Utilities;

/**
 * File System
 *
 * @since 0.1.0
 */
class FileSystem
{
    /**
     * Utilities
     *
     * @since 0.1.0
     * @access protected
     *
     * @var Utilities $utilities Utilities.
     */
    protected $utilities;

    /**
     * Theme directory path
     *
     * @since 0.1.0
     * @access protected
     *
     * @var string $dirPath Theme directory path.
     */
    protected $dirPath;

    /**
     * Theme directory URI
     *
     * @since 0.1.0
     * @access protected
     *
     * @var string $dirUrl Theme directory URI.
     */
    protected $dirUrl;

    /**
     * Constructor
     *
     * @param Utilities $utilities Utilities.
     *
     * @since 0.1.0
     * @access public
     */
    public function __construct(Utilities $utilities)
    {
        $this->utilities = $utilities;

        $this->dirUrl = \get_template_directory_uri();
        $this->dirPath = \get_template_directory();
    }

    /**
     * Get theme directory
     *
     * @param string $type 'path' or 'url'.
     * @param string $append Filepath to append to URL.
     *
     * @since 0.1.0
     * @access public
     *
     * @return string Path or URL.
     */
    public function themeDir(string $type, string $append = ''): string
    {
        return $this->dir($type, '', $append);
    }

    /**
     * Get JavaScript directory
     *
     * @param string $type 'path' or 'url'.
     * @param string $append Filepath to append to URL.
     * @param string $form 'relative' or 'absolute'.
     *
     * @since 0.1.0
     * @access public
     *
     * @return string Path or URL.
     */
    public function scriptsDir(
        string $type,
        string $append = '',
        string $form = ''
    ): string {
        return $this->dir($type, '/dist/assets/scripts', $append, $form);
    }

    /**
     * Get CSS directory
     *
     * @param string $type 'path' or 'url'.
     * @param string $append Filepath to append to URL.
     * @param string $form 'relative' or 'absolute'.
     *
     * @since 0.1.0
     * @access public
     *
     * @return string Path or URL.
     */
    public function stylesDir(
        string $type,
        string $append = '',
        string $form = ''
    ): string {
        return $this->dir($type, '/dist/assets/styles', $append, $form);
    }

    /**
     * Get partials directory
     *
     * @param string $type 'path' or 'url'.
     * @param string $append Filepath to append to URL.
     * @param string $form 'relative' or 'absolute'.
     *
     * @since 0.1.0
     * @access public
     *
     * @return string Path or URL.
     */
    public function partialsDir(
        string $type,
        string $append = '',
        string $form = ''
    ): string {
        return $this->dir($type, '/app/partials', $append, $form);
    }

    /**
     * Get templates directory
     *
     * @param string $type 'path' or 'url'.
     * @param string $append Filepath to append to URL.
     * @param string $form 'relative' or 'absolute'.
     *
     * @since 0.1.0
     * @access public
     *
     * @return string Path or URL.
     */
    public function templatesDir(
        string $type,
        string $append = '',
        string $form = ''
    ): string {
        return $this->dir($type, '/app/templates', $append, $form);
    }

    /**
     * Get directory URL/path
     *
     * @param string $type 'path' or 'url'.
     * @param string $append Filepath to prepend to URL/path.
     * @param string $append Filepath to append to URL/path.
     * @param string $form 'relative' or 'absolute'.
     *
     * @since 0.1.0
     * @access protected
     *
     * @return string Path or URL.
     */
    protected function dir(
        string $type,
        string $prepend = '',
        string $append = '',
        string $form = ''
    ): string {
        $relative = $prepend.$append;

        if ('relative' == $form) {
            return $relative;
        }

        return $this->{'dir'.\ucfirst($type)}.$relative;
    }
}
