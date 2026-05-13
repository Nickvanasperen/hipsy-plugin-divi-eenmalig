<?php
/**
 * Divi Dynamic Content Provider
 * 
 * Registreert Hipsy Event fields in Divi's Dynamic Content dropdown.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Register Hipsy Events in Dynamic Content Custom Fields
 */
add_filter( 'et_builder_get_custom_fields', 'hipsy_register_divi_custom_fields', 10, 1 );

function hipsy_register_divi_custom_fields( $custom_fields ) {
    
    // Alleen op Events post type
    $post_type = get_post_type();
    if ( $post_type !== 'events' && ! defined( 'ET_BUILDER_PRODUCT_VERSION' ) ) {
        return $custom_fields;
    }
    
    // Registreer als custom fields (verschijnt in dropdown)
    $custom_fields['hipsy_events_titel'] = array(
        'label' => 'Event Titel',
        'type'  => 'text',
    );
    
    $custom_fields['hipsy_events_datum'] = array(
        'label' => 'Event Datum',
        'type'  => 'text',
    );
    
    $custom_fields['hipsy_events_tijd'] = array(
        'label' => 'Event Tijd',
        'type'  => 'text',
    );
    
    $custom_fields['hipsy_events_location'] = array(
        'label' => 'Event Locatie',
        'type'  => 'text',
    );
    
    $custom_fields['hipsy_events_beschrijving'] = array(
        'label' => 'Event Beschrijving',
        'type'  => 'text',
    );
    
    $custom_fields['hipsy_events_categorieen'] = array(
        'label' => 'Event Categorieën',
        'type'  => 'text',
    );
    
    $custom_fields['hipsy_events_prijs'] = array(
        'label' => 'Event Prijs',
        'type'  => 'text',
    );
    
    $custom_fields['hipsy_events_link'] = array(
        'label' => 'Event Ticket URL',
        'type'  => 'url',
    );
    
    $custom_fields['hipsy_events_permalink'] = array(
        'label' => 'Event Permalink',
        'type'  => 'url',
    );
    
    $custom_fields['hipsy_events_afbeelding'] = array(
        'label' => 'Event Afbeelding URL',
        'type'  => 'url',
    );
    
    return $custom_fields;
}

/**
 * Populate dynamic content values
 */
add_filter( 'et_builder_resolve_dynamic_content', 'hipsy_resolve_dynamic_content', 10, 4 );

function hipsy_resolve_dynamic_content( $value, $name, $args, $context ) {
    
    // Check of het een Hipsy field is
    if ( strpos( $name, 'hipsy_events_' ) !== 0 ) {
        return $value;
    }
    
    $post_id = isset( $args['post_id'] ) ? $args['post_id'] : get_the_ID();
    
    switch ( $name ) {
        case 'hipsy_events_titel':
            return get_the_title( $post_id );
            
        case 'hipsy_events_datum':
            $date_raw = get_post_meta( $post_id, 'hipsy_events_date', true );
            if ( empty( $date_raw ) ) return '';
            
            $date_obj = DateTime::createFromFormat( 'Y-m-d\TH:i', $date_raw );
            if ( ! $date_obj ) return $date_raw;
            
            $formatted = $date_obj->format( 'd M Y' );
            
            // Nederlandse maanden
            $nl = array(
                'Jan' => 'jan', 'Feb' => 'feb', 'Mar' => 'mrt', 'Apr' => 'apr',
                'May' => 'mei', 'Jun' => 'jun', 'Jul' => 'jul', 'Aug' => 'aug',
                'Sep' => 'sep', 'Oct' => 'okt', 'Nov' => 'nov', 'Dec' => 'dec',
            );
            
            return str_replace( array_keys( $nl ), array_values( $nl ), $formatted );
            
        case 'hipsy_events_tijd':
            $date_start = get_post_meta( $post_id, 'hipsy_events_date', true );
            if ( empty( $date_start ) ) return '';
            
            $start_obj = DateTime::createFromFormat( 'Y-m-d\TH:i', $date_start );
            if ( ! $start_obj ) return '';
            
            $output = $start_obj->format( 'H:i' );
            
            $date_end = get_post_meta( $post_id, 'hipsy_events_date_end', true );
            if ( ! empty( $date_end ) ) {
                $end_obj = DateTime::createFromFormat( 'Y-m-d\TH:i', $date_end );
                if ( $end_obj ) {
                    $output .= ' - ' . $end_obj->format( 'H:i' );
                }
            }
            
            return $output;
            
        case 'hipsy_events_location':
            return get_post_meta( $post_id, 'hipsy_events_location', true );
            
        case 'hipsy_events_beschrijving':
            $description = get_post_field( 'post_content', $post_id );
            $words = explode( ' ', strip_tags( $description ) );
            if ( count( $words ) > 50 ) {
                return implode( ' ', array_slice( $words, 0, 50 ) ) . '...';
            }
            return implode( ' ', $words );
            
        case 'hipsy_events_categorieen':
            $terms = get_the_terms( $post_id, 'event_categorie' );
            if ( ! $terms || is_wp_error( $terms ) ) return '';
            
            $names = array();
            foreach ( $terms as $term ) {
                $names[] = $term->name;
            }
            return implode( ', ', $names );
            
        case 'hipsy_events_prijs':
            $ticket_info = get_post_meta( $post_id, 'hipsy_ticket_info', true );
            if ( empty( $ticket_info ) ) return '';
            
            $tickets = maybe_unserialize( $ticket_info );
            if ( ! is_array( $tickets ) || empty( $tickets ) ) return '';
            
            $lowest = null;
            foreach ( $tickets as $ticket ) {
                $price = isset( $ticket['price'] ) ? floatval( $ticket['price'] ) : 0;
                if ( $lowest === null || $price < $lowest ) {
                    $lowest = $price;
                }
            }
            
            if ( $lowest === 0 ) return 'Gratis';
            return 'Vanaf €' . number_format( $lowest, 2, ',', '.' );
            
        case 'hipsy_events_link':
            return get_post_meta( $post_id, 'hipsy_events_link', true );
            
        case 'hipsy_events_permalink':
            return get_permalink( $post_id );
            
        case 'hipsy_events_afbeelding':
            return get_the_post_thumbnail_url( $post_id, 'large' );
    }
    
    return $value;
}
