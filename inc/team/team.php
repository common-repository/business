<?php
/*
    Add Teams System to any wordpress website.
*/

/* Register the Custom Post Type */
add_action('init', function() {

	$labels = array(
		'name' => _x('Team', 'post type general name','nsbp-business-plugin'),
		'singular_name' => _x('Team', 'post type singular name','nsbp-business-plugin'),
		'add_new' => _x('Add New Team Member', 'Question','nsbp-business-plugin'),
		'add_new_item' => __('Add New Team Member','nsbp-business-plugin'),
		'edit_item' => __('Edit Team Member','nsbp-business-plugin'),
		'new_item' => __('New Team Member','nsbp-business-plugin'),
		'all_items' => __('All Team Members','nsbp-business-plugin'),
		'view_item' => __('View Team Members','nsbp-business-plugin'),
		'search_items' => __('Search Team Member','nsbp-business-plugin'),
		'not_found' => __('No Team Member found','nsbp-business-plugin'),
		'not_found_in_trash' => __('No Team Member found in Trash','nsbp-business-plugin'),
		'parent_item_colon' => '',
		'menu_name' => 'Team'
	);

	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'team' ),
		'capability_type' => 'post',
		'has_archive' => true,
		'hierarchical' => false,
		'menu_position' => '20.3',
		'menu_icon'=>WP_BUSINESS_PLUGIN_URL.'/images/icons/team.png',
		'supports' => array('title', 'editor','thumbnail','page-attributes'),
		'register_meta_box_cb' => 'teams_meta_boxes'
	);
	register_post_type('snilesh-team', $args);
		// Initialize Taxonomy Labels
	$labels = array(
		'name' => _x( 'Departments', 'taxonomy general name' ,'nsbp-business-plugin'),
		'singular_name' => _x( 'Department', 'taxonomy singular name' ,'nsbp-business-plugin'),
		'search_items' =>  __( 'Search Department','nsbp-business-plugin' ),
		'all_items' => __( 'All Departments','nsbp-business-plugin' ),
		'edit_item' => __( 'Edit Department' ,'nsbp-business-plugin'),
		'update_item' => __( 'Update Department' ,'nsbp-business-plugin'),
		'add_new_item' => __( 'Add New Department' ,'nsbp-business-plugin'),
		'new_item_name' => __( 'New Department Name' ,'nsbp-business-plugin'),
	);
		
	// Register Custom Taxonomy
	register_taxonomy('department',array('snilesh-team'), array(
		'hierarchical' => true, // define whether to use a system like tags or categories
		'labels' => $labels,
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'department' )
	));

});


function teams_meta_boxes() {
    add_meta_box( 'teams_form', 'Team Member Details', 'teams_form', 'snilesh-team', 'normal', 'high' );
}
 
function teams_form() {
    $post_id = get_the_ID();
    $team_member_data = get_post_meta( $post_id, '_team', true );
    $designation = ( empty( $team_member_data['designation'] ) ) ? '' : $team_member_data['designation'];
    $email = ( empty( $team_member_data['email'] ) ) ? '' : $team_member_data['email'];
    $link = ( empty( $team_member_data['link'] ) ) ? '' : $team_member_data['link'];
    $phonenumber = ( empty( $team_member_data['phonenumber'] ) ) ? '' : $team_member_data['phonenumber'];
    $facebook = ( empty( $team_member_data['facebook'] ) ) ? '' : $team_member_data['facebook'];
    $googleplus = ( empty( $team_member_data['googleplus'] ) ) ? '' : $team_member_data['googleplus'];
    $twitter = ( empty( $team_member_data['twitter'] ) ) ? '' : $team_member_data['twitter'];
    $pinterest = ( empty( $team_member_data['pinterest'] ) ) ? '' : $team_member_data['pinterest'];
    $linkedin = ( empty( $team_member_data['linkedin'] ) ) ? '' : $team_member_data['linkedin'];
    $skype = ( empty( $team_member_data['skype'] ) ) ? '' : $team_member_data['skype'];
    $flickr = ( empty( $team_member_data['flickr'] ) ) ? '' : $team_member_data['flickr'];
 
    wp_nonce_field( 'business_plug_team_member', 'business_plug_team_member_nonce' );
    ?>
    <p>
        <label>Member Designation (optional)</label><br />
        <input type="text" value="<?php echo $designation; ?>" name="teammember[designation]" size="40" />
    </p>
    <p>
        <label>Email (optional)</label><br />
        <input type="text" value="<?php echo $email; ?>" name="teammember[email]" size="40" />
    </p>
    <p>
        <label>Website Link (optional)</label><br />
        <input type="text" value="<?php echo $link; ?>" name="teammember[link]" size="40" />
    </p>
	<p>
        <label>Phone Number (optional)</label><br />
        <input type="text" value="<?php echo $phonenumber; ?>" name="teammember[phonenumber]" size="40" />
    </p>
	<p>
        <label>Facebook Profile (optional)</label><br />
        <input type="text" value="<?php echo $facebook; ?>" name="teammember[facebook]" size="40" />
    </p>
	<p>
        <label>Google+ Profile (optional)</label><br />
        <input type="text" value="<?php echo $googleplus; ?>" name="teammember[googleplus]" size="40" />
    </p>
	<p>
        <label>Twitter Profile (optional)</label><br />
        <input type="text" value="<?php echo $twitter; ?>" name="teammember[twitter]" size="40" />
    </p>
	<p>
        <label>Pinterest Profile (optional)</label><br />
        <input type="text" value="<?php echo $pinterest; ?>" name="teammember[pinterest]" size="40" />
    </p>
	<p>
        <label>LinkedIn Profile (optional)</label><br />
        <input type="text" value="<?php echo $linkedin; ?>" name="teammember[linkedin]" size="40" />
    </p>
	<p>
        <label>Skype ID (optional)</label><br />
        <input type="text" value="<?php echo $skype; ?>" name="teammember[skype]" size="40" />
    </p>
	<p>
        <label>Flickr Profile(optional)</label><br />
        <input type="text" value="<?php echo $flickr; ?>" name="teammember[flickr]" size="40" />
    </p>

    <?php
}


