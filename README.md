# Jentil

![Jentil Theme logo](screenshot.png)

Jentil is a modern framework for rapid WordPress theme development. It emphasizes a cleaner, more modular way of building WordPress themes, without straying too far from the core WordPress API.

Jentil is designed with the [SUV](https://github.com/grottopress/wordpress-suv/) architecture, and makes full use of the express power of core WordPress' event driven architecture.

Jentil features a more organised directory structure. Templates are loaded from the `templates/` directory, and partials from the `partials/` directory.

It is packed with predefined, pluggable features, including powerful content options which allows users to configure how posts display on archives right from the customizer.

Jentil may be installed either as a parent theme, or as a package in another theme.

## Features

- Robust [architecture](https://github.com/grottopress/wordpress-suv/), with a more organised directory structure. The days of dumping templates in your theme's root are over!
- Numerous action and filter hooks to allow easy extension via child themes and plugins.
- Clean, object-oriented codebase.
- Modern web development tools.
- Compliant with [PSR-1](http://www.php-fig.org/psr/psr-1/), [PSR-2](http://www.php-fig.org/psr/psr-2/) and [PSR-4](http://www.php-fig.org/psr/psr-4/).
- Powerful posts display options via the customizer.
- Page builder [post type templates](https://make.wordpress.org/core/2016/11/03/post-type-templates-in-4-7/)
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

## Requirements

- [PHP](https://secure.php.net) >= 7.0
- [WordPress](https://wordpress.org) >= 5.3
- [Composer](https://getcomposer.org)
- [Node JS](https://nodejs.org)

These are the core requirements you need to get in place. The rest would be installed by the theme itself during installation.

## Installation

Install *jentil-theme*, which is a starter for building your own theme with Jentil:

1. From the `wp-content/themes/` directory, run `composer create-project --remove-vcs grottopress/jentil-theme your-theme-slug-here`.
1. Switch to `your-theme-slug-here/` directory: `cd your-theme-slug-here/`.
1. Update theme information in `style.css`. You may also want to change package name, description and author in `composer.json` and `package.json`.
1. Copy `bs-config-sample.js` to `bs-config.js`: `cp bs-config-sample.js bs-config.js`. Edit to taste.
1. Replace all occurrences of `'jentil-theme'` text domain with your own theme slug. Your theme slug should match your theme folder name, which should just be the *slugified* version of your theme's name.
1. Do a `git init` to initialize a new git repository for your theme.
1. Run `vendor/bin/wp theme activate your-theme-slug-here` to activate your new theme.
1. Dive into your theme's source, and start developing.

### Install Jentil as parent theme

By default, your new theme is installed with Jentil as package (in the `vendor/` directory). This is recommended.

However, Jentil is a full-fledged WordPress theme by itself, and can, therefore, be installed as such.

If, for any reason, you would like to use Jentil as parent theme instead, follow the steps below:

1. Add `Template: jentil` to your theme's `style.css` headers.
1. Run `composer remove grottopress/jentil` to remove Jentil from your theme's dependencies.
1. Swicth to `wp-content/themes/` directory: `cd ../`
1. Install Jentil as (parent) theme: `composer create-project grottopress/jentil jentil`
1. Switch to your own theme's directory: `cd your-theme-slug-here/`
1. Activate your own theme (not Jentil), if not already active.

### Install via Docker

Your new theme has docker files in the `docker/` directory. The following `Dockerfile`s are available:

- `apache.Dockerfile`: Builds an image of WordPress + PHP + apache, with your theme installed.
- `apache.child.Dockerfile`: Builds an image of WordPress + PHP + apache, with your theme installed **as child theme** of Jentil.
- `fpm-alpine.Dockerfile`: Builds an image of WordPress + PHP-FPM, with your theme installed.
- `fpm-alpine.child.Dockerfile`: Builds an image of WordPress + PHP-FPM, with your theme installed **as child theme** of Jentil.

You may build an image using any of the `Dockerfile`s:

```bash
docker build \
    --build-arg PHP_VERSION=7.4 \
    --build-arg THEME_NAME=your-theme-slug-here \
    --build-arg WORDPRESS_VERSION=6.1 \
    -f docker/fpm-alpine.Dockerfile \
    -t your-image-tag-here .
```

You may run your built image thus:

```bash
docker run -d --name your-container-name-here \
    -v ${PWD}/wordpress:/var/www/html \
    your-image-tag-here
```

## Developing your theme

Whether Jentil is installed as theme or package, it acts as a parent theme, in the WordPress sense. This means your theme inherits all features of Jentil.

You can remove or override Jentil's features, just as you would any WordPress parent theme; via `remove_action` or `remove_filter` calls in your own theme.

You may override templates and partials by placing a similarly-named template or partial in the `templates/` or `partials/` directory of your theme, respectively.

Your own theme's singleton instance is available via a call to `\Theme()` (unless you changed it in `app/helpers.php`), while Jentil's is available via `\Jentil()`. You may use these in files outside `app` directory (eg: in templates and partials) to access the respective instances.

The Jentil singleton instance is exposed as the `$parent` attribute in the main `Theme` class (`app/Theme.php`).

<!-- Jentil ships with abstract classes you can extend in your own theme. Use these instead of extending from Jentil's dependencies directly.

You should use methods from Jentil's utilities, instead of instantiating classes from Jentil's dependencies.

These should insulate you from potential backwards compatibility breaks if any of these packages should upgrade. -->

### Directory Structure

The directory structure for your theme, after installation, should be similar to this:

```
.
├── app/
│   ├── Theme/
│   │   ├── Setups/
│   │   ├── Utilities/
│   │   └── Utilities.php
│   ├── helpers.php
│   └── Theme.php
├── assets/
│   ├── css/
│   └── js/
├── dist/
│   ├── css/
│   └── js/
├── lang/
├── node_modules/
├── partials/
├── templates/
├── tests/
├── vendor/
├── .editorconfig
├── .gitignore
├── CHANGELOG.md
├── codeception.yml
├── composer.json
├── composer.lock
├── functions.php
├── index.php
├── LICENSE
├── package.json
├── package-lock.json
├── postcss.config.js
├── README.md
├── screenshot.png*
├── style.css
├── tailwind.config.js
├── tsconfig.json
└── webpack.mix.js
```

### Adding templates and partials

Templates and partials should be filed in `templates/` and `partials/` respectively. The rules and naming conventions are as defined by WordPress. Therefore, a `templates/singular.php` in your theme overrides the same in Jentil.

If you decide to add your own templates, do not use WordPress' `\get_header()`, `\get_footer()` and `\get_sidebar()` functions in them. These functions expect your partials to be in your theme's root, and WordPress provides no way of overriding those.

Jentil uses it's own loader to load partials from the `partials/` directory. You should call eg: `\Jentil()->utilities->loader->loadPartial('header', 'some-slug')`, instead of `\get_header('some-slug')`.

### Template hooks

You should rarely need to add your own templates, as Jentil comes with template hooks you can use to add or remove stuff from the bundled templates.

The following action hooks are available:

- `jentil_before_header`
- `jentil_inside_header`
- `jentil_after_header`
- `jentil_after_after_header`
- `jentil_before_before_title`
- `jentil_before_title`
- `jentil_after_title`
- `jentil_before_content`
- `jentil_after_content`
- `jentil_after_after_content`
- `jentil_before_before_footer`
- `jentil_before_footer`
- `jentil_inside_footer`
- `jentil_after_footer`

### Post type templates

WordPress introduced [post type templates](https://make.wordpress.org/core/2016/11/03/post-type-templates-in-4-7/) in version 4.7, as an extension of page templates to all post types. WordPress looks for post type templates in the root of your theme.

Jentil's loader does not load any template (or partial) from your theme's root at all. So if you placed post type templates here, though they may be recognised by WordPress and listed in the Page Template dropdown in the post edit screen, they would not be loaded by Jentil.

To use post type templates in your own theme, add the templates in the `templates/` directory, and use the [`theme_{$post_type}_templates`](https://developer.wordpress.org/reference/hooks/theme_post_type_templates/) filter.

Jentil uses this hook to add page builder templates, and provides an `AbstractPostTypeTemplate` setup class your theme's post type templates can inherit from.

### Styling

Jentil's styles are designed to be used, so we do **not** encourage that you dequeue it, unless you intend to recompile and enqueue in your own theme.

Care has been taken to make them as basic as possible, so they do not get in your way. You can simply enqueue your own theme's style sheet(s) after Jentil's.

### Testing

Jentil employs, and encourages, proper, isolated unit tests. *jentil-theme* comes with [WP Browser](https://github.com/lucatume/wp-browser) and [Function Mocker](https://github.com/lucatume/function-mocker) for testing. You may swap these out for whatever testing framework you are comfortable with.

WP Browser uses [Codeception](https://codeception.com), which, in turn uses [PHPUnit](https://phpunit.de), so it should take care of most testing needs. In addition to unit tests, you may add integration, functional and acceptance tests, using the same setup.

Run all tests with `composer run test`, as defined in `composer.json`, under `scripts` configuration.

## Architecture

Jentil is desinged using the [SUV](https://github.com/grottopress/wordpress-suv/) architecture. You might want to [check that out](https://github.com/grottopress/wordpress-suv/), as it may give a better understanding of the core philosophy underpinning Jentil's development.

## Showcase

The following projects are powered by Jentil:

- [GrottoPress](https://www.grottopress.com)
- [Ghana Gong](https://www.ghanagong.com)
- [iQ College](https://www.iqcollegeghana.com)
- [Betta WordPress theme](https://www.grottopress.com/products/betta-wordpress-theme/)

## Development

Run tests with `composer run test`.

## Contributing

1. [Fork it](https://github.com/GrottoPress/jentil/fork)
1. Switch to the `master` branch: `git checkout master`
1. Create your feature branch: `git checkout -b my-new-feature`
1. Make your changes, updating changelog and documentation as appropriate.
1. Commit your changes: `git commit`
1. Push to the branch: `git push origin my-new-feature`
1. Submit a new *Pull Request* against the `GrottoPress:master` branch.
