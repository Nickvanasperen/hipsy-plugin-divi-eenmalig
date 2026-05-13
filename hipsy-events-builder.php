<?php
/**
 * Plugin Name: Hipsy Events Builder for Divi
 * Plugin URI: https://github.com/Nickvanasperen/hipsy-plugin-divi-eenmalig
 * Description: Minimale Divi pluginbasis voor Hipsy events. Stap 1: plugin zichtbaar maken en één testmodule laden.
 * Version: 0.1.0
 * Author: Young Soul Business
 * Text Domain: hipsy-events-builder
 * Domain Path: /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'HIPSY_EVENTS_BUILDER_VERSION', '0.1.0' );
define( 'HIPSY_EVENTS_BUILDER_PATH', plugin_dir_path( __FILE__ ) );
define( 'HIPSY_EVENTS_BUILDER_URL', plugin_dir_url( __FILE__ ) );

function hipsy_events_builder_register_assets() {
    wp_register_style(
        'hipsy-events-builder-divi',
        HIPSY_EVENTS_BUILDER_URL . 'integrations/divi/assets/hipsy-events-builder-divi.css',
        array(),
        HIPSY_EVENTS_BUILDER_VERSION
    );
}
add_action( 'wp_enqueue_scripts', 'hipsy_events_builder_register_assets' );
add_action( 'admin_enqueue_scripts', 'hipsy_events_builder_register_assets' );

function hipsy_events_builder_load_divi_modules() {
    if ( ! class_exists( 'ET_Builder_Module' ) ) {
        return;
    }

    $module_file = HIPSY_EVENTS_BUILDER_PATH . 'integrations/divi/modules/events-grid/EventsGrid.php';

    if ( file_exists( $module_file ) ) {
        require_once $module_file;
    }
}
add_action( 'et_builder_ready', 'hipsy_events_builder_load_divi_modules' );

function hipsy_events_builder_admin_menu() {
    add_options_page(
        'Hipsy Events Builder',
        'Hipsy Events Builder',
        'manage_options',
        'hipsy-events-builder',
        'hipsy_events_builder_admin_page'
    );
}
add_action( 'admin_menu', 'hipsy_events_builder_admin_menu' );

function hipsy_events_builder_admin_page() {
    echo '<div class="wrap"><h1>Hipsy Events Builder for Divi</h1>';
    echo '<p>Plugin is geladen.</p>';
    echo '<p>Divi Builder status: <strong>' . ( class_exists( 'ET_Builder_Module' ) ? 'gevonden' : 'niet gevonden op deze admin pagina' ) . '</strong></p>';
    echo '<p>Actieve testmodule: <strong>Hipsy Event Grid</strong></p>';
    echo '</div>';
}
