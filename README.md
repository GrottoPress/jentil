# Jentil

Jentil is a modern framework for rapid WordPress theme development. It is packed with predefined, pluggable features, including powerful content options which allows to configure how posts display on archives right from the customizer.

Jentil features six layout options, configured via the customizer and post meta boxes. Jentil can be used to build blogs, magazines, e-commerce, corporate websites and more.

It integrates seamlessly with most WordPress page builders, including:

- [Beaver Builder](https://wordpress.org/plugins/beaver-builder-lite-version/)
- [SiteOrigin](https://wordpress.org/plugins/siteorigin-panels/)
- [Elementor](https://wordpress.org/plugins/elementor/)
- [Live Composer](https://wordpress.org/plugins/live-composer-page-builder/)

## Features

### For the End User:
- Powerful posts/content display options via the customizer.
- Page builder page/post templates
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

This theme requires **WordPress** version **4.7** or newer. Minimum required **PHP** version is **7.0**.

## Installation

**Disclaimer:** *This software is still in development. Use at your own risk.*

Jentil can be installed either one of 2 modes: As a parent theme for a child theme, or as a package in another theme.

### Install as parent theme

- Download and install the [jentil-child](#) theme to get started. (Link to be posted soon).
- Download Jentil from [here](https://api.grottopress.com/wp-update-server/v1/?action=download&slug=jentil) (in *zip* format), and install.
- Activate the jentil-child theme.
- Head over to the documentation and start creating your child theme. (Link to be posted soon)

### Install as package

You should have [composer](https://getcomposer.org/) and [npm](https://www.npmjs.com/) installed.

- Download and install the [jentil-starter](#) theme (Link to be posted soon).
- From the starter theme's directory, via the command line, enter `composer update` to install packages.
- This would install Jentil (as a package) and all dependencies. Alternatively: `composer require grottopress/jentil`.
- Head over to the documentation and start creating your theme. (Link to be posted soon)

## Documentation

Link to be posted soon...

## Security

Kindly send an email to *admin [at] grottopress [dot] com* about any security-related issue.

## Showcase

The following websites are powered by Jentil:

- [GrottoPress](https://www.grottopress.com)
