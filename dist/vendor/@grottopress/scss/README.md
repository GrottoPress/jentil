# GrottoPress SCSS

Sass utilities: Mixins, variables and functions.

## Installation

1. Run `npm install @grottopress/scss`
1. Import into your project.
1. Use the provided variables, functions and mixins in your project's styles.

## Documentation

### Importing

Import into your project, thus:

    @import 'node_modules/@grottopress/scss/src/variables';
    @import 'node_modules/@grottopress/scss/src/functions';
    @import 'node_modules/@grottopress/scss/src/mixins';

### Variables

    #comments {
        ...
        font-family: $arial;
        ...
    }

    #header {
        ...
        font-family: $helvetica;
        ...
    }

### Mixins

    .modal {
        @include size(400px);
        @include border-radius(5px);
        @include position(absolute, 20% null null 20%);
        ...
    }

    .grid {
        @include paragraph;
        @include grid((
            width: 25%,
            use: 'float',
        ));
        ...
    }