function teammember_save_postdata($post_id){

      // Verify this came from the our screen and with proper authorization,
      // because save_post can be triggered at other times
      // Check if our nonce is set.
  if ( ! isset( $_POST['business_plug_team_member_nonce'] ) )
    return $post_id;

  $nonce = $_POST['business_plug_team_member_nonce'];

	// Verify that the nonce is valid.
	 if ( ! wp_verify_nonce( $nonce, 'business_plug_team_member' ) )
      return $post_id;

      // Verify if this is an auto save routine. If it is our form has not been submitted, so we dont want
      // to do anything
      if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) 
        return $post_id;


      // Check permissions to edit pages and/or posts
      if ( 'snilesh-team' == $_POST['post_type']) {
        if ( !current_user_can( 'edit_page', $post_id ) || !current_user_can( 'edit_post', $post_id ))
          return $post_id;
      } 

      // OK, we're authenticated: we need to find and save the data
      $teammember = $_POST['teammember'];
	  

      // save data in INVISIBLE custom field (note the "_" prefixing the custom fields' name
      update_post_meta($post_id, '_team', $teammember); 

    }

//On post save, save plugin's data
add_action('save_post', 'teammember_save_postdata');

add_action('do_meta_boxes', 'change_team_memberl_image_box');
function change_team_memberl_image_box()
{
    remove_meta_box( 'postimagediv', 'snilesh-team', 'side' );
    add_meta_box('postimagediv', __('Team Member Photo / Avatar'), 'post_thumbnail_meta_box', 'snilesh-team', 'normal', 'high');
}

/* Add columns to display image and department id on teams listing  page */

add_filter( 'manage_edit-snilesh-team_columns', 'snilesh_teammember_business_columns' ) ;

function snilesh_teammember_business_columns( $columns ) {

    $columns = array(
        'cb' => '<input type="checkbox" />',
        
        'image' => __( 'Image' ),
        'title' => __( 'Team Member' ),
        'department' => __( 'Department ID' ),
        'date' => __( 'Date' )
    );

    return $columns;
}

add_action( 'manage_snilesh-team_posts_custom_column', 'snilesh_teammember_business_manage_columns', 10, 2 );

function snilesh_teammember_business_manage_columns( $column, $post_id ) {
    global $post;

    switch( $column ) {

        /* If displaying the 'duration' column. */
        case 'image' :

            if(has_post_thumbnail($post_id))
            {
                the_post_thumbnail(array('150',150));
            }

            break;
        case 'department':
        $terms = get_the_terms($post_id, 'department');
        if(count($terms)>0)
        {
          echo '<ul>';    
          foreach($terms as $term)
          {
            echo '<li>'.$term->name.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [ ID : '.$term->term_id.' ]</li>';
          }
          echo '</ul>';
        }

        /* Just break out of the switch statement for everything else. */
        default :
            break;
    }
}

// Add to admin_init function
add_filter("manage_edit-department_columns", 'snilesh_teammember_business_manage_dept_columns'); 
 
function snilesh_teammember_business_manage_dept_columns($theme_columns) {
    $new_columns = array(
        'cb' => '<input type="checkbox" />',
        'name' => __('Department Name'),
        'departmentid' => __('Department ID'),
        'description' => __('Description'),
        'posts' => __('Team Members')
        );
    return $new_columns;
}

// Add to admin_init function   
add_filter("manage_department_custom_column", 'snilesh_teammember_business_manage_dept_columns_show', 10, 3);
 
function snilesh_teammember_business_manage_dept_columns_show($out, $column_name, $term_id) {
    switch ($column_name) {
        case 'departmentid': 
            echo '<strong>'.$term_id.'</strong>';
            break;
 
        default:
            break;
    }
    return $out;    
}


include('team-shortcode.php');
?>
