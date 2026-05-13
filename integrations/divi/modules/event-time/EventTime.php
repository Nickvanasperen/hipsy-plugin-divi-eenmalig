<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
if ( class_exists( 'ET_Builder_Module' ) && ! class_exists( 'Hipsy_Divi_Event_Time_Module' ) ) {
class Hipsy_Divi_Event_Time_Module extends ET_Builder_Module {
public $slug='hipsy_event_time'; public $vb_support='on';
public function init(){ $this->name=esc_html__('Hipsy Event Tijd','hipsy-events-builder'); $this->advanced_fields=array('fonts'=>array('time'=>array('label'=>esc_html__('Tijd','hipsy-events-builder'),'css'=>array('main'=>'%%order_class%% .hipsy-single-event-time')))); }
public function render($attrs,$content=null,$render_slug=''){ $date=get_post_meta(get_the_ID(),'hipsy_events_date',true); if(!$date){return '';} return '<div class="hipsy-single-event-time">'.esc_html(wp_date('H:i',strtotime($date))).'</div>'; }
}
new Hipsy_Divi_Event_Time_Module(); }
