<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

if ( class_exists( 'ET_Builder_Module' ) && ! class_exists( 'Hipsy_Divi_Event_Title_Module' ) ) {
    class Hipsy_Divi_Event_Title_Module extends ET_Builder_Module {
        public $slug = 'hipsy_event_title';
        public $vb_support = 'on';

        public function init() {
            $this->name = esc_html__( 'Hipsy Event Titel', 'hipsy-events-builder' );
            $this->advanced_fields = array(
                'fonts' => array(
                    'title' => array(
                        'label' => esc_html__( 'Titel', 'hipsy-events-builder' ),
                        'css' => array('main' => '%%order_class%% .hipsy-single-event-title'),
                    ),
                ),
            );
        }

        public function get_fields() {
            return array(
                'fallback_title' => array(
                    'label' => esc_html__( 'Fallback titel', 'hipsy-events-builder' ),
                    'type' => 'text',
                    'default' => '',
                    'toggle_slug' => 'main_content',
                ),
            );
        }

        public function render( $attrs, $content = null, $render_slug = '' ) {
            $title = get_the_title();
            if ( ! $title && ! empty( $this->props['fallback_title'] ) ) {
                $title = $this->props['fallback_title'];
            }
            return '<h1 class="hipsy-single-event-title">' . esc_html( $title ) . '</h1>';
        }
    }
    new Hipsy_Divi_Event_Title_Module();
}
