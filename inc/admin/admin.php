<?php
/**
 * Plugin Name: Wordpress Plugin Settings
 * Plugin URI: http://www.snilesh.com
 * Description: Wordpress Business plugins add business website features like FAQ,Testimonials,Portfolio,Team on any websites.
 * Version: 1.0
 * Author: Nilesh Shiragave
 * Author URI: http://www.snilesh.com
 * License: GPL2
 */


$nsbp_options=array();

//define('WP_BUSINESS_PLUGIN_URL',plugins_url( '' , __FILE__ ).'/' );

$nsbp_icon_color=array('black','red','blue','orange','yellow','pink','white','gray','green','violet');

/*

    Add wordpress menu page

*/

function nsbp_create_admin_menu_page()
{
    //create new top-level menu
    add_menu_page('Business Settings', 'Business Settings', 'administrator', __FILE__, 'nsbp_settings_page',WP_BUSINESS_PLUGIN_URL.'/images/business-icon.png','30');

    //call register settings function
    add_action( 'admin_init', 'nsbp_settings_default' );
    
}

add_action('admin_menu', 'nsbp_create_admin_menu_page');


function nsbp_settings_default()
{
    //register our settings
    register_setting( 'nsbp-settings-group', 'nsbp_show_credit_link' );
    register_setting( 'nsbp-settings-group', 'nsbp_show_back_to_top' );
    register_setting( 'nsbp-settings-group', 'nsbp_back_to_bgcolor' );
    register_setting( 'nsbp-settings-group', 'nsbp_back_to_iconcolor' );

    register_setting( 'nsbp-settings-group', 'nsbp_faq_question_color' );
    register_setting( 'nsbp-settings-group', 'nsbp_faq_answer_color' );
    register_setting( 'nsbp-settings-group', 'nsbp_faq_border_color' );
    register_setting( 'nsbp-settings-group', 'nsbp_faq_question_bg' );
    register_setting( 'nsbp-settings-group', 'nsbp_faq_answer_bg' );
    register_setting( 'nsbp-settings-group', 'nsbp_faq_icon_color' );

    register_setting( 'nsbp-settings-group', 'nsbp_team_name_color' );
    register_setting( 'nsbp-settings-group', 'nsbp_team_designation_color' );
    register_setting( 'nsbp-settings-group', 'nsbp_team_icons_color' );
    register_setting( 'nsbp-settings-group', 'nsbp_team_text_color' );
    register_setting( 'nsbp-settings-group', 'nsbp_team_border_color' );
    register_setting( 'nsbp-settings-group', 'nsbp_team_bg_color' );

	register_setting( 'nsbp-settings-group', 'nsbp_testimonial_text_color' );
    register_setting( 'nsbp-settings-group', 'nsbp_testimonial_name_color' );
    register_setting( 'nsbp-settings-group', 'nsbp_testimonial_designation_color' );
    register_setting( 'nsbp-settings-group', 'nsbp_testimonial_website_color' );


}

