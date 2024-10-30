<?php

add_shortcode('skill','nsbp_skills_shortcode');

function nsbp_skills_shortcode( $atts, $content = null ) {
	extract(shortcode_atts(array(
       	'percentage' => '0',
       	'title'      => '',
       	'titlebg' =>'#d35400',
       	'barbg'=>'#e67e22'
    ), $atts));

	$out='<div class="nsbp-skillbar clearfix " data-percent="'.$percentage.'"><div class="nsbp-skillbar-title" style="background:'.$titlebg.';"><span>'.$title.'</span></div><div class="nsbp-skillbar-bar" style="background:'.$barbg.';"></div><div class="nsbp-skill-bar-percent">'.$percentage.'</div></div>';
    return $out;
}
?>