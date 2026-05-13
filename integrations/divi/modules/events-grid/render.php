<?php
/**
 * Render callback for the Hipsy Events Grid Divi module.
 *
 * @package Hipsy\Divi\Modules\EventsGrid
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! function_exists( 'hipsy_divi_events_grid_render' ) ) {
    /**
     * Render the Hipsy events grid HTML.
     *
     * @param array  $props       Divi module props.
     * @param string $module_slug Unique module slug/class.
     * @return string
     */
    function hipsy_divi_events_grid_render( array $props, $module_slug = '' ) {
        $posts_per_page = isset( $props['posts_per_page'] ) ? absint( $props['posts_per_page'] ) : 6;
        $order          = isset( $props['order'] ) && 'DESC' === $props['order'] ? 'DESC' : 'ASC';
        $only_upcoming  = ! isset( $props['only_upcoming'] ) || 'on' === $props['only_upcoming'];

        $meta_query = array();

        if ( $only_upcoming ) {
            $meta_query[] = array(
                'key'     => 'hipsy_events_date',
                'value'   => current_time( 'Y-m-d\TH:i' ),
                'compare' => '>=',
                'type'    => 'CHAR',
            );
        }

        $query = new WP_Query(
            array(
                'post_type'      => 'events',
                'post_status'    => 'publish',
                'posts_per_page' => $posts_per_page,
                'meta_key'       => 'hipsy_events_date',
                'orderby'        => 'meta_value',
                'order'          => $order,
                'meta_query'     => $meta_query,
            )
        );

        if ( ! $query->have_posts() ) {
            $no_events_text = isset( $props['no_events_text'] ) ? $props['no_events_text'] : esc_html__( 'Er zijn momenteel geen events gevonden.', 'hipsy-events-builder' );

            return sprintf(
                '<div class="hipsy-events-grid hipsy-events-grid--empty"><p>%s</p></div>',
                esc_html( $no_events_text )
            );
        }

        $show_image       = ! isset( $props['show_image'] ) || 'on' === $props['show_image'];
        $show_date        = ! isset( $props['show_date'] ) || 'on' === $props['show_date'];
        $show_time        = ! isset( $props['show_time'] ) || 'on' === $props['show_time'];
        $show_location    = ! isset( $props['show_location'] ) || 'on' === $props['show_location'];
        $show_title       = ! isset( $props['show_title'] ) || 'on' === $props['show_title'];
        $show_description = ! isset( $props['show_description'] ) || 'on' === $props['show_description'];
        $show_tickets     = ! isset( $props['show_tickets'] ) || 'on' === $props['show_tickets'];
        $show_button      = ! isset( $props['show_button'] ) || 'on' === $props['show_button'];

        $button_text       = isset( $props['button_text'] ) ? $props['button_text'] : esc_html__( 'Bekijk event', 'hipsy-events-builder' );
        $description_words = isset( $props['description_words'] ) ? absint( $props['description_words'] ) : 24;

        ob_start();
        ?>
        <div class="hipsy-events-grid <?php echo esc_attr( $module_slug ); ?>">
            <?php
            while ( $query->have_posts() ) :
                $query->the_post();

                $event_id   = get_the_ID();
                $date_raw   = get_post_meta( $event_id, 'hipsy_events_date', true );
                $date_end   = get_post_meta( $event_id, 'hipsy_events_date_end', true );
                $location   = get_post_meta( $event_id, 'hipsy_events_location', true );
                $ticket_url = get_post_meta( $event_id, 'hipsy_events_link', true );
                $tickets    = maybe_unserialize( get_post_meta( $event_id, 'hipsy_ticket_info', true ) );

                $timestamp_start = $date_raw ? strtotime( $date_raw ) : false;
                $timestamp_end   = $date_end ? strtotime( $date_end ) : false;
                ?>
                <article class="hipsy-event-card">
                    <?php if ( $show_image && has_post_thumbnail() ) : ?>
                        <a class="hipsy-event-image" href="<?php echo esc_url( $ticket_url ? $ticket_url : get_permalink() ); ?>">
                            <?php echo get_the_post_thumbnail( $event_id, 'large' ); ?>
                        </a>
                    <?php endif; ?>

                    <div class="hipsy-event-content">
                        <?php if ( $show_date && $timestamp_start ) : ?>
                            <div class="hipsy-event-date">
                                <?php echo esc_html( wp_date( 'l j F Y', $timestamp_start ) ); ?>
                            </div>
                        <?php endif; ?>

                        <?php if ( $show_time && $timestamp_start ) : ?>
                            <div class="hipsy-event-time">
                                <?php
                                echo esc_html( wp_date( 'H:i', $timestamp_start ) );
                                if ( $timestamp_end ) {
                                    echo esc_html( ' - ' . wp_date( 'H:i', $timestamp_end ) );
                                }
                                ?>
                            </div>
                        <?php endif; ?>

                        <?php if ( $show_title ) : ?>
                            <h3 class="hipsy-event-title"><?php echo esc_html( get_the_title() ); ?></h3>
                        <?php endif; ?>

                        <?php if ( $show_location && $location ) : ?>
                            <div class="hipsy-event-location"><?php echo esc_html( $location ); ?></div>
                        <?php endif; ?>

                        <?php if ( $show_description ) : ?>
                            <div class="hipsy-event-description">
                                <?php
                                $excerpt = wp_strip_all_tags( get_the_content() );
                                echo esc_html( $description_words > 0 ? wp_trim_words( $excerpt, $description_words ) : $excerpt );
                                ?>
                            </div>
                        <?php endif; ?>

                        <?php if ( $show_tickets && is_array( $tickets ) && ! empty( $tickets ) ) : ?>
                            <div class="hipsy-event-tickets">
                                <?php
                                $first_ticket = reset( $tickets );
                                if ( is_array( $first_ticket ) && isset( $first_ticket['price'] ) ) {
                                    $price = (float) $first_ticket['price'];
                                    echo esc_html( $price > 0 ? sprintf( 'Vanaf € %s', number_format_i18n( $price, 2 ) ) : __( 'Gratis', 'hipsy-events-builder' ) );
                                }
                                ?>
                            </div>
                        <?php endif; ?>

                        <?php if ( $show_button && $ticket_url ) : ?>
                            <a class="hipsy-event-button" href="<?php echo esc_url( $ticket_url ); ?>" target="_blank" rel="noopener">
                                <?php echo esc_html( $button_text ); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                </article>
            <?php endwhile; ?>
        </div>
        <?php
        wp_reset_postdata();

        return ob_get_clean();
    }
}
