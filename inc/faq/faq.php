<?php
/*
  Add FAQ System to any wordpress theme.
*/

/* Register the Custom Post Type */
add_action('init', function() {

	$labels = array(
		'name' => _x('FAQ', 'post type general name','nsbp-business-plugin'),
		'singular_name' => _x('Question', 'post type singular name','nsbp-business-plugin'),
		'add_new' => _x('Add New Question', 'Question','nsbp-business-plugin'),
		'add_new_item' => __('Add New Question','nsbp-business-plugin'),
		'edit_item' => __('Edit Question','nsbp-business-plugin'),
		'new_item' => __('New Question','nsbp-business-plugin'),
		'all_items' => __('All FAQ Questions','nsbp-business-plugin'),
		'view_item' => __('View Question','nsbp-business-plugin'),
		'search_items' => __('Search FAQ','nsbp-business-plugin'),
		'not_found' => __('No FAQ found','nsbp-business-plugin'),
		'not_found_in_trash' => __('No FAQ found in Trash','nsbp-business-plugin'),
		'parent_item_colon' => '',
		'menu_name' => 'FAQ'
	);

	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'faq' ),
		'capability_type' => 'post',
		'has_archive' => true,
		'hierarchical' => false,
		'menu_position' => '20.2',
		'menu_icon'=>WP_BUSINESS_PLUGIN_URL.'/images/icons/faq.png',
		'supports' => array('title', 'editor', 'page-attributes')
	);
	register_post_type('snilesh-faq', $args);
		// Initialize Taxonomy Labels
	$labels = array(
		'name' => _x( 'FAQ Categories', 'taxonomy general name' ,'nsbp-business-plugin'),
		'singular_name' => _x( 'FAQ Category', 'taxonomy singular name' ,'nsbp-business-plugin'),
		'search_items' =>  __( 'Search Types' ,'nsbp-business-plugin'),
		'all_items' => __( 'All FAQ Categories' ,'nsbp-business-plugin'),
		'edit_item' => __( 'Edit FAQ Category' ,'nsbp-business-plugin'),
		'update_item' => __( 'Update FAQ Category' ,'nsbp-business-plugin'),
		'add_new_item' => __( 'Add New FAQ Category' ,'nsbp-business-plugin'),
		'new_item_name' => __( 'New FAQ Category Name' ,'nsbp-business-plugin'),
	);
		
	// Register Custom Taxonomy
	register_taxonomy('faq-category',array('snilesh-faq'), array(
		'hierarchical' => true, // define whether to use a system like tags or categories
		'labels' => $labels,
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'faq-category' )
	));

});

/* Add columns to display image and categories id on teams listing  page */

add_filter( 'manage_edit-faq_columns', 'snilesh_faq_business_columns' ) ;

function snilesh_faq_business_columns( $columns ) {

    $columns = array(
        'cb' => '<input type="checkbox" />',
        'title' => __( 'Question' ),
        'faqcategory' => __( 'FAQ Category ID' ),
        'description'=>'Answer',
        'date' => __( 'Date' )
    );

    return $columns;
}

add_action( 'manage_faq_posts_custom_column', 'snilesh_faq_business_manage_columns', 10, 2 );

function snilesh_faq_business_manage_columns( $column, $post_id ) {
    global $post;

    switch( $column ) {

        /* If displaying the 'duration' column. */
       
        case 'faqcategory':
        $terms = get_the_terms($post_id, 'faq-category');
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
add_filter("manage_edit-faq-category_columns", 'snilesh_teammember_business_manage_faq_columns'); 
 
function snilesh_teammember_business_manage_faq_columns($theme_columns) {
    $new_columns = array(
        'cb' => '<input type="checkbox" />',
        'name' => __('Category Name'),
        'faqcategory' => __('FAQ Category ID'),
        'description' => __('Description'),
        'posts' => __('Questions')
        );
    return $new_columns;
}

// Add to admin_init function   
add_filter("manage_faq-category_custom_column", 'snilesh_teammember_business_manage_faq_columns_show', 10, 3);
 
function snilesh_teammember_business_manage_faq_columns_show($out, $column_name, $term_id) {
    switch ($column_name) {
        case 'faqcategory': 
            echo '<strong>'.$term_id.'</strong>';
            break;
 
        default:
            break;
    }
    return $out;    
}

//include('faq-widgets.php');
include('faq-shortcode.php');
?>