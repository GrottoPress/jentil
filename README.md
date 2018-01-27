# Jentil

Jentil is a modern framework for rapid WordPress theme development. It is packed with predefined, pluggable features, including powerful content options which allows to configure how posts display on archives right from the customizer.

Jentil may be installed either as a parent theme, or as a package (eg: via composer) in another theme.

Jentil features six layout options, configured via the customizer and post meta boxes. It can be used to build blogs, magazines, e-commerce, corporate websites and more.

Jentil comes with page builder [post type templates](https://make.wordpress.org/core/2016/11/03/post-type-templates-in-4-7/), and integrates seamlessly with most WordPress site builders, including:

- [Beaver Builder](https://wordpress.org/plugins/beaver-builder-lite-version/)
- [SiteOrigin](https://wordpress.org/plugins/siteorigin-panels/)
- [Elementor](https://wordpress.org/plugins/elementor/)
- [Live Composer](https://wordpress.org/plugins/live-composer-page-builder/)

We are following the development of [Gutenberg](https://wordpress.org/plugins/gutenberg/) closely.

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
- Robust [architecture](https://github.com/grottopress/wordpress-suv/), with a more organised directory structure. Templates (eg: `single.php`, `page.php` etc) are loaded **only** from the `app/templates` directory, and partials (eg: `sidebar.php`, `header.php` etc) from the `app/partials` directory. The days of dumping files in your theme's root are over!
- Use as package in another theme, or as parent theme for a child theme.
- Numerous action and filter hooks to allow easy extension via child themes and plugins.
- Cleanly-commented, object-oriented codebase.
- Modern web development tools.
- Compliant with [PSR-1](http://www.php-fig.org/psr/psr-1/), [PSR-2](http://www.php-fig.org/psr/psr-2/) and [PSR-4](http://www.php-fig.org/psr/psr-4/).

## Requirements

- [PHP](https://secure.php.net) >= 7.0
- [WordPress](https://wordpress.org) >= 4.7
- [Composer](https://getcomposer.org)
- [Node JS](https://nodejs.org)
- [NPM](https://www.npmjs.com)

These are the core requirements you need to get in place. The rest would be installed by the theme itself when the theme is installed.

## Installation

**Disclaimer:** *This software is still in development. Use at your own risk.*

(**Note:** *Jentil starter* theme is not ready yet, so these won't work now)

1. From the `wp-content/themes` directory, run `composer create-project grottopress/jentil-starter your-theme-slug-here`.
1. Change into `your-theme-slug-here` directory: `cd your-theme-slug-here`.
1. By default *[jentil starter](#)* installs as starter theme, with *Jentil* as a package. To use *jentil starter* as a child theme instead, run `composer run child`. Use `composer run starter` to switch back to starter theme mode.
1. If you have [WP CLI](https://wp-cli.org/) set up, run `wp theme activate your-theme-slug-here` to activate your new theme. Otherwise, just head over to the WordPress admin area and activate the theme.

*Jentil starter* provides a scaffold for building your own theme. The source code is elaborately commented. Dive in to find out how to go about building your next awesome theme.

## Architecture

*Jentil* is developed using the [SUV](https://github.com/grottopress/wordpress-suv/) architecture. You might want to [check that out](https://wp-cli.org/), as it may give a better understanding of the core philosophy underpinning *Jentil*'s development.

## Security

Kindly send an email to *admin [at] grottopress [dot] com* about any security-related issue.

## Showcase

The following websites are powered by Jentil:

- [GrottoPress](https://www.grottopress.com)
