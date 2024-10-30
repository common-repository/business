<?php
add_shortcode('team', 'wpbp_team_shortcode');
function wpbp_team_shortcode($atts,$content) {
	 extract( shortcode_atts( array(
	      'department' => '',
	      'number' => 10,
	      'theme' => 10,
	      'column' => 1
     ), $atts ) );
	if($department!='' && !empty($department))
	{
	$allteammembers = get_posts( array(
		'numberposts' => 10,
		'orderby' => 'menu_order',
		'order' => 'ASC',
		'post_type' => 'snilesh-team',
		'posts_per_page' => $number,
		'tax_query' => array(
        array(
            'taxonomy' => 'department',
            'terms' => $department,
            'field' => 'term_id',
        )
    ),
	));
	}
	else
	{
	$allteammembers = get_posts( array(
		'numberposts' => 10,
		'orderby' => 'menu_order',
		'order' => 'ASC',
		'posts_per_page' => $number,
		'post_type' => 'snilesh-team'));
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
	$content.='<div class="ns-bp-section ns-bp-group '.$theme.'">';
	$count=0;
	foreach($allteammembers as $member)
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
		$post_meta=get_post_meta($member->ID,'_team',true);
		$content.='<div class="'.$column_class.' ns-bp-team-box'.$cls.'">';
		$content.='<div class="ns-bp-team-box-inner">';
		$content.='<div class="member-img">';
		$content.=get_the_post_thumbnail($member->ID,'full');
		$content.='</div>';
		$content.='<h4>'.$member->post_title.'</h4>';
		
		$icon_colors=get_option('nsbp_team_icons_color');
		if(empty($icon_colors))
		{
			$icon_colors='black';
		}
				
		if($post_meta['designation']!='')
		$content.='<div class="member-role">'.$post_meta['designation'].'</div>';
		$content.='<p>'.$member->post_content.'</p>';
		$content.='<div class="member-social"><ul>';
		if($post_meta['link'] !='')
		{
			
		$content.='<li class="member-social-website"><a target="_blank" href="'.$post_meta['link'].'" data-original-title="Website">';
		$content.='<img src="'.WP_BUSINESS_PLUGIN_URL.'images/icons/social/'.$icon_colors.'/website.png" alt="Twitter" >';
		$content.='</a></li>';
		}
		if($post_meta['twitter']!='')
		{
		$content.='<li class="member-social-twitter"><a target="_blank" href="'.$post_meta['twitter'].'" data-original-title="Twitter">';
		$content.='<img src="'.WP_BUSINESS_PLUGIN_URL.'images/icons/social/'.$icon_colors.'/twitter.png" alt="Twitter" >';
		$content.='</a></li>';
		}
		if($post_meta['email']!='')
		{
		$content.='<li class="member-social-email"><a href="mailto:'.$post_meta['email'].'" data-original-title="Mail">';
		$content.='<img src="'.WP_BUSINESS_PLUGIN_URL.'images/icons/social/'.$icon_colors.'/email.png" alt="Email" >';
		$content.='</a></li>';
		}
		if($post_meta['facebook']!='')
		{
		$content.='<li class="member-social-facebook"><a target="_blank" href="'.$post_meta['facebook'].'" data-original-title="Facebook">';
		$content.='<img src="'.WP_BUSINESS_PLUGIN_URL.'images/icons/social/'.$icon_colors.'/facebook.png" alt="Facebook" >';
		$content.='</a></li>';
		}
		if($post_meta['skype']!='')
		{
		$content.='<li class="member-social-skype"><a target="_blank" href="'.$post_meta['skype'].'" data-original-title="Skype">';
		$content.='<img src="'.WP_BUSINESS_PLUGIN_URL.'images/icons/social/'.$icon_colors.'/skype.png" alt="Skype" >';
		$content.='</a></li>';
		}
		if($post_meta['googleplus']!='')
		{
		$content.='<li class="member-social-google"><a target="_blank" href="'.$post_meta['googleplus'].'" data-original-title="Google+">';
		$content.='<img src="'.WP_BUSINESS_PLUGIN_URL.'images/icons/social/'.$icon_colors.'/googleplus.png" alt="Google+" >';
		$content.='</a></li>';
		}
		if($post_meta['linkedin']!='')
		{
		$content.='<li class="member-social-linkedin"><a target="_blank" href="'.$post_meta['linkedin'].'" data-original-title="LinkedIn">';
		$content.='<img src="'.WP_BUSINESS_PLUGIN_URL.'images/icons/social/'.$icon_colors.'/linkedin.png" alt="Linkedin" >';
		$content.='</a></li>';		
		}
		if($post_meta['pinterest']!='')
		{
		$content.='<li class="member-social-pinterest"><a target="_blank" href="'.$post_meta['pinterest'].'" data-original-title="Pinterest">';
		$content.='<img src="'.WP_BUSINESS_PLUGIN_URL.'images/icons/social/'.$icon_colors.'/pinterest.png" alt="" >';
		$content.='</a></li>';		
		}
		if($post_meta['flickr']!='')
		{
		$content.='<li class="member-social-flickr"><a target="_blank" href="'.$post_meta['flickr'].'" data-original-title="Flickr">';
		$content.='<img src="'.WP_BUSINESS_PLUGIN_URL.'images/icons/social/'.$icon_colors.'/flickr.png" alt="" >';
		$content.='</a></li>';		
		}
		$content.='</ul></div>';
		$content.='</div></div>';
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