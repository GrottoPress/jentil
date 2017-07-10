<?php

/**
 * API Functions
 *
 * Functions for child themes and plugins to interface with Jentil.
 * Child theme and plugin authors are advised to use ONLY the functions here
 * in their child themes, and never the actual namespaced classes
 * in Jentil. This ensures forward compatibility in the event the
 * internals of Jentil change in the near future.
 *
 * Note that this is for use by child themes and plugins only.
 * Jentil core (except templates/views) will continue to refer
 * to the namespaced classes.
 *
 * @link            https://jentil.grottopress.com
 * @package         jentil
 * @since           Jentil 0.1.0
 */

if ( ! defined( 'WPINC' ) ) {
    die;
}

use GrottoPress\Jentil\Setup;
use GrottoPress\Jentil\Utilities;

/**
 * Setup
 *
 * @since       Jentil 0.1.0
 *
 * @return      \GrottoPress\Jentil\Setup\Jentil        The setup instance
 */
function jentil_setup() {
    return Setup\Jentil::instance();
}

/**
 * Parts
 *
 * @var         string      $part       Which part object to get.
 *
 * @since       Jentil 0.1.0
 *
 * @return      array|object            All Jentil parts (array of objects) or single part (object)
 */
function jentil_parts( $part = '' ) {
    $parts = jentil_setup()->get( 'parts' );

    if ( $part ) {
        return $parts[ sanitize_key( $part ) ];
    }

    return $parts;
}

/**
 * Activator utility
 *
 * @since       Jentil 0.1.0
 *
 * @return      \GrottoPress\Jentil\Utilities\Activator        The activator instance
 */
function jentil_activator() {
    return Utilities\Activator::instance();
}

/**
 * Template
 *
 * @since       Jentil 0.1.0
 *
 * @return      \GrottoPress\Jentil\Utilities\Template\Template         The template instance
 */
function jentil_template() {
    return Utilities\Template\Template::instance();
}

/**
 * Layout
 *
 * @since       Jentil 0.1.0
 *
 * @return      \GrottoPress\Jentil\Utilities\Template\Layout         The template layout instance
 */
function jentil_layout() {
    return jentil_template()->get( 'layout' );
}

/**
 * Posts
 *
 * @since       Jentil 0.1.0
 *
 * @return      \GrottoPress\Jentil\Utilities\Template\Posts         The template posts instance
 */
function jentil_posts() {
    return jentil_template()->get( 'posts' );
}

/**
 * Title
 *
 * @since       Jentil 0.1.0
 *
 * @return      \GrottoPress\Jentil\Utilities\Template\Title         The template title instance
 */
function jentil_title() {
    return jentil_template()->get( 'title' );
}

/**
 * Colophon utility
 *
 * @since       Jentil 0.1.0
 *
 * @return      \GrottoPress\Jentil\Utilities\Colophon         A colophon utility instance
 */
function jentil_colophon() {
    return new Utilities\Colophon();
}

/**
 * Logo utility
 *
 * @since       Jentil 0.1.0
 *
 * @return      \GrottoPress\Jentil\Utilities\Logo         A logo utility instance
 */
function jentil_logo() {
    return new Utilities\Logo();
}

/**
 * Colophon Mod
 *
 * @since       Jentil 0.1.0
 *
 * @return      \GrottoPress\Jentil\Utilities\Mods\Colophon         A colophon mod instance
 */
function jentil_colophon_mod() {
    return new Utilities\Mods\Colophon();
}

/**
 * Layout Mod
 * 
 * @var         string      $context        Template name
 * @var         string      $specific       Post type name or taxonomy name
 * @var         string      $more_specific  Post ID or term ID
 *
 * @since       Jentil 0.1.0
 *
 * @return      \GrottoPress\Jentil\Utilities\Mods\Colophon         A layout mod instance
 */
function jentil_layout_mod( $context = '', $specific = '', $more_specific = '' ) {
    return new Utilities\Mods\Layout( $context, $specific, $more_specific );
}

/**
 * Logo Mod
 *
 * @since       Jentil 0.1.0
 *
 * @return      \GrottoPress\Jentil\Utilities\Mods\Logo         A logo mod instance
 */
function jentil_logo_mod() {
    return new Utilities\Mods\Logo();
}

/**
 * Posts Mod
 * 
 * @var         string      $context        Context
 * @var         string      $setting        Setting
 *
 * @since       Jentil 0.1.0
 *
 * @return      \GrottoPress\Jentil\Utilities\Mods\Posts         A posts mod instance
 */
function jentil_posts_mod( $setting, $args = array() ) {
    return new Utilities\Mods\Posts( $setting, $args );
}

/**
 * Title Mod
 * 
 * @var         string      $context        Template name
 * @var         string      $specific       Post type name or taxonomy name
 * @var         string      $more_specific  Post ID or term ID
 *
 * @since       Jentil 0.1.0
 *
 * @return      \GrottoPress\Jentil\Utilities\Mods\Title         A title mod instance
 */
function jentil_title_mod( $context = '', $specific = '', $more_specific = '' ) {
    return new Utilities\Mods\Title( $context, $specific, $more_specific );
}