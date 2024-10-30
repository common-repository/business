<?php
add_shortcode('faq', 'wpbp_faq_shortcode');

function wpbp_faq_shortcode($atts,$content) {
	 extract( shortcode_atts( array(
	      'cat' => '',
	      'number' => 10,
	      'theme' => 'default',
	      '' => 10,
     ), $atts ) );
	if($cat!='' && !empty($cat))
	{
	$allfaqs = get_posts( array(
		'numberposts' => 10,
		'orderby' => 'menu_order',
		'order' => 'ASC',
		'post_type' => 'snilesh-faq',
		'tax_query' => array(
        array(
            'taxonomy' => 'faq-category',
            'terms' => $cat,
            'field' => 'term_id',
        )
    ),
	));
	}
	else
	{
	$allfaqs = get_posts( array(
		'numberposts' => 10,
		'orderby' => 'menu_order',
		'order' => 'ASC',
		'post_type' => 'snilesh-faq'));
	}
	if($theme=='default')
	{
	$content.='<div class="ns-bp-faqs '.$theme.'">';
	$count=0;
	foreach($allfaqs as $faq)
	{
		$count++;
		$content.='<div class="ns-bp-faq-toggle">';
		$active='';
		if($count==1){$active=' active';}
		$content.='<div class="ns-bp-faq-toggle-title'.$active.'"><i class="nsbp-faq-count">'.$count.'</i>'.$faq->post_title.'<span></span></div>';
		$content.='<div class="ns-bp-faq-toggle-inner">';
		$content.='<p>'.$faq->post_content.'</p>';
		$content.='</div>';
		$content.='</div>';
	}
	$content.='</div>';
	}
	else
	{
		$content.='<div class="ns-bp-faq-flat">';
		foreach($allfaqs as $faq)
		{
			$content.='<h3>'.$faq->post_title.'</h3>';
			$content.='<p>'.$faq->post_content.'</p>';
		}
		$content.='</div>';
	}
	return $content;
}
?>