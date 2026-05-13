<?php
/**
 * Divi Integration Loader
 * 
 * Laadt native Divi modules voor Hipsy Events.
 * Werkt alleen als Divi theme actief is.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Check of Divi actief is en laad modules
 */
function hipsy_load_divi_modules() {
    // Check of Divi beschikbaar is
    if ( ! class_exists( 'ET_Builder_Module' ) ) {
        return;
    }

    // Laad custom modules
    $modules_dir = plugin_dir_path( __FILE__ ) . 'modules/';
    
    $modules = array(
        'EventsGrid.php',        // Grid layout (meerdere events)
        'EventTitel.php',        // Titel (single event)
        'EventDatum.php',        // Datum (single event)
        'EventTijd.php',         // Tijd (single event)
        'EventLocatie.php',      // Locatie (single event)
        'EventBeschrijving.php', // Beschrijving (single event)
        'EventAfbeelding.php',   // Afbeelding (single event)
        'EventTicketknop.php',   // Ticket button (single event)
        'EventTickets.php',      // Ticket info (single event)
    );
    
    foreach ( $modules as $module ) {
        $file = $modules_dir . $module;
        if ( file_exists( $file ) ) {
            require_once $file;
        }
    }
    
    // Laad Dynamic Content provider
    $dynamic_file = plugin_dir_path( __FILE__ ) . 'divi-dynamic-content.php';
    if ( file_exists( $dynamic_file ) ) {
        require_once $dynamic_file;
    }
}

// Laad modules op het juiste moment
add_action( 'et_builder_ready', 'hipsy_load_divi_modules' );

/**
 * Enqueue CSS voor Divi modules
 */
function hipsy_divi_enqueue_styles() {
    if ( ! class_exists( 'ET_Builder_Module' ) ) {
        return;
    }
    
    $css_file = plugin_dir_url( __FILE__ ) . 'assets/divi-modules.css';
    $css_version = filemtime( plugin_dir_path( __FILE__ ) . 'assets/divi-modules.css' );
    
    wp_enqueue_style( 'hipsy-divi-modules', $css_file, array(), $css_version );
}
add_action( 'wp_enqueue_scripts', 'hipsy_divi_enqueue_styles' );
add_action( 'admin_enqueue_scripts', 'hipsy_divi_enqueue_styles' ); // Ook in admin voor visual builder
