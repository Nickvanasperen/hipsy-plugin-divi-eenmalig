<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
if ( class_exists( 'ET_Builder_Module' ) && ! class_exists( 'Hipsy_Divi_Event_Location_Module' ) ) {
class Hipsy_Divi_Event_Location_Module extends ET_Builder_Module {
public $slug='hipsy_event_location'; public $vb_support='on';
public function init(){ $this->name=esc_html__('Hipsy Event Locatie','hipsy-events-builder'); $this->advanced_fields=array('fonts'=>array('location'=>array('label'=>esc_html__('Locatie','hipsy-events-builder'),'css'=>array('main'=>'%%order_class%% .hipsy-single-event-location')))); }
public function render($attrs,$content=null,$render_slug=''){ $location=get_post_meta(get_the_ID(),'hipsy_events_location',true); if(!$location){return '';} return '<div class="hipsy-single-event-location">'.esc_html($location).'</div>'; }
}
new Hipsy_Divi_Event_Location_Module(); }
