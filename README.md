# Jentil

Jentil is a modern framework for rapid WordPress theme development. It is packed with predefined, pluggable features, including powerful content options which allows to configure how posts display on archives right from the customizer.

Jentil may be installed either as a parent theme, or as a package (eg: via composer) in another theme.

Jentil features six layout options, configured via the customizer and post meta boxes. It can be used to build blogs, magazines, e-commerce, corporate websites and more.

Jentil comes with page builder post type templates, and integrates seamlessly with most WordPress site builders, including:

- [Beaver Builder](https://wordpress.org/plugins/beaver-builder-lite-version/)
- [SiteOrigin](https://wordpress.org/plugins/siteorigin-panels/)
- [Elementor](https://wordpress.org/plugins/elementor/)
- [Live Composer](https://wordpress.org/plugins/live-composer-page-builder/)

We are following, closely, the development of [Gutenberg](https://wordpress.org/plugins/gutenberg/). We will be ready when Gutenberg is ready!

## Features

### For the End User:
- Powerful posts display options via the customizer.
- Page builder post type templates
- Six (6) layout options  
    * Content
    * Content / Sidebar
    * Sidbar / Content
    * Sidebar / Content / Sidebar
    * Content / Sidebar / Sidebar
    * Sidebar / Sidebar / Content
- HTML5 / CSS3
- SEO-ready
- Responsive (mobile-ready)

### For the Developer:
- Use as package in another theme, or as parent theme for a child theme.
- Numerous action and filter hooks to allow easy extension via child themes and plugins.
- Cleanly-commented, object-oriented codebase.
- Modern web development tools (npm, composer, gulp, sass, git etc).
- Enforced a more organised directory structure in parent and child themes. Templates (eg: single.php, page.php etc) are loaded only from the `app/templates` directory, and partials (eg: sidebar.php, header.php etc) from the `app/partials` directory.
- Compliant with [PSR-1](http://www.php-fig.org/psr/psr-1/), [PSR-2](http://www.php-fig.org/psr/psr-2/) and [PSR-4](http://www.php-fig.org/psr/psr-4/).

## Requirements

*Jentil* requires **WordPress** version **4.7** or newer. Minimum required **PHP** version is **7.0**.

## Installation

**Disclaimer:** *This software is still in development. Use at your own risk.*

- Download and install the [jentil-child](#) theme to get started. (Link to be posted soon).
- From the jentil-child directory, run `composer update` to update dependencies.
- By default jentil-child installs as starter theme, with *Jentil* as a package. To use jentil-child as a child theme instead, run `composer run child`. Use `composer run starter` to switch back to starter theme mode.
- Rename jentil-child to a new name via `composer run rename my-new-theme-name-here`
- Activate the new theme.
- Head over to the [documentation](#) and start hacking your new theme. (Link to be posted soon)

## Documentation

Link to be posted soon...

## Security

Kindly send an email to *admin [at] grottopress [dot] com* about any security-related issue.

## Showcase

The following websites are powered by Jentil:

- [GrottoPress](https://www.grottopress.com)
