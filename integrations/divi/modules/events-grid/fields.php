<?php
/**
 * Field definitions for the Hipsy Events Grid Divi module.
 *
 * This file only returns configuration arrays. The module class consumes these
 * definitions so the controls stay readable and easy to extend.
 *
 * @package Hipsy\Divi\Modules\EventsGrid
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

return array(
    'content' => array(
        'data' => array(
            'title'  => esc_html__( 'Data', 'hipsy-events-builder' ),
            'fields' => array(
                'posts_per_page' => array(
                    'label'           => esc_html__( 'Aantal events', 'hipsy-events-builder' ),
                    'type'            => 'range',
                    'default'         => '6',
                    'range_settings'  => array(
                        'min'  => 1,
                        'max'  => 24,
                        'step' => 1,
                    ),
                    'toggle_slug'     => 'data',
                    'mobile_options'  => false,
                ),
                'order' => array(
                    'label'       => esc_html__( 'Volgorde', 'hipsy-events-builder' ),
                    'type'        => 'select',
                    'default'     => 'ASC',
                    'options'     => array(
                        'ASC'  => esc_html__( 'Oudste eerst', 'hipsy-events-builder' ),
                        'DESC' => esc_html__( 'Nieuwste eerst', 'hipsy-events-builder' ),
                    ),
                    'toggle_slug' => 'data',
                ),
                'only_upcoming' => array(
                    'label'       => esc_html__( 'Alleen toekomstige events', 'hipsy-events-builder' ),
                    'type'        => 'yes_no_button',
                    'default'     => 'on',
                    'options'     => array(
                        'on'  => esc_html__( 'Ja', 'hipsy-events-builder' ),
                        'off' => esc_html__( 'Nee', 'hipsy-events-builder' ),
                    ),
                    'toggle_slug' => 'data',
                ),
            ),
        ),
        'visibility' => array(
            'title'  => esc_html__( 'Onderdelen tonen/verbergen', 'hipsy-events-builder' ),
            'fields' => array(
                'show_image'       => esc_html__( 'Afbeelding tonen', 'hipsy-events-builder' ),
                'show_date'        => esc_html__( 'Datum tonen', 'hipsy-events-builder' ),
                'show_time'        => esc_html__( 'Tijd tonen', 'hipsy-events-builder' ),
                'show_location'    => esc_html__( 'Locatie tonen', 'hipsy-events-builder' ),
                'show_title'       => esc_html__( 'Titel tonen', 'hipsy-events-builder' ),
                'show_description' => esc_html__( 'Beschrijving tonen', 'hipsy-events-builder' ),
                'show_tickets'     => esc_html__( 'Tickets/prijs tonen', 'hipsy-events-builder' ),
                'show_button'      => esc_html__( 'Ticketknop tonen', 'hipsy-events-builder' ),
            ),
        ),
        'texts' => array(
            'title'  => esc_html__( 'Teksten', 'hipsy-events-builder' ),
            'fields' => array(
                'button_text' => array(
                    'label'       => esc_html__( 'Knoptekst', 'hipsy-events-builder' ),
                    'type'        => 'text',
                    'default'     => esc_html__( 'Bekijk event', 'hipsy-events-builder' ),
                    'toggle_slug' => 'texts',
                ),
                'no_events_text' => array(
                    'label'       => esc_html__( 'Tekst bij geen events', 'hipsy-events-builder' ),
                    'type'        => 'text',
                    'default'     => esc_html__( 'Er zijn momenteel geen events gevonden.', 'hipsy-events-builder' ),
                    'toggle_slug' => 'texts',
                ),
                'description_words' => array(
                    'label'           => esc_html__( 'Max. woorden beschrijving', 'hipsy-events-builder' ),
                    'type'            => 'range',
                    'default'         => '24',
                    'range_settings'  => array(
                        'min'  => 0,
                        'max'  => 120,
                        'step' => 1,
                    ),
                    'toggle_slug'     => 'texts',
                ),
            ),
        ),
    ),
    'design' => array(
        'layout' => array(
            'title'  => esc_html__( 'Grid layout', 'hipsy-events-builder' ),
            'fields' => array(
                'columns' => array(
                    'label'           => esc_html__( 'Kolommen desktop', 'hipsy-events-builder' ),
                    'type'            => 'range',
                    'default'         => '3',
                    'range_settings'  => array(
                        'min'  => 1,
                        'max'  => 4,
                        'step' => 1,
                    ),
                    'tab_slug'        => 'advanced',
                    'toggle_slug'     => 'layout',
                ),
                'card_gap' => array(
                    'label'          => esc_html__( 'Ruimte tussen kaarten', 'hipsy-events-builder' ),
                    'type'           => 'range',
                    'default'        => '24px',
                    'range_settings' => array(
                        'min'  => 0,
                        'max'  => 80,
                        'step' => 1,
                    ),
                    'tab_slug'       => 'advanced',
                    'toggle_slug'    => 'layout',
                ),
            ),
        ),
        'card' => array(
            'title' => esc_html__( 'Kaart', 'hipsy-events-builder' ),
        ),
        'image' => array(
            'title' => esc_html__( 'Afbeelding', 'hipsy-events-builder' ),
        ),
    ),
);
