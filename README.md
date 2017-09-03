# Jentil WordPress Theme

## Description

Jentil is a modern WordPress theme, suitable for use as a parent theme from which child themes can be derived.

It features powerful content options which allows to configure posts display on archives right from the customizer.

Jentil features six layout options, configured via the customizer and post meta boxes.

Jentil can be used to build blogs, magazines, e-commerce, corporate websites and more.

It integrates seamlessly with most WordPress page builders including:

- [Beaver Builder](https://wordpress.org/plugins/beaver-builder-lite-version/)
- [SiteOrigin](https://wordpress.org/plugins/siteorigin-panels/)
- [Elementor](https://wordpress.org/plugins/elementor/)
- [Live Composer](https://wordpress.org/plugins/live-composer-page-builder/)

## Features

### For the End User:
- Powerful posts/content display options via the customizer.
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
- Numerous action and filter hooks to allow easy extension via child themes and plugins.
- Cleanly-commented, object-oriented codebase.
- Modern web development tools (npm, composer, gulp, sass).
- Enforced a more organised directory structure in parent and child themes. Templates (eg: single.php, page.php etc) are loaded only from the `app/templates` directory, and partials (eg: sidebar.php, header.php etc) from the `app/partials` directory.
- Coded with the [WordPress Coding Standards](https://codex.wordpress.org/WordPress_Coding_Standards) in mind.

## Requirements

This theme requires **WordPress** version **4.5** or newer. Minimum required **PHP** version is **7.0**.

For now, you also need to install [MagPack plugin](https://github.com/grottopress/magpack) to get this working. We'll remove this dependency in the course of development.

## Installation

**Disclaimer:** *This software is still in development. Use at your own risk.*

### End Users

We are working on a website where end users can simply press a download button to download a production-ready version of Jentil. Website link will be posted here soon.

- After downloading Jentil (in *zip* format), go to **Themes** submenu of the **Appearance** menu in the WordPress admin area.
- Click the **Add New** button on the *Themes* screen. You should be taken to the *Add Themes* screen.
- On the *Add Themes* screen, click the **Upload Theme** button. Choose the file from your local computer and click **Install Now**.
- Do not activate Jentil. Only activate the child theme that comes with it.

Read our tutorial on [how to install WordPress themes](https://www.grottopress.com/tutorials/wordpress-themes-installation/) to learn more.

### Developers

You should have [composer](https://getcomposer.org/) and [npm](https://www.npmjs.com/) installed.

- From the root of your WordPress project, via the command line, enter `composer require grottopress/jentil`. (Use `--no-dev` flag for production).
- Change to `jentil` directory  
 `cd jentil`
- Run `npm install`
- Run `gulp` to build assets in a new `dist` directory.
- You may run `npm install --production` at this stage for a production-ready build.
- Download, install and activate [MagPack plugin](https://github.com/grottopress/magpack).
- You're done.

## Example Child Theme

Link(s) to be posted soon...

## Showcase

The following websites are powered by Jentil:

- [GrottoPress](https://www.grottopress.com)
