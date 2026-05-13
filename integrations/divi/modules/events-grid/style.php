<?php
/**
 * Dynamic style helpers for Hipsy Events Grid.
 *
 * @package Hipsy\Divi\Modules\EventsGrid
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! function_exists( 'hipsy_divi_events_grid_style_vars' ) ) {
    function hipsy_divi_events_grid_style_vars( array $props ) {
        $columns = isset( $props['columns'] ) ? max( 1, absint( $props['columns'] ) ) : 3;
        $gap     = isset( $props['card_gap'] ) ? $props['card_gap'] : '24px';

        return sprintf(
            '--hipsy-grid-columns:%1$d;--hipsy-grid-gap:%2$s;',
            $columns,
            esc_attr( $gap )
        );
    }
}
