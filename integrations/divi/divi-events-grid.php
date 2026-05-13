<?php
/**
 * Divi Module: Hipsy Events Grid
 * 
 * Native Divi Visual Builder module voor event weergave.
 * Volledige visuele configuratie zoals Divi's eigen modules.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

class Hipsy_Divi_Events_Grid extends ET_Builder_Module {

    public $slug       = 'hipsy_events_grid';
    public $vb_support = 'on';

    protected $module_credits = array(
        'module_uri' => 'https://youngsoulbusiness.com',
        'author'     => 'Young Soul Business',
        'author_uri' => 'https://youngsoulbusiness.com',
    );

    public function init() {
        $this->name = esc_html__( 'Hipsy Events Grid', 'hipsy-events' );
        $this->icon_path = plugin_dir_path( __FILE__ ) . '../../img/hipsy_small.png';
        
        // Advanced fields support
        $this->settings_modal_toggles = array(
            'general'  => array(
                'toggles' => array(
                    'main_content' => esc_html__( 'Layout', 'hipsy-events' ),
                    'query'        => esc_html__( 'Query & Filtering', 'hipsy-events' ),
                    'elements'     => esc_html__( 'Elements', 'hipsy-events' ),
                ),
            ),
            'advanced' => array(
                'toggles' => array(
                    'card'   => esc_html__( 'Card Styling', 'hipsy-events' ),
                    'text'   => array(
                        'title'    => esc_html__( 'Text', 'hipsy-events' ),
                        'priority' => 49,
                    ),
                ),
            ),
        );
    }

    public function get_fields() {
        return array(
            
            // ═══════════════════════════════════════
            // LAYOUT
            // ═══════════════════════════════════════
            'layout' => array(
                'label'           => esc_html__( 'Layout Type', 'hipsy-events' ),
                'type'            => 'select',
                'option_category' => 'layout',
                'options'         => array(
                    'grid'   => esc_html__( 'Grid', 'hipsy-events' ),
                    'list'   => esc_html__( 'List', 'hipsy-events' ),
                    'carousel' => esc_html__( 'Carousel', 'hipsy-events' ),
                ),
                'default'         => 'grid',
                'toggle_slug'     => 'main_content',
                'description'     => esc_html__( 'Choose how to display events.', 'hipsy-events' ),
            ),
            
            'columns' => array(
                'label'           => esc_html__( 'Columns', 'hipsy-events' ),
                'type'            => 'range',
                'option_category' => 'layout',
                'toggle_slug'     => 'main_content',
                'default'         => '3',
                'range_settings'  => array(
                    'min'  => '1',
                    'max'  => '4',
                    'step' => '1',
                ),
                'mobile_options'  => true,
                'show_if'         => array(
                    'layout' => array( 'grid', 'carousel' ),
                ),
            ),
            
            // ═══════════════════════════════════════
            // QUERY & FILTERING
            // ═══════════════════════════════════════
            'query_id' => array(
                'label'           => esc_html__( 'Query ID (v4.0)', 'hipsy-events' ),
                'type'            => 'text',
                'option_category' => 'configuration',
                'toggle_slug'     => 'query',
                'description'     => esc_html__( 'Unique ID to connect with filter (e.g. "agenda"). Leave empty if not using filters.', 'hipsy-events' ),
            ),
            
            'aantal' => array(
                'label'           => esc_html__( 'Number of Events', 'hipsy-events' ),
                'type'            => 'range',
                'option_category' => 'configuration',
                'toggle_slug'     => 'query',
                'default'         => '6',
                'range_settings'  => array(
                    'min'  => '1',
                    'max'  => '50',
                    'step' => '1',
                ),
            ),
            
            'alleen_toekomst' => array(
                'label'           => esc_html__( 'Show Upcoming Events Only', 'hipsy-events' ),
                'type'            => 'yes_no_button',
                'option_category' => 'configuration',
                'options'         => array(
                    'on'  => esc_html__( 'Yes', 'hipsy-events' ),
                    'off' => esc_html__( 'No', 'hipsy-events' ),
                ),
                'default'         => 'on',
                'toggle_slug'     => 'query',
            ),
            
            'filter_categorie' => array(
                'label'           => esc_html__( 'Filter by Category', 'hipsy-events' ),
                'type'            => 'select',
                'option_category' => 'configuration',
                'options'         => $this->get_event_categories(),
                'default'         => '',
                'toggle_slug'     => 'query',
            ),
            
            // ═══════════════════════════════════════
            // ELEMENTS
            // ═══════════════════════════════════════
            'show_image' => array(
                'label'           => esc_html__( 'Show Image', 'hipsy-events' ),
                'type'            => 'yes_no_button',
                'option_category' => 'configuration',
                'options'         => array(
                    'on'  => esc_html__( 'Yes', 'hipsy-events' ),
                    'off' => esc_html__( 'No', 'hipsy-events' ),
                ),
                'default'         => 'on',
                'toggle_slug'     => 'elements',
            ),
            
            'show_date' => array(
                'label'           => esc_html__( 'Show Date', 'hipsy-events' ),
                'type'            => 'yes_no_button',
                'option_category' => 'configuration',
                'options'         => array(
                    'on'  => esc_html__( 'Yes', 'hipsy-events' ),
                    'off' => esc_html__( 'No', 'hipsy-events' ),
                ),
                'default'         => 'on',
                'toggle_slug'     => 'elements',
            ),
            
            'show_time' => array(
                'label'           => esc_html__( 'Show Time', 'hipsy-events' ),
                'type'            => 'yes_no_button',
                'option_category' => 'configuration',
                'options'         => array(
                    'on'  => esc_html__( 'Yes', 'hipsy-events' ),
                    'off' => esc_html__( 'No', 'hipsy-events' ),
                ),
                'default'         => 'on',
                'toggle_slug'     => 'elements',
            ),
            
            'show_title' => array(
                'label'           => esc_html__( 'Show Title', 'hipsy-events' ),
                'type'            => 'yes_no_button',
                'option_category' => 'configuration',
                'options'         => array(
                    'on'  => esc_html__( 'Yes', 'hipsy-events' ),
                    'off' => esc_html__( 'No', 'hipsy-events' ),
                ),
                'default'         => 'on',
                'toggle_slug'     => 'elements',
            ),
            
            'show_location' => array(
                'label'           => esc_html__( 'Show Location', 'hipsy-events' ),
                'type'            => 'yes_no_button',
                'option_category' => 'configuration',
                'options'         => array(
                    'on'  => esc_html__( 'Yes', 'hipsy-events' ),
                    'off' => esc_html__( 'No', 'hipsy-events' ),
                ),
                'default'         => 'on',
                'toggle_slug'     => 'elements',
            ),
            
            'show_description' => array(
                'label'           => esc_html__( 'Show Description', 'hipsy-events' ),
                'type'            => 'yes_no_button',
                'option_category' => 'configuration',
                'options'         => array(
                    'on'  => esc_html__( 'Yes', 'hipsy-events' ),
                    'off' => esc_html__( 'No', 'hipsy-events' ),
                ),
                'default'         => 'on',
                'toggle_slug'     => 'elements',
            ),
            
            'show_price' => array(
                'label'           => esc_html__( 'Show Price', 'hipsy-events' ),
                'type'            => 'yes_no_button',
                'option_category' => 'configuration',
                'options'         => array(
                    'on'  => esc_html__( 'Yes', 'hipsy-events' ),
                    'off' => esc_html__( 'No', 'hipsy-events' ),
                ),
                'default'         => 'on',
                'toggle_slug'     => 'elements',
            ),
            
            'show_button' => array(
                'label'           => esc_html__( 'Show Button', 'hipsy-events' ),
                'type'            => 'yes_no_button',
                'option_category' => 'configuration',
                'options'         => array(
                    'on'  => esc_html__( 'Yes', 'hipsy-events' ),
                    'off' => esc_html__( 'No', 'hipsy-events' ),
                ),
                'default'         => 'on',
                'toggle_slug'     => 'elements',
            ),
            
            'max_words' => array(
                'label'           => esc_html__( 'Description Max Words', 'hipsy-events' ),
                'type'            => 'range',
                'option_category' => 'configuration',
                'toggle_slug'     => 'elements',
                'default'         => '20',
                'range_settings'  => array(
                    'min'  => '5',
                    'max'  => '100',
                    'step' => '5',
                ),
            ),
            
            'button_text' => array(
                'label'           => esc_html__( 'Button Text', 'hipsy-events' ),
                'type'            => 'text',
                'option_category' => 'configuration',
                'toggle_slug'     => 'elements',
                'default'         => 'Bestel tickets',
            ),
            
            // ═══════════════════════════════════════
            // ADVANCED - Card Styling
            // ═══════════════════════════════════════
            'card_bg_color' => array(
                'label'          => esc_html__( 'Card Background Color', 'hipsy-events' ),
                'type'           => 'color-alpha',
                'custom_color'   => true,
                'toggle_slug'    => 'card',
                'default'        => '#ffffff',
                'tab_slug'       => 'advanced',
            ),
            
            'card_border_radius' => array(
                'label'          => esc_html__( 'Card Border Radius', 'hipsy-events' ),
                'type'           => 'range',
                'toggle_slug'    => 'card',
                'default'        => '12px',
                'range_settings' => array(
                    'min'  => '0',
                    'max'  => '50',
                    'step' => '1',
                ),
                'tab_slug'       => 'advanced',
            ),
            
            'card_padding' => array(
                'label'          => esc_html__( 'Card Padding', 'hipsy-events' ),
                'type'           => 'range',
                'toggle_slug'    => 'card',
                'default'        => '18px',
                'range_settings' => array(
                    'min'  => '0',
                    'max'  => '50',
                    'step' => '1',
                ),
                'tab_slug'       => 'advanced',
            ),
        );
    }

    /**
     * Get event categories for dropdown
     */
    private function get_event_categories() {
        $categories = array( '' => esc_html__( 'All Categories', 'hipsy-events' ) );
        
        $terms = get_terms( array(
            'taxonomy'   => 'event_categorie',
            'hide_empty' => false,
        ) );
        
        if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
            foreach ( $terms as $term ) {
                $categories[ $term->term_id ] = $term->name;
            }
        }
        
        return $categories;
    }

    /**
     * Render module output
     */
    public function render( $attrs, $content, $render_slug ) {
        
        // Get settings
        $layout            = $this->props['layout'];
        $columns           = $this->props['columns'];
        $columns_tablet    = isset( $this->props['columns_tablet'] ) ? $this->props['columns_tablet'] : '2';
        $columns_phone     = isset( $this->props['columns_phone'] ) ? $this->props['columns_phone'] : '1';
        $query_id          = $this->props['query_id'];
        $aantal            = intval( $this->props['aantal'] );
        $alleen_toekomst   = $this->props['alleen_toekomst'];
        $filter_categorie  = $this->props['filter_categorie'];
        
        // Card styling
        $card_bg           = $this->props['card_bg_color'];
        $card_radius       = $this->props['card_border_radius'];
        $card_padding      = $this->props['card_padding'];
        
        // Build query args
        $args = array(
            'post_type'      => 'events',
            'posts_per_page' => $aantal,
            'post_status'    => 'publish',
            'meta_key'       => 'hipsy_events_date',
            'orderby'        => 'meta_value',
            'order'          => 'ASC',
        );
        
        if ( $alleen_toekomst === 'on' ) {
            $args['meta_query'] = array(
                array(
                    'key'     => 'hipsy_events_date',
                    'value'   => current_time( 'Y-m-d\TH:i' ),
                    'compare' => '>=',
                    'type'    => 'DATETIME',
                ),
            );
        }
        
        if ( ! empty( $filter_categorie ) ) {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'event_categorie',
                    'field'    => 'term_id',
                    'terms'    => intval( $filter_categorie ),
                ),
            );
        }
        
        // Register query for v4.0 filters
        if ( $query_id && function_exists( 'hipsy_register_query' ) ) {
            hipsy_register_query( $query_id, $args );
        }
        
        // Execute query
        $query = new WP_Query( $args );
        
        // Wrapper attributes
        $wrapper_id = $query_id ? 'heg-' . sanitize_key( $query_id ) : '';
        $wrapper_attrs = '';
        if ( $wrapper_id ) {
            $wrapper_attrs = sprintf(
                ' id="%s" data-query-id="%s" data-layout="%s"',
                esc_attr( $wrapper_id ),
                esc_attr( $query_id ),
                esc_attr( $layout )
            );
        }
        
        // Generate custom CSS
        $this->generate_styles( $render_slug, $card_bg, $card_radius, $card_padding );
        
        // Start output
        ob_start();
        
        echo '<div class="hipsy-divi-events-grid"' . $wrapper_attrs . '>';
        
        if ( $query->have_posts() ) {
            
            // Grid container
            $grid_class = 'hew-grid hew-divi-grid';
            if ( $layout === 'list' ) {
                $grid_class = 'hew-lijst';
            }
            
            echo '<div class="' . esc_attr( $grid_class ) . '" style="--cols-d:' . esc_attr( $columns ) . ';--cols-t:' . esc_attr( $columns_tablet ) . ';--cols-m:' . esc_attr( $columns_phone ) . ';">';
            
            while ( $query->have_posts() ) {
                $query->the_post();
                
                // Use event card renderer if available
                if ( function_exists( 'hipsy_render_event_card' ) ) {
                    hipsy_render_event_card( get_the_ID(), array(
                        'layout'             => $layout,
                        'show_image'         => $this->props['show_image'] === 'on',
                        'show_date'          => $this->props['show_date'] === 'on',
                        'show_time'          => $this->props['show_time'] === 'on',
                        'show_title'         => $this->props['show_title'] === 'on',
                        'show_location'      => $this->props['show_location'] === 'on',
                        'show_description'   => $this->props['show_description'] === 'on',
                        'show_price'         => $this->props['show_price'] === 'on',
                        'show_button'        => $this->props['show_button'] === 'on',
                        'max_words'          => intval( $this->props['max_words'] ),
                        'button_text'        => $this->props['button_text'],
                    ) );
                } else {
                    // Fallback rendering
                    $this->render_event_card_fallback( get_the_ID() );
                }
            }
            
            echo '</div>';
            
            wp_reset_postdata();
            
        } else {
            echo '<p>' . esc_html__( 'Geen events gevonden.', 'hipsy-events' ) . '</p>';
        }
        
        echo '</div>';
        
        return ob_get_clean();
    }

    /**
     * Generate custom CSS
     */
    private function generate_styles( $render_slug, $bg, $radius, $padding ) {
        ET_Builder_Element::set_style( $render_slug, array(
            'selector'    => '%%order_class%% .hew-card',
            'declaration' => sprintf(
                'background-color: %s; border-radius: %s;',
                esc_html( $bg ),
                esc_html( $radius )
            ),
        ) );
        
        ET_Builder_Element::set_style( $render_slug, array(
            'selector'    => '%%order_class%% .hew-card-body',
            'declaration' => sprintf( 'padding: %s;', esc_html( $padding ) ),
        ) );
        
        // Grid responsive columns
        ET_Builder_Element::set_style( $render_slug, array(
            'selector'    => '%%order_class%% .hew-divi-grid',
            'declaration' => 'display: grid; grid-template-columns: repeat(var(--cols-d, 3), 1fr); gap: 24px;',
        ) );
        
        ET_Builder_Element::set_style( $render_slug, array(
            'selector'    => '%%order_class%% .hew-divi-grid',
            'declaration' => 'grid-template-columns: repeat(var(--cols-t, 2), 1fr);',
            'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
        ) );
        
        ET_Builder_Element::set_style( $render_slug, array(
            'selector'    => '%%order_class%% .hew-divi-grid',
            'declaration' => 'grid-template-columns: repeat(var(--cols-m, 1), 1fr);',
            'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
        ) );
    }

    /**
     * Fallback render if event-card.php not loaded
     */
    private function render_event_card_fallback( $event_id ) {
        $titel = get_the_title( $event_id );
        $link  = get_permalink( $event_id );
        
        echo '<div class="hew-card">';
        echo '<div class="hew-card-body">';
        echo '<h3 class="hew-titel"><a href="' . esc_url( $link ) . '">' . esc_html( $titel ) . '</a></h3>';
        echo '</div>';
        echo '</div>';
    }
}

new Hipsy_Divi_Events_Grid();
