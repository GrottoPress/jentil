# GrottoPress SCSS

Sass utilities: Mixins, variables and functions.

## Installation

1. Run `npm install @grottopress/scss`
1. Import into your project.
1. Use the provided variables, functions and mixins in your project's styles.

## Documentation

### Importing

Import into your project, thus:

```scss
@import '/path/to/node_modules/@grottopress/scss/src/all';
```

### Variables

```scss
#comments {
    // ...
    font-family: $arial;
    // ...
}

#header {
    // ...
    font-family: $helvetica;
    // ...
}
```

### Mixins

```scss
.modal {
    @include size(400px);
    @include position(absolute, 20% null null 20%);
    // ...
}

.grid {
    @include paragraph;
    @include grid((width: 25%, gutter: 20px));
    // ...
}
```
