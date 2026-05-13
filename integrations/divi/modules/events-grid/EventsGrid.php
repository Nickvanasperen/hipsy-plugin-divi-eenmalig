<?php
/**
 * Divi module: Hipsy Events Grid.
 *
 * @package Hipsy\Divi\Modules\EventsGrid
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

require_once __DIR__ . '/fields.php';
require_once __DIR__ . '/render.php';
require_once __DIR__ . '/style.php';

if ( class_exists( 'ET_Builder_Module' ) && ! class_exists( 'Hipsy_Divi_Events_Grid_Module' ) ) {
    class Hipsy_Divi_Events_Grid_Module extends ET_Builder_Module {
        public $slug       = 'hipsy_events_grid';
        public $vb_support = 'on';

        protected $module_credits = array(
            'module_uri' => '',
            'author'     => 'Hipsy',
            'author_uri' => '',
        );

        public function init() {
            $this->name = esc_html__( 'Hipsy Event Grid', 'hipsy-events-builder' );
            $this->settings_modal_toggles = array();
            $this->advanced_fields = array(
                'fonts' => array(
                    'title' => array(
                        'label' => esc_html__( 'Titel', 'hipsy-events-builder' ),
                        'css'   => array(
                            'main' => '%%order_class%% .hipsy-event-title',
                        ),
                    ),
                    'body' => array(
                        'label' => esc_html__( 'Beschrijving', 'hipsy-events-builder' ),
                        'css'   => array(
                            'main' => '%%order_class%% .hipsy-event-description',
                        ),
                    ),
                ),
                'button' => array(
                    'button' => array(
                        'label' => esc_html__( 'Ticket knop', 'hipsy-events-builder' ),
                        'css'   => array(
                            'main' => '%%order_class%% .hipsy-event-button',
                        ),
                    ),
                ),
                'background' => array(
                    'css' => array(
                        'main' => '%%order_class%% .hipsy-event-card',
                    ),
                ),
                'borders' => array(
                    'default' => array(
                        'css' => array(
                            'main' => array(
                                'border_radii' => '%%order_class%% .hipsy-event-card',
                                'border_styles' => '%%order_class%% .hipsy-event-card',
                            ),
                        ),
                    ),
                ),
            );
        }

        public function get_fields() {
            $definitions = require __DIR__ . '/fields.php';
            $fields      = array();

            foreach ( $definitions['content'] as $section ) {
                foreach ( $section['fields'] as $key => $field ) {
                    if ( is_string( $field ) ) {
                        $fields[ $key ] = array(
                            'label'       => $field,
                            'type'        => 'yes_no_button',
                            'default'     => 'on',
                            'options'     => array(
                                'on'  => esc_html__( 'Ja', 'hipsy-events-builder' ),
                                'off' => esc_html__( 'Nee', 'hipsy-events-builder' ),
                            ),
                            'toggle_slug' => 'visibility',
                        );
                    } else {
                        $fields[ $key ] = $field;
                    }
                }
            }

            foreach ( $definitions['design'] as $section ) {
                if ( empty( $section['fields'] ) ) {
                    continue;
                }
                foreach ( $section['fields'] as $key => $field ) {
                    $fields[ $key ] = $field;
                }
            }

            return $fields;
        }

        public function render( $attrs, $content = null, $render_slug = '' ) {
            return hipsy_divi_events_grid_render( $this->props, $render_slug );
        }
    }

    new Hipsy_Divi_Events_Grid_Module();
}
