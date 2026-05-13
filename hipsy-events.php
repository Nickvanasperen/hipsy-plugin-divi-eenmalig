<?php

/**
 * Hipsy-Plugin-Divi-Eenmalig
 *
 * @package       HIPSY
 * @author        Young Soul Business & How About Yes
 *
 * @wordpress-plugin
 * Plugin Name:   Hipsy-Plugin-Divi-Eenmalig
 * Plugin URI:    https://hipsy.nl
 * Description:   Divi plugin voor Hipsy Events. Eenmalige versie voor het stylen en tonen van Hipsy event grids in Divi.
 * Version:       1.0.1
 * Author:        Young Soul Business & How About Yes
 * Author URI:    https://youngsoulbusiness.com
 * Text Domain:   hipsy-plugin-divi-eenmalig
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! defined( 'HIPSY_PLUGIN_DIVI_EENMALIG_VERSION' ) ) {
    define( 'HIPSY_PLUGIN_DIVI_EENMALIG_VERSION', '1.0.1' );
}

if ( ! defined( 'HIPSY_EVENTS_BUILDER_VERSION' ) ) {
    define( 'HIPSY_EVENTS_BUILDER_VERSION', HIPSY_PLUGIN_DIVI_EENMALIG_VERSION );
}

// ══════════════════════════════════════════════════════
// CORE INCLUDES - Basis functionaliteit (altijd actief)
// ══════════════════════════════════════════════════════

if ( file_exists( plugin_dir_path(__FILE__) . 'includes/admin/admin.php' ) ) {
    include_once plugin_dir_path(__FILE__) . 'includes/admin/admin.php';
}

// Helpers
if ( file_exists( plugin_dir_path(__FILE__) . 'includes/helpers.php' ) ) {
    include_once plugin_dir_path(__FILE__) . "includes/helpers.php";
}

// Event card renderer (gebruikt door Elementor, Divi en shortcodes)
if ( file_exists( plugin_dir_path(__FILE__) . 'render/event-card.php' ) ) {
    include_once plugin_dir_path(__FILE__) . "render/event-card.php";
}

// Individual field shortcodes (ALTIJD laden - voor custom templates)
if ( file_exists( plugin_dir_path(__FILE__) . 'integrations/shortcodes/field-shortcodes.php' ) ) {
    include_once plugin_dir_path(__FILE__) . 'integrations/shortcodes/field-shortcodes.php';
}

// Legacy includes (backwards compatibility) - BASIS PLUGIN
if ( file_exists( __DIR__ . "/templates/loopItem.php" ) ) include(__DIR__ . "/templates/loopItem.php");
if ( file_exists( __DIR__ . "/functions/styles.php" ) ) include(__DIR__ . "/functions/styles.php");
if ( file_exists( __DIR__ . "/functions/displayEventsShortcode.php" ) ) include(__DIR__ . "/functions/displayEventsShortcode.php");

if ( ! get_option('hipsy_events_v4_enabled', 0) ) {
    if ( file_exists( __DIR__ . "/functions/builderShortcodes.php" ) ) include(__DIR__ . "/functions/builderShortcodes.php");
}

if ( file_exists( __DIR__ . "/functions/deleteOldEvents.php" ) ) include(__DIR__ . "/functions/deleteOldEvents.php");
if ( file_exists( __DIR__ . "/functions/createEvent.php" ) ) include(__DIR__ . "/functions/createEvent.php" );
if ( file_exists( __DIR__ . "/functions/getHipsyEvents.php" ) ) include(__DIR__ . "/functions/getHipsyEvents.php");
if ( file_exists( __DIR__ . "/functions/displaySettings.php" ) ) include(__DIR__ . "/functions/displaySettings.php");
if ( file_exists( __DIR__ . "/functions/initSettings.php" ) ) include(__DIR__ . "/functions/initSettings.php");
if ( file_exists( __DIR__ . "/functions/submitSettings.php" ) ) include(__DIR__ . "/functions/submitSettings.php");
if ( file_exists( __DIR__ . "/functions/customPostType.php" ) ) include(__DIR__ . "/functions/customPostType.php");
if ( file_exists( __DIR__ . "/functions/submenuItem.php" ) ) include(__DIR__ . "/functions/submenuItem.php");
if ( file_exists( __DIR__ . "/functions/customFields.php" ) ) include(__DIR__ . "/functions/customFields.php");
if ( file_exists( __DIR__ . "/functions/singleEventRenderer.php" ) ) include(__DIR__ . "/functions/singleEventRenderer.php");
if ( file_exists( __DIR__ . "/functions/customTemplates.php" ) ) include(__DIR__ . "/functions/customTemplates.php");
if ( file_exists( __DIR__ . "/functions/adminColumns.php" ) ) include(__DIR__ . "/functions/adminColumns.php");
if ( file_exists( __DIR__ . "/functions/restApiSorting.php" ) ) include(__DIR__ . "/functions/restApiSorting.php");
if ( file_exists( __DIR__ . "/functions/blockGutenberg.php" ) ) include(__DIR__ . "/functions/blockGutenberg.php");
if ( file_exists( __DIR__ . "/functions/cronJob.php" ) ) include(__DIR__ . "/functions/cronJob.php");
if ( file_exists( __DIR__ . "/functions/ajaxLoadMore.php" ) ) include(__DIR__ . "/functions/ajaxLoadMore.php");

if ( file_exists( plugin_dir_path(__FILE__) . 'functions/elementorWidgets.php' ) ) {
    include_once plugin_dir_path(__FILE__) . 'functions/elementorWidgets.php';
}

if ( file_exists( plugin_dir_path(__FILE__) . 'integrations/elementor/elementor-dynamic-tags.php' ) ) {
    include_once plugin_dir_path(__FILE__) . 'integrations/elementor/elementor-dynamic-tags.php';
}

if ( file_exists( plugin_dir_path(__FILE__) . 'integrations/divi/divi-loader.php' ) ) {
    include_once plugin_dir_path(__FILE__) . 'integrations/divi/divi-loader.php';
}

$v4_enabled = get_option('hipsy_events_v4_enabled', 0);

if ( $v4_enabled ) {
    if ( file_exists( plugin_dir_path(__FILE__) . 'core/query-system.php' ) ) {
        include_once plugin_dir_path(__FILE__) . "core/query-system.php";
    }
    
    if ( file_exists( plugin_dir_path(__FILE__) . 'core/ajax-filter.php' ) ) {
        include_once plugin_dir_path(__FILE__) . "core/ajax-filter.php";
    }
    
    if ( file_exists( plugin_dir_path(__FILE__) . 'render/event-card.php' ) ) {
        include_once plugin_dir_path(__FILE__) . "render/event-card.php";
    }
    
    if ( file_exists( plugin_dir_path(__FILE__) . 'integrations/shortcodes/extended-shortcodes.php' ) ) {
        include_once plugin_dir_path(__FILE__) . 'integrations/shortcodes/extended-shortcodes.php';
    }
    
    if ( file_exists( plugin_dir_path(__FILE__) . 'integrations/elementor/filter-bar-widget.php' ) ) {
        add_action( 'elementor/widgets/register', 'hipsy_register_v4_widgets' );
    }
    
    function hipsy_register_v4_widgets( $widgets_manager ) {
        $widget_file = plugin_dir_path(__FILE__) . 'integrations/elementor/filter-bar-widget.php';
        
        if ( ! file_exists( $widget_file ) ) {
            return;
        }
        
        require_once $widget_file;
        
        if ( class_exists( 'Hipsy_Filter_Bar_Widget' ) ) {
            $widgets_manager->register( new Hipsy_Filter_Bar_Widget() );
        }
    }
}
