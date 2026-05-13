<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! function_exists( 'hipsy_divi_events_grid_preview_card' ) ) {
    function hipsy_divi_events_grid_preview_card() {
        return '<div class="hipsy-events-grid hipsy-events-grid--preview">'
            . '<article class="hipsy-event-card hipsy-event-card--preview"><div class="hipsy-event-image hipsy-event-image--placeholder"></div><div class="hipsy-event-content"><div class="hipsy-event-date">Vrijdag 24 april 2026</div><div class="hipsy-event-time">19:30 - 22:00</div><h3 class="hipsy-event-title">Voorbeeld event titel</h3><div class="hipsy-event-location">Amsterdam, Nederland</div><div class="hipsy-event-description">Dit is een voorbeeldweergave zodat je in de Divi Visual Builder direct ziet hoe de agenda kaart eruit komt te zien.</div><div class="hipsy-event-tickets">Vanaf € 25,00</div><a class="hipsy-event-button" href="#">Bekijk event</a></div></article>'
            . '<article class="hipsy-event-card hipsy-event-card--preview"><div class="hipsy-event-image hipsy-event-image--placeholder"></div><div class="hipsy-event-content"><div class="hipsy-event-date">Zaterdag 25 april 2026</div><div class="hipsy-event-time">10:00 - 16:00</div><h3 class="hipsy-event-title">Tweede voorbeeld event</h3><div class="hipsy-event-location">Utrecht, Nederland</div><div class="hipsy-event-description">Zodra er echte Hipsy events beschikbaar zijn, worden deze voorbeeldkaarten automatisch vervangen.</div><div class="hipsy-event-tickets">Gratis</div><a class="hipsy-event-button" href="#">Bekijk event</a></div></article>'
            . '</div>';
    }
}

if ( ! function_exists( 'hipsy_divi_events_grid_render' ) ) {
    function hipsy_divi_events_grid_render( array $props, $module_slug = '' ) {
        wp_enqueue_style( 'hipsy-events-grid' );

        if ( ! post_type_exists( 'events' ) ) {
            return hipsy_divi_events_grid_preview_card();
        }

        $posts_per_page = isset( $props['posts_per_page'] ) ? absint( $props['posts_per_page'] ) : 6;
        $order          = isset( $props['order'] ) && 'DESC' === $props['order'] ? 'DESC' : 'ASC';
        $only_upcoming  = ! isset( $props['only_upcoming'] ) || 'on' === $props['only_upcoming'];
        $meta_query     = array();

        if ( $only_upcoming ) {
            $meta_query[] = array(
                'key'     => 'hipsy_events_date',
                'value'   => current_time( 'Y-m-d\TH:i' ),
                'compare' => '>=',
                'type'    => 'CHAR',
            );
        }

        $query = new WP_Query( array(
            'post_type'      => 'events',
            'post_status'    => 'publish',
            'posts_per_page' => $posts_per_page,
            'meta_key'       => 'hipsy_events_date',
            'orderby'        => 'meta_value',
            'order'          => $order,
            'meta_query'     => $meta_query,
        ) );

        if ( ! $query->have_posts() ) {
            return hipsy_divi_events_grid_preview_card();
        }

        $show_image       = ! isset( $props['show_image'] ) || 'on' === $props['show_image'];
        $show_date        = ! isset( $props['show_date'] ) || 'on' === $props['show_date'];
        $show_time        = ! isset( $props['show_time'] ) || 'on' === $props['show_time'];
        $show_location    = ! isset( $props['show_location'] ) || 'on' === $props['show_location'];
        $show_title       = ! isset( $props['show_title'] ) || 'on' === $props['show_title'];
        $show_description = ! isset( $props['show_description'] ) || 'on' === $props['show_description'];
        $show_tickets     = ! isset( $props['show_tickets'] ) || 'on' === $props['show_tickets'];
        $show_button      = ! isset( $props['show_button'] ) || 'on' === $props['show_button'];
        $button_text      = isset( $props['button_text'] ) ? $props['button_text'] : esc_html__( 'Bekijk event', 'hipsy-events-builder' );
        $description_words = isset( $props['description_words'] ) ? absint( $props['description_words'] ) : 24;

        ob_start();
        echo '<div class="hipsy-events-grid ' . esc_attr( $module_slug ) . '">';
        while ( $query->have_posts() ) {
            $query->the_post();
            $event_id   = get_the_ID();
            $date_raw   = get_post_meta( $event_id, 'hipsy_events_date', true );
            $date_end   = get_post_meta( $event_id, 'hipsy_events_date_end', true );
            $location   = get_post_meta( $event_id, 'hipsy_events_location', true );
            $ticket_url = get_post_meta( $event_id, 'hipsy_events_link', true );
            $tickets    = maybe_unserialize( get_post_meta( $event_id, 'hipsy_ticket_info', true ) );
            $timestamp_start = $date_raw ? strtotime( $date_raw ) : false;
            $timestamp_end   = $date_end ? strtotime( $date_end ) : false;

            echo '<article class="hipsy-event-card">';
            if ( $show_image ) {
                echo '<a class="hipsy-event-image" href="' . esc_url( $ticket_url ? $ticket_url : get_permalink() ) . '">';
                echo has_post_thumbnail() ? get_the_post_thumbnail( $event_id, 'large' ) : '<span class="hipsy-event-image--placeholder"></span>';
                echo '</a>';
            }
            echo '<div class="hipsy-event-content">';
            if ( $show_date && $timestamp_start ) echo '<div class="hipsy-event-date">' . esc_html( wp_date( 'l j F Y', $timestamp_start ) ) . '</div>';
            if ( $show_time && $timestamp_start ) echo '<div class="hipsy-event-time">' . esc_html( wp_date( 'H:i', $timestamp_start ) . ( $timestamp_end ? ' - ' . wp_date( 'H:i', $timestamp_end ) : '' ) ) . '</div>';
            if ( $show_title ) echo '<h3 class="hipsy-event-title">' . esc_html( get_the_title() ) . '</h3>';
            if ( $show_location && $location ) echo '<div class="hipsy-event-location">' . esc_html( $location ) . '</div>';
            if ( $show_description ) echo '<div class="hipsy-event-description">' . esc_html( wp_trim_words( wp_strip_all_tags( get_the_content() ), $description_words ) ) . '</div>';
            if ( $show_tickets && is_array( $tickets ) && ! empty( $tickets ) ) {
                $first_ticket = reset( $tickets );
                if ( is_array( $first_ticket ) && isset( $first_ticket['price'] ) ) {
                    $price = (float) $first_ticket['price'];
                    echo '<div class="hipsy-event-tickets">' . esc_html( $price > 0 ? sprintf( 'Vanaf € %s', number_format_i18n( $price, 2 ) ) : __( 'Gratis', 'hipsy-events-builder' ) ) . '</div>';
                }
            }
            if ( $show_button && $ticket_url ) echo '<a class="hipsy-event-button" href="' . esc_url( $ticket_url ) . '" target="_blank" rel="noopener">' . esc_html( $button_text ) . '</a>';
            echo '</div></article>';
        }
        echo '</div>';
        wp_reset_postdata();
        return ob_get_clean();
    }
}
