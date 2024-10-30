<?php
/**
 * Plugin Name: Wordpress Business Plugin
 * Plugin URI: http://www.snilesh.com/wordpress-business-plugin/
 * Description: Wordpress Business plugins add business website features like FAQ,Testimonials,Team Members, Skills and Back To Top on any websites.
 * Version: 1.3
 * Author: Nilesh Shiragave
 * Author URI: http://www.snilesh.com
 * Text Domain: nsbp-business-plugin
 * Domain Path: /languages/
 * License: GPL2
 */

/*  Copyright YEAR  Nilesh Shiragave  (email : info@snilesh.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


/*
	DEFINE CONSTANTS
*/

define('WP_BUSINESS_PLUGIN_URL',plugins_url( '' , __FILE__ ).'/' );

$snilesh_business_ver='1.2';

function nsbp_language_action_init()
{
// Localization

load_plugin_textdomain( 'nsbp-business-plugin', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

}

// Add actions
add_action('init', 'nsbp_language_action_init');


include('inc/faq/faq.php');
include('inc/testimonials/testimonials.php');
include('inc/team/team.php');
include('inc/shortcodes.php');
include('inc/admin/admin.php');

if ( function_exists( 'add_image_size' ) ) { 
  
    add_image_size( 'nsbp-testimonial-thumb', 300, 300, true ); //(cropped)
    add_image_size( 'nsbp-testimonial-thumb-1', 300, 300, false ); //(cropped)
}

function wp_business_filter_title_text($title)
{
    $scr = get_current_screen();
    if ('testimonials' == $scr->post_type)
    {
	$title = __( 'Client Name / Company Name / Name', 'nsbp-business-plugin' );
	}
	elseif('team' == $scr->post_type)
	{
	$title = __( 'Team Member Name', 'nsbp-business-plugin' );
	}
	elseif('faq' == $scr->post_type)
	{
	$title = __( 'Enter your Question here', 'nsbp-business-plugin' );
	}
	elseif('portfolio' == $scr->post_type)
	{
	$title = __( 'Enter Portfolio Title', 'nsbp-business-plugin' );
	}
	else
	{
	}

    return ($title);
}
add_filter('enter_title_here', 'wp_business_filter_title_text');
add_filter( 'default_content', 'wp_business_filter_editor_content', 10, 2 );

function wp_business_filter_editor_content( $content, $post ) {

    switch( $post->post_type ) {
        case 'portfolio':
            $content = __( 'Entery your project description here.', 'nsbp-business-plugin' );
        break;
        case 'team':
            $content = __( 'Enter Bio information here.', 'nsbp-business-plugin' );
        break;
        case 'testimonials':
            $content = __( 'Enter your testimonial text here.', 'nsbp-business-plugin' );
        break;
		case 'faq':
            $content = __( 'Enter your Answer here.', 'nsbp-business-plugin' );
        break;
        default:
            $content = '';
        break;
    }

    return $content;
}

function ns_bp_include_scripts()
{
	/* Register our scripts here. */
	wp_register_script('wp-business-plugin', plugins_url('js/wp-business-plugin.js', __FILE__), 'jquery', '1.0');

	/* ------------------------------------------------------------------------ */
	/* Enqueue Scripts */
	/* ------------------------------------------------------------------------ */
	wp_enqueue_script('jquery');
	wp_enqueue_script('wp-business-plugin');

}
add_action('wp_head','ns_bp_include_scripts');

function ns_bp_include_backToTop()
{
	$back_to_top_arrow=get_option('nsbp_back_to_iconcolor');
	$nsbp_back_to_bgcolor=get_option('nsbp_back_to_bgcolor');
	$img_url=plugins_url('images/icons/arrows/'.$back_to_top_arrow.'.png', __FILE__);
    $button_string='<a class="nsbp-go-top" id="ns_bp_totop" href="#nsbp-page-wrapper" title="back to top" style="background: '.$nsbp_back_to_bgcolor.' url('.$img_url.') no-repeat center;"></a></div>';
    echo $button_string;

}
if(get_option('nsbp_show_back_to_top')=='true')
{
add_action('wp_footer','ns_bp_include_backToTop');
}

function nsbp_styles_method() {
	
	$nsbp_icon_color=array('black'=>'#000000','red'=>'#c000000','blue'=>'blue','orange'=>'orange','yellow'=>'yellow','pink'=>'pink','white'=>'white','gray'=>'gray','green'=>'green','violet'=>'violet');

    wp_register_style( 'nsbp-custom-style', plugins_url('css/wp-business-plugin.css', __FILE__) );
    wp_enqueue_style(
        'nsbp-custom-style',
        plugins_url('css/custom-style.css', __FILE__)
    );
        //$color = get_theme_mod( 'my-custom-color' ); //E.g. #FF0000
        $nsbp_show_credit_link=get_option('nsbp_show_credit_link');
        $nsbp_show_back_to_top=get_option('nsbp_show_back_to_top');
        $nsbp_back_to_bgcolor=get_option('nsbp_back_to_bgcolor');
        $nsbp_back_to_iconcolor=get_option('nsbp_back_to_iconcolor');
        $nsbp_faq_question_color= get_option('nsbp_faq_question_color'); 
        $nsbp_faq_answer_color= get_option('nsbp_faq_answer_color'); 
        $nsbp_faq_border_color= get_option('nsbp_faq_border_color'); 
        $nsbp_faq_question_bg= get_option('nsbp_faq_question_bg'); 
        $nsbp_faq_answer_bg= get_option('nsbp_faq_answer_bg'); 
        $nsbp_faq_icon_color= get_option('nsbp_faq_icon_color'); 
        $nsbp_team_name_color= get_option('nsbp_team_name_color'); 
        $nsbp_team_designation_color=get_option('nsbp_team_designation_color'); 
        $nsbp_team_icons_color= get_option('nsbp_team_icons_color'); 
        $nsbp_team_text_color= get_option('nsbp_team_text_color'); 
        $nsbp_team_border_color= get_option('nsbp_team_border_color'); 
        $nsbp_team_bg_color= get_option('nsbp_team_bg_color'); 
		$nsbp_testimonial_text_color=get_option('nsbp_testimonial_text_color');
		$nsbp_testimonial_border_color=get_option('nsbp_testimonial_border_color');
		$nsbp_testimonial_bg_color=get_option('nsbp_testimonial_bg_color');
		$nsbp_testimonial_name_color=get_option('nsbp_testimonial_name_color');
		$nsbp_testimonial_designation_color=get_option('nsbp_testimonial_designation_color');
		$nsbp_testimonial_website_color=get_option('nsbp_testimonial_website_color');




        $custom_css='';
		/* TEAM SHORTCODE */
		if($nsbp_team_bg_color!='' || $nsbp_team_border_color!='')
        {
            $custom_css.='.ns-bp-team-box{';
            if($nsbp_team_bg_color!='') { $custom_css.='background: '.$nsbp_team_bg_color.';'; }
            if($nsbp_team_border_color!=''){ $custom_css.='border-color: '.$nsbp_team_border_color.';'; }
            $custom_css.='}';
            if($nsbp_team_border_color!=''){ 
            $custom_css.='.ns-bp-team-box .member-social{';
            $custom_css.='border-color: '.$nsbp_team_border_color.';';
            $custom_css.='}';
            }
        }
        if($nsbp_team_name_color!='')
        {
            $custom_css.='.ns-bp-team-box h4{';
            $custom_css.='color:'.$nsbp_team_name_color.';';
            $custom_css.='}';

        }
         if($nsbp_team_designation_color!='')
        {
            $custom_css.='.ns-bp-team-box .member-role {';
            $custom_css.='color:'.$nsbp_team_designation_color.';';
            $custom_css.='}';

        }
        if($nsbp_team_text_color!=''){
            $custom_css.='.ns-bp-team-box p{';
            $custom_css.='color:'.$nsbp_team_text_color.';';
            $custom_css.='}';
        }
        if($nsbp_back_to_bgcolor!='')
        {
            $custom_css.='#ns_bp_totop{';
            $custom_css.='background:'.$nsbp_back_to_bgcolor.';';
            $custom_css.='}';
        }
		if($nsbp_faq_question_color!='')
        {
			$custom_css.='.ns-bp-faq-toggle .ns-bp-faq-toggle-title,.ns-bp-faq-toggle-title span,.ns-bp-faq-flat h3 {color:'.$nsbp_faq_question_color.';}';
		}
		if($nsbp_faq_question_bg!='')
        {
			$custom_css.='.ns-bp-faq-toggle .ns-bp-faq-toggle-title,.ns-bp-faq-toggle-title span {background-color:'.$nsbp_faq_question_bg.';}';
		}
		if($nsbp_faq_border_color!='')
        {
			$custom_css.='.ns-bp-faq-toggle .ns-bp-faq-toggle-title,.ns-bp-faq-toggle-inner{border-color:'.$nsbp_faq_border_color.';}';
		}
		if($nsbp_faq_answer_color!='')
        {
			$custom_css.='.ns-bp-faq-toggle-inner,.ns-bp-faq-flat p {color:'.$nsbp_faq_answer_color.';}';
		}
		if($nsbp_faq_answer_bg!='')
        {
			$custom_css.='.ns-bp-faq-toggle-inner {background:'.$nsbp_faq_answer_bg.' !important;}';
		}

		/* Testimonials */
		if($nsbp_testimonial_text_color!='')
        {
			$custom_css.='.nsbp-testimonial {color:'.$nsbp_testimonial_text_color.';}';
		}	
		if($nsbp_testimonial_name_color!='')
        {
			$custom_css.='.nsbp-testimonial-author {color:'.$nsbp_testimonial_name_color.';}';
		}
		if($nsbp_testimonial_designation_color!='')
        {
			$custom_css.='.nsbp-testimonial-author span{color:'.$nsbp_testimonial_designation_color.';}';
		}
		if($nsbp_testimonial_website_color!='')
        {
			$custom_css.='.nsbp-testimonial-author a{color:'.$nsbp_testimonial_website_color.';}';
		}
	                
        wp_add_inline_style( 'nsbp-custom-style', $custom_css );
}
add_action( 'wp_enqueue_scripts', 'nsbp_styles_method' );

/*
    Add Credit Link
*/
    function nsbp_add_website_credit_link()
    {
        $credit_option=get_option('nsbp_show_credit_link');   
        if($credit_option!='false')
        {
           // echo '<p style="text-align:center;"><a href="http://www.snilesh.com/wordpress-business-plugin">Wordpress Business Plugin</a></p>';
        }
    }
    
    add_action('wp_footer','nsbp_add_website_credit_link');


function snilesh_business_update_database_values() {
    global $snilesh_business_ver,$wpdb;
    if(!get_option('nsbp_updated_versionposttype12'))
    {
        echo $snilesh_business_ver;
        $wpdb->update( 
            $wpdb->posts, 
            array( 
                'post_type' => 'snilesh-team',  // string
                
            ), 
            array( 'post_type' => 'team' )
        );
        $wpdb->update( 
            $wpdb->posts, 
            array( 
                'post_type' => 'snilesh-testimonials',  // string
                
            ), 
            array( 'post_type' => 'testimonials' )
        );
        $wpdb->update( 
            $wpdb->posts, 
            array( 
                'post_type' => 'snilesh-faq',  // string
                
            ), 
            array( 'post_type' => 'faq' )
        );
        
        add_option( 'nsbp_updated_versionposttype12', '1010', '', 'yes' );
    }
   
}
add_action( 'plugins_loaded', 'snilesh_business_update_database_values' );    
?>