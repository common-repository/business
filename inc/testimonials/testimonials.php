<?php
/*
    Add Testimonial System to any wordpress website.
*/

/* Register the Custom Post Type */
add_action('init', function() {

	$labels = array(
		'name' => _x('Testimonial', 'post type general name','nsbp-business-plugin'),
		'singular_name' => _x('Testimonial', 'post type singular name','nsbp-business-plugin'),
		'add_new' => _x('Add New Testimonial', 'Question','nsbp-business-plugin'),
		'add_new_item' => __('Add New Testimonial','nsbp-business-plugin'),
		'edit_item' => __('Edit Testimonial','nsbp-business-plugin'),
		'new_item' => __('New Testimonial','nsbp-business-plugin'),
		'all_items' => __('All Testimonials','nsbp-business-plugin'),
		'view_item' => __('View Testimonial','nsbp-business-plugin'),
		'search_items' => __('Search Testimonial','nsbp-business-plugin'),
		'not_found' => __('No Testimonial found','nsbp-business-plugin'),
		'not_found_in_trash' => __('No Testimonial found in Trash','nsbp-business-plugin'),
		'parent_item_colon' => '',
		'menu_name' => 'Testimonials'
	);

	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'testimonials' ),
		'capability_type' => 'post',
		'has_archive' => true,
		'hierarchical' => false,
		'menu_position' => '20.3',
		'menu_icon'=>WP_BUSINESS_PLUGIN_URL.'/images/icons/testimonials.png',
		'supports' => array('title', 'editor','thumbnail','page-attributes'),
		'register_meta_box_cb' => 'testimonials_meta_boxes'
	);
	register_post_type('snilesh-testimonials', $args);
		// Initialize Taxonomy Labels
	$labels = array(
		'name' => _x( 'Testimonials Categories', 'taxonomy general name','nsbp-business-plugin' ),
		'singular_name' => _x( 'Testimonials Category', 'taxonomy singular name' ,'nsbp-business-plugin'),
		'search_items' =>  __( 'Search Testimonials Categories','nsbp-business-plugin' ),
		'all_items' => __( 'All Testimonials Categories','nsbp-business-plugin' ),
		'edit_item' => __( 'Edit Testimonial Category' ,'nsbp-business-plugin'),
		'update_item' => __( 'Update Testimonial Category' ,'nsbp-business-plugin'),
		'add_new_item' => __( 'Add New Testimonial Category' ,'nsbp-business-plugin'),
		'new_item_name' => __( 'New Testimonial Category Name','nsbp-business-plugin' ),
	);
		
	// Register Custom Taxonomy
	register_taxonomy('testimonials-category',array('snilesh-testimonials'), array(
		'hierarchical' => true, // define whether to use a system like tags or categories
		'labels' => $labels,
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'testimonials-category' )
	));

});


function testimonials_meta_boxes() {
    add_meta_box( 'testimonials_form', 'Testimonial Details', 'testimonials_form', 'snilesh-testimonials', 'normal', 'high' );
}
 
function testimonials_form() {
    $post_id = get_the_ID();
    $testimonial_data = get_post_meta( $post_id, '_testimonial', true );
    $client_designation = ( empty( $testimonial_data['client_designation'] ) ) ? '' : $testimonial_data['client_designation'];
    $businessname = ( empty( $testimonial_data['businessname'] ) ) ? '' : $testimonial_data['businessname'];
    $link = ( empty( $testimonial_data['link'] ) ) ? '' : $testimonial_data['link'];
 
    wp_nonce_field( 'business_plug_testimonials', 'business_plug_testimonials_nonce' );
    ?>
    <p>
        <label>Client's Designation (optional)</label><br />
        <input type="text" value="<?php echo $client_designation; ?>" name="testimonial[client_designation]" size="40" />
    </p>
    <p>
        <label>Business/Site Name (optional)</label><br />
        <input type="text" value="<?php echo $businessname; ?>" name="testimonial[businessname]" size="40" />
    </p>
    <p>
        <label>Link (optional)</label><br />
        <input type="text" value="<?php echo $link; ?>" name="testimonial[link]" size="40" />
    </p>
    <?php
}


