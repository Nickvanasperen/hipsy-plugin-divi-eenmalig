<?php
/**
 * Fallback admin layer for Hipsy Events Builder.
 *
 * Zorgt ervoor dat Hipsy Events en Hipsy Instellingen zichtbaar zijn in de WordPress backend,
 * ook wanneer de oude functions/admin-bestanden niet aanwezig zijn.
 *
 * @package HIPSY
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'Hipsy_Events_Builder_Admin' ) ) {
    class Hipsy_Events_Builder_Admin {
        const POST_TYPE = 'hipsy_event';
        const OPTION_GROUP = 'hipsy_events_settings';
        const OPTION_API_KEY = 'hipsy_api_key';
        const OPTION_ORGANIZATION = 'hipsy_organization_id';
        const OPTION_V4 = 'hipsy_events_v4_enabled';

        public static function init() {
            add_action( 'init', array( __CLASS__, 'register_post_type' ), 5 );
            add_action( 'admin_menu', array( __CLASS__, 'register_admin_menu' ), 20 );
            add_action( 'admin_init', array( __CLASS__, 'register_settings' ) );
            add_filter( 'manage_' . self::POST_TYPE . '_posts_columns', array( __CLASS__, 'event_columns' ) );
            add_action( 'manage_' . self::POST_TYPE . '_posts_custom_column', array( __CLASS__, 'event_column_content' ), 10, 2 );
        }

        public static function register_post_type() {
            if ( post_type_exists( self::POST_TYPE ) ) {
                return;
            }

            $labels = array(
                'name'                  => __( 'Hipsy Events', 'hipsy-events' ),
                'singular_name'         => __( 'Hipsy Event', 'hipsy-events' ),
                'menu_name'             => __( 'Hipsy Events', 'hipsy-events' ),
                'name_admin_bar'        => __( 'Hipsy Event', 'hipsy-events' ),
                'add_new'               => __( 'Nieuw event', 'hipsy-events' ),
                'add_new_item'          => __( 'Nieuw Hipsy event toevoegen', 'hipsy-events' ),
                'edit_item'             => __( 'Hipsy event bewerken', 'hipsy-events' ),
                'new_item'              => __( 'Nieuw Hipsy event', 'hipsy-events' ),
                'view_item'             => __( 'Hipsy event bekijken', 'hipsy-events' ),
                'search_items'          => __( 'Hipsy events zoeken', 'hipsy-events' ),
                'not_found'             => __( 'Geen Hipsy events gevonden', 'hipsy-events' ),
                'not_found_in_trash'    => __( 'Geen Hipsy events gevonden in prullenbak', 'hipsy-events' ),
                'all_items'             => __( 'Alle events', 'hipsy-events' ),
            );

            register_post_type(
                self::POST_TYPE,
                array(
                    'labels'             => $labels,
                    'public'             => true,
                    'show_ui'            => true,
                    'show_in_menu'       => true,
                    'menu_icon'          => 'dashicons-calendar-alt',
                    'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ),
                    'has_archive'        => true,
                    'rewrite'            => array( 'slug' => 'events' ),
                    'show_in_rest'       => true,
                    'capability_type'    => 'post',
                    'map_meta_cap'       => true,
                )
            );
        }

        public static function register_admin_menu() {
            add_submenu_page(
                'edit.php?post_type=' . self::POST_TYPE,
                __( 'Hipsy Instellingen', 'hipsy-events' ),
                __( 'Instellingen', 'hipsy-events' ),
                'manage_options',
                'hipsy-events-settings',
                array( __CLASS__, 'render_settings_page' )
            );
        }

        public static function register_settings() {
            register_setting( self::OPTION_GROUP, self::OPTION_API_KEY, array( 'sanitize_callback' => 'sanitize_text_field' ) );
            register_setting( self::OPTION_GROUP, self::OPTION_ORGANIZATION, array( 'sanitize_callback' => 'sanitize_text_field' ) );
            register_setting( self::OPTION_GROUP, self::OPTION_V4, array( 'sanitize_callback' => array( __CLASS__, 'sanitize_checkbox' ) ) );
        }

        public static function sanitize_checkbox( $value ) {
            return ! empty( $value ) ? 1 : 0;
        }

        public static function render_settings_page() {
            if ( ! current_user_can( 'manage_options' ) ) {
                return;
            }
            ?>
            <div class="wrap hipsy-admin-settings">
                <h1><?php esc_html_e( 'Hipsy Instellingen', 'hipsy-events' ); ?></h1>
                <p><?php esc_html_e( 'Beheer hier de basisinstellingen voor Hipsy Events Builder.', 'hipsy-events' ); ?></p>

                <form method="post" action="options.php">
                    <?php settings_fields( self::OPTION_GROUP ); ?>

                    <table class="form-table" role="presentation">
                        <tr>
                            <th scope="row">
                                <label for="hipsy_api_key"><?php esc_html_e( 'Hipsy API key', 'hipsy-events' ); ?></label>
                            </th>
                            <td>
                                <input type="text" class="regular-text" id="hipsy_api_key" name="<?php echo esc_attr( self::OPTION_API_KEY ); ?>" value="<?php echo esc_attr( get_option( self::OPTION_API_KEY, '' ) ); ?>" autocomplete="off" />
                                <p class="description"><?php esc_html_e( 'Vul hier de API key in die gebruikt wordt voor de Hipsy koppeling.', 'hipsy-events' ); ?></p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="hipsy_organization_id"><?php esc_html_e( 'Organisatie ID / slug', 'hipsy-events' ); ?></label>
                            </th>
                            <td>
                                <input type="text" class="regular-text" id="hipsy_organization_id" name="<?php echo esc_attr( self::OPTION_ORGANIZATION ); ?>" value="<?php echo esc_attr( get_option( self::OPTION_ORGANIZATION, '' ) ); ?>" />
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><?php esc_html_e( 'v4 features', 'hipsy-events' ); ?></th>
                            <td>
                                <label for="hipsy_events_v4_enabled">
                                    <input type="checkbox" id="hipsy_events_v4_enabled" name="<?php echo esc_attr( self::OPTION_V4 ); ?>" value="1" <?php checked( get_option( self::OPTION_V4, 0 ), 1 ); ?> />
                                    <?php esc_html_e( 'Nieuwe query/filter functionaliteit inschakelen', 'hipsy-events' ); ?>
                                </label>
                            </td>
                        </tr>
                    </table>

                    <?php submit_button(); ?>
                </form>
            </div>
            <?php
        }

        public static function event_columns( $columns ) {
            $new_columns = array();

            foreach ( $columns as $key => $label ) {
                $new_columns[ $key ] = $label;

                if ( 'title' === $key ) {
                    $new_columns['hipsy_event_date'] = __( 'Eventdatum', 'hipsy-events' );
                    $new_columns['hipsy_event_location'] = __( 'Locatie', 'hipsy-events' );
                    $new_columns['hipsy_event_price'] = __( 'Prijs', 'hipsy-events' );
                }
            }

            return $new_columns;
        }

        public static function event_column_content( $column, $post_id ) {
            switch ( $column ) {
                case 'hipsy_event_date':
                    echo esc_html( self::get_first_meta_value( $post_id, array( 'event_date', 'hipsy_event_date', 'start_date', 'date' ) ) );
                    break;
                case 'hipsy_event_location':
                    echo esc_html( self::get_first_meta_value( $post_id, array( 'event_location', 'hipsy_event_location', 'location', 'venue' ) ) );
                    break;
                case 'hipsy_event_price':
                    echo esc_html( self::get_first_meta_value( $post_id, array( 'event_price', 'hipsy_event_price', 'price', 'ticket_price' ) ) );
                    break;
            }
        }

        private static function get_first_meta_value( $post_id, $keys ) {
            foreach ( $keys as $key ) {
                $value = get_post_meta( $post_id, $key, true );

                if ( '' !== $value && null !== $value ) {
                    return $value;
                }
            }

            return '—';
        }
    }
}

Hipsy_Events_Builder_Admin::init();
