<?php
add_shortcode('testimonials', 'wpbp_testimonial_shortcode');
function wpbp_testimonial_shortcode($atts,$content) {
	 extract( shortcode_atts( array(
	      'category' => '',
	      'number' => 10,
	      'theme' => 10,
	      'column' => 1,
	      'image'=>'true'
     ), $atts ) );
	if($department!='' && !empty($department))
	{
	$allteammembers = get_posts( array(
		'numberposts' => 10,
		'orderby' => 'menu_order',
		'order' => 'ASC',
		'post_type' => 'snilesh-testimonials',
		'tax_query' => array(
        array(
            'taxonomy' => 'testimonials-category',
            'terms' => $category,
            'field' => 'term_id',
        )
    ),
	));
	}
	else
	{
	$alltestimonials = get_posts( array(
		'numberposts' => 10,
		'orderby' => 'menu_order',
		'order' => 'ASC',
		'post_type' => 'snilesh-testimonials'));
	}
	
	switch($column)
	{
		case '4':
            $column_class = 'ns-bp-col ns_bp_span_1_of_4';
        break;
        case '3':
            $column_class = 'ns-bp-col ns_bp_span_1_of_3';
        break;
        case '2':
            $column_class = 'ns-bp-col ns_bp_span_1_of_2';
        break;
        default:
            $column_class = 'ns-bp-col ns_bp_span_1_of_1';
        break;
	}
	$content.='<div class="ns-bp-section ns-bp-group nsbp-testimonial-box-section '.$theme.'">';
	$count=0;
	foreach($alltestimonials as $testimonial)
	{
		$count++;
		if($count==1)
		{
			$cls=' first-ns-col';
		}
		else
		{
			$cls='';
		}
		$post_meta=get_post_meta($testimonial->ID,'_testimonial',true);
		$content.='<div class="'.$column_class.' nsbp-testimonial-box'.$cls.'">';
		    if($image=='true' && get_the_post_thumbnail($testimonial->ID,'nsbp-testimonial-thumb-1'))
		    {
			$content.='<div class="nsbp-testimonial-image ns-bp-col ns_bp_span_1_of_4">';
			$content.=get_the_post_thumbnail($testimonial->ID,'nsbp-testimonial-thumb-1');
			$content.='</div>';
			$imgclass="ns_bp_span_3_of_4";
			}
			else
			{
			$imgclass="ns_bp_span_1_of_1";
			}

			$content.='<div class="nsbp-testimonial-text ns-bp-col '.$imgclass.'">';
			$content.='<div class="nsbp-testimonial">'.$testimonial->post_content.'</div>';
			$content.='<div class="nsbp-testimonial-author">'.$testimonial->post_title;
			if($post_meta['client_designation']!='')
			$content.=', <span>'.$post_meta['client_designation'].'</span>';
			if($post_meta['businessname'])
			{
				if($post_meta['link']!='')
				$content.='<a href="'.$post_meta['link'].'" title="">';	
				$content.=' '.$post_meta['businessname'];
				if($post_meta['link']!='')
				$content.='</a>';
			}
			$content.='.</div>';
			$content.='</div>';

		
		

		$content.='</div>';
		if($count==$column)
		{
			//echo '<div class="nsbp-clear-box"></div>';
			$count=0;

		}
	}
	$content.='</div>';
	return $content;
}
?>