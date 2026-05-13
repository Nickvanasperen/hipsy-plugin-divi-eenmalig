<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'HIPSY_EVENTS_BUILDER_VERSION', '0.1.0' );
define( 'HIPSY_EVENTS_BUILDER_PATH', plugin_dir_path( __FILE__ ) );
define( 'HIPSY_EVENTS_BUILDER_URL', plugin_dir_url( __FILE__ ) );

function hipsy_events_builder_load_divi_modules() {
    if ( ! class_exists( 'ET_Builder_Module' ) ) {
        return;
    }

    $events_grid = HIPSY_EVENTS_BUILDER_PATH . 'integrations/divi/modules/events-grid/EventsGrid.php';

    if ( file_exists( $events_grid ) ) {
        require_once $events_grid;
    }
}
add_action( 'et_builder_ready', 'hipsy_events_builder_load_divi_modules' );

function hipsy_events_builder_register_assets() {
    wp_register_style(
        'hipsy-events-grid',
        HIPSY_EVENTS_BUILDER_URL . 'integrations/divi/assets/hipsy-events-grid.css',
        array(),
        HIPSY_EVENTS_BUILDER_VERSION
    );
}
add_action( 'wp_enqueue_scripts', 'hipsy_events_builder_register_assets' );
add_action( 'admin_enqueue_scripts', 'hipsy_events_builder_register_assets' );