function testimonials_save_postdata($post_id){

      // Verify this came from the our screen and with proper authorization,
      // because save_post can be triggered at other times
      // Check if our nonce is set.
  if ( ! isset( $_POST['business_plug_testimonials_nonce'] ) )
    return $post_id;

  $nonce = $_POST['business_plug_testimonials_nonce'];

	// Verify that the nonce is valid.
	 if ( ! wp_verify_nonce( $nonce, 'business_plug_testimonials' ) )
      return $post_id;

      // Verify if this is an auto save routine. If it is our form has not been submitted, so we dont want
      // to do anything
      if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) 
        return $post_id;


      // Check permissions to edit pages and/or posts
      if ( 'snilesh-testimonials' == $_POST['post_type']) {
        if ( !current_user_can( 'edit_page', $post_id ) || !current_user_can( 'edit_post', $post_id ))
          return $post_id;
      } 

      // OK, we're authenticated: we need to find and save the data
      $testimonials = $_POST['testimonial'];
	  

      // save data in INVISIBLE custom field (note the "_" prefixing the custom fields' name
      update_post_meta($post_id, '_testimonial', $testimonials); 

    }

//On post save, save plugin's data
add_action('save_post', 'testimonials_save_postdata');

add_action('do_meta_boxes', 'change_testimonial_image_box');
function change_testimonial_image_box()
{
    remove_meta_box( 'postimagediv', 'snilesh-testimonials', 'side' );
    add_meta_box('postimagediv', __('Clients Photo or Logo'), 'post_thumbnail_meta_box', 'snilesh-testimonials', 'normal', 'high');
}

/* Add columns to display image and testimonials id on teams listing  page */

add_filter( 'manage_edit-snilesh-testimonials_columns', 'snilesh_testimonials_business_columns' ) ;

function snilesh_testimonials_business_columns( $columns ) {

    $columns = array(
        'cb' => '<input type="checkbox" />',
        
        'image' => __( 'Photo' ),
        'title' => __( 'Client Name' ),
        'testimonialscat' => __( 'Testimonials Category ID' ),
        'date' => __( 'Date' )
    );

    return $columns;
}

add_action( 'manage_snilesh-testimonials_posts_custom_column', 'snilesh_testimonials_business_manage_columns', 10, 2 );

function snilesh_testimonials_business_manage_columns( $column, $post_id ) {
    global $post;

    switch( $column ) {

        /* If displaying the 'duration' column. */
        case 'image' :

            if(has_post_thumbnail($post_id))
            {
                the_post_thumbnail(array('150',150));
            }

            break;
        case 'testimonialscat':
        $terms = get_the_terms($post_id, 'testimonials-category');
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
add_filter("manage_edit-testimonials-category_columns", 'snilesh_testimonials_business_manage_cat_columns'); 
 
function snilesh_testimonials_business_manage_cat_columns($theme_columns) {
    $new_columns = array(
        'cb' => '<input type="checkbox" />',
        'name' => __('Category Name'),
        'testimonialscat' => __('Testimonials Cat ID'),
        'description' => __('Description'),
        'posts' => __('Testimonials')
        );
    return $new_columns;
}

// Add to admin_init function   
add_filter("manage_testimonials-category_custom_column", 'snilesh_testimonials_business_manage_cat_columns_show', 10, 3);
 
function snilesh_testimonials_business_manage_cat_columns_show($out, $column_name, $term_id) {
    switch ($column_name) {
        case 'testimonialscat': 
            echo '<strong>'.$term_id.'</strong>';
            break;
 
        default:
            break;
    }
    return $out;    
}


include('testimonial-shortcode.php');
?>
