<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
if ( class_exists( 'ET_Builder_Module' ) && ! class_exists( 'Hipsy_Divi_Event_Date_Module' ) ) {
class Hipsy_Divi_Event_Date_Module extends ET_Builder_Module {
public $slug='hipsy_event_date'; public $vb_support='on';
public function init(){ $this->name=esc_html__('Hipsy Event Datum','hipsy-events-builder'); $this->advanced_fields=array('fonts'=>array('date'=>array('label'=>esc_html__('Datum','hipsy-events-builder'),'css'=>array('main'=>'%%order_class%% .hipsy-single-event-date')))); }
public function render($attrs,$content=null,$render_slug=''){ $date=get_post_meta(get_the_ID(),'hipsy_events_date',true); if(!$date){return '';} return '<div class="hipsy-single-event-date">'.esc_html(wp_date('l j F Y',strtotime($date))).'</div>'; }
}
new Hipsy_Divi_Event_Date_Module(); }