function nsbp_settings_page()
{
    global $nsbp_icon_color;
    ?>
<?php settings_errors(); ?>
<div class="wrap">

<div class="nsbp-admin-column-left">
<h2 class="nsbp-plugin-title"><?php _e('Wordpress Business Plugin Settings','nsbp-business-plugin'); ?></h2>
<form method="post" action="options.php">
    <?php settings_fields( 'nsbp-settings-group' ); ?>
    <?php do_settings_sections( 'nsbp-settings-group' ); ?>
    <h3><?php _e('Back To Top Settings','nsbp-business-plugin'); ?></h3>
    <table class="form-table">
        
        <tr valign="middle">
        <th scope="row"><?php _e('Enable Back To Top','nsbp-business-plugin'); ?></th>
        <td>
        <select name="nsbp_show_back_to_top"><option value="true" <?php selected('true', get_option('nsbp_show_back_to_top')); ?>>Yes</option><option value="false" <?php selected('false', get_option('nsbp_show_back_to_top')); ?>>No</option></select>
        <p><small><?php _e('Select Yes if you want to show back to top button on your website.','nsbp-business-plugin'); ?></small></p>
        </td>
        </tr>
        <tr valign="middle">
        <th scope="row"><?php _e('Back To Top Background Color','nsbp-business-plugin'); ?></th>
        <td><input type="text" name="nsbp_back_to_bgcolor" value="<?php echo get_option('nsbp_back_to_bgcolor'); ?>" class="nsbp-color-field" data-default-color="#effeff" /></td>
        </tr>
        <tr valign="middle">
        <th scope="row"><?php _e('Back To Top Arrow Color','nsbp-business-plugin'); ?></th>
        <td>
        <select name="nsbp_back_to_iconcolor">
        <?php foreach($nsbp_icon_color as $icons): ?>
        <option value="<?php echo $icons; ?>" <?php selected($icons, get_option('nsbp_back_to_iconcolor')); ?>><?php echo $icons; ?></option>
        <?php endforeach; ?>
        </select>
        <p><small><?php _e('Select icon arrow color.','nsbp-business-plugin'); ?></small></p>
        </td>
        </tr>
        </table>
        <h3>FAQ Settings</h3>
        <table class="form-table">
        <tr valign="middle">
        <th scope="row"><?php _e('Question Color:','nsbp-business-plugin'); ?></th>
        <td><input type="text" name="nsbp_faq_question_color" value="<?php echo get_option('nsbp_faq_question_color'); ?>" class="nsbp-color-field" data-default-color="#effeff" /></td>
        </tr>
        <tr valign="middle">
        <th scope="row"><?php _e('Questions Background Color:','nsbp-business-plugin'); ?></th>
        <td><input type="text" name="nsbp_faq_question_bg" value="<?php echo get_option('nsbp_faq_question_bg'); ?>" class="nsbp-color-field" data-default-color="#effeff" /></td>
        </tr>
        <tr valign="middle">
        <th scope="row"><?php _e('Answer Color:','nsbp-business-plugin'); ?></th>
        <td><input type="text" name="nsbp_faq_answer_color" value="<?php echo get_option('nsbp_faq_answer_color'); ?>" class="nsbp-color-field" data-default-color="#effeff" /></td>
        </tr>
        <tr valign="middle">
        <th scope="row"><?php _e('Answer Background Color:','nsbp-business-plugin'); ?></th>
        <td><input type="text" name="nsbp_faq_answer_bg" value="<?php echo get_option('nsbp_faq_answer_bg'); ?>" class="nsbp-color-field" data-default-color="#effeff" /></td>
        </tr>
        <tr valign="middle">
        <th scope="row"><?php _e('Border Color:','nsbp-business-plugin'); ?></th>
        <td><input type="text" name="nsbp_faq_border_color" value="<?php echo get_option('nsbp_faq_border_color'); ?>" class="nsbp-color-field" data-default-color="#effeff" /></td>
        </tr>
        <tr valign="middle">
        <th scope="row"><?php _e('FAQ Arrow Color','nsbp-business-plugin'); ?></th>
        <td>
        <select name="nsbp_faq_icon_color">
        <?php foreach($nsbp_icon_color as $icons): ?>
        <option value="<?php echo $icons; ?>" <?php selected($icons, get_option('nsbp_faq_icon_color')); ?>><?php echo $icons; ?></option>
        <?php endforeach; ?>
        </select>
        <p><small><?php _e('Select icon arrow color.','nsbp-business-plugin'); ?></small></p>
        </td>
        </tr>
        <!-- TEAM MEMBER -->
        </table>
        <h3>TEAM Settings</h3>
        <table class="form-table">
        <tr valign="middle">
        <th scope="row"><?php _e('Team Member Name Color:','nsbp-business-plugin'); ?></th>
        <td><input type="text" name="nsbp_team_name_color" value="<?php echo get_option('nsbp_team_name_color'); ?>" class="nsbp-color-field" data-default-color="#effeff" /></td>
        </tr>
        <tr valign="middle">
        <th scope="row"><?php _e('Team Member Designation Color:','nsbp-business-plugin'); ?></th>
        <td><input type="text" name="nsbp_team_designation_color" value="<?php echo get_option('nsbp_team_designation_color'); ?>" class="nsbp-color-field" data-default-color="#effeff" /></td>
        </tr>

        <tr valign="middle">
        <th scope="row"><?php _e('Team Bio Text Color:','nsbp-business-plugin'); ?></th>
        <td><input type="text" name="nsbp_team_text_color" value="<?php echo get_option('nsbp_team_text_color'); ?>" class="nsbp-color-field" data-default-color="#effeff" /></td>
        </tr>
        <tr valign="middle">
        <th scope="row"><?php _e('Team Box Border Color:','nsbp-business-plugin'); ?></th>
        <td><input type="text" name="nsbp_team_border_color" value="<?php echo get_option('nsbp_team_border_color'); ?>" class="nsbp-color-field" data-default-color="#effeff" /></td>
        </tr>
        <tr valign="middle">
        <th scope="row"><?php _e('Team Box Background Color:','nsbp-business-plugin'); ?></th>
        <td><input type="text" name="nsbp_team_bg_color" value="<?php echo get_option('nsbp_team_bg_color'); ?>" class="nsbp-color-field" data-default-color="#effeff" /></td>
        </tr>
        <tr valign="middle">
        <th scope="row"><?php _e('Social Icons Color','nsbp-business-plugin'); ?></th>
        <td>
        <select name="nsbp_team_icons_color">
        <?php foreach($nsbp_icon_color as $icons): ?>
        <option value="<?php echo $icons; ?>" <?php selected($icons, get_option('nsbp_team_icons_color')); ?>><?php echo $icons; ?></option>
        <?php endforeach; ?>
        </select>
        <p><small><?php _e('Select icon color.','nsbp-business-plugin'); ?></small></p>
        </td>
        </tr>
        </table>
		<h3><?php _e('Testimonials Settings','nsbp-business-plugin'); ?></h3>
		<table class="form-table">
		<tr valign="middle">
        <th scope="row"><?php _e('Testimonial Text Color:','nsbp-business-plugin'); ?></th>
        <td><input type="text" name="nsbp_testimonial_text_color" value="<?php echo get_option('nsbp_testimonial_text_color'); ?>" class="nsbp-color-field" data-default-color="" /></td>
        </tr>
		<tr valign="middle">
        <th scope="row"><?php _e('Testimonial Name Color:','nsbp-business-plugin'); ?></th>
        <td><input type="text" name="nsbp_testimonial_name_color" value="<?php echo get_option('nsbp_testimonial_name_color'); ?>" class="nsbp-color-field" data-default-color="" /></td>
        </tr>
		<tr valign="middle">
        <th scope="row"><?php _e('Testimonial Designation Color:','nsbp-business-plugin'); ?></th>
        <td><input type="text" name="nsbp_testimonial_designation_color" value="<?php echo get_option('nsbp_testimonial_designation_color'); ?>" class="nsbp-color-field" data-default-color="" /></td>
        </tr>
		<tr valign="middle">
        <th scope="row"><?php _e('Testimonial Link/Website Color:','nsbp-business-plugin'); ?></th>
        <td><input type="text" name="nsbp_testimonial_website_color" value="<?php echo get_option('nsbp_testimonial_website_color'); ?>" class="nsbp-color-field" data-default-color="" /></td>
        </tr>
		</table>
        <h3><?php _e('Other Settings','nsbp-business-plugin'); ?></h3>
        <table class="form-table">
        <tr valign="middle">
        <th scope="row"><?php _e('Display Credit Link','nsbp-business-plugin'); ?></th>
        <td>
        <select name="nsbp_show_credit_link"><option value="true" <?php selected('true', get_option('nsbp_show_credit_link')); ?>>Yes</option><option value="false" <?php selected('false', get_option('nsbp_show_credit_link')); ?>>No</option></select>
        <p><small><?php _e('If you like our plugin you can display our link in footer as a credit. You can hide that using above option.','nsbp-business-plugin'); ?></small></p>
        </td>
        </tr>

    </table>

    <?php submit_button(); ?>

</form>
</div>
<div class="nsbp-admin-column-right">
<h4>Help & Support</h4>
<?php _e('For more details about the help and documentation of this plugin please visit documentation at <a href="http://www.snilesh.com/wordpress-business-plugin/" target="_blank" title="Wordpress Business Plugin">Wordpress Business Plugin</a>','nsbp-business-plugin'); ?>
</div>
    <?php
}

add_action( 'admin_enqueue_scripts', 'nsbp_admin_enqueue_color_picker' );
function nsbp_admin_enqueue_color_picker( $hook_suffix ) {
    // first check that $hook_suffix is appropriate for your admin page
    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_script( 'nsbp-admin-script', WP_BUSINESS_PLUGIN_URL.'js/nsbp-admin-script.js', array( 'wp-color-picker' ), false, true );
    wp_register_style( 'nsbp-admin-style', WP_BUSINESS_PLUGIN_URL.'css/nsbp-admin-style.css', false, '1.0.0' );
    wp_enqueue_style( 'nsbp-admin-style' );
}
?>