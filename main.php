<?php
/* Plugin Name: su-gallery
 * License: GPLv2 or later
 * Description: Allow users to create multiple photo galleries with fancybox 3. Integrates with your website in less than 20 seconds.
 * Version: 1.4.1
 * Author: Suryaveer Singh
 * Author URI: https://in.linkedin.com/in/suryaveer-singh-a8792326
*/



function su_gallery_init() {
	$labels = array(
		'name'               => _x( 'Su-Gallery', 'post type general name', 'su-gallery' ),
		'singular_name'      => _x( 'Gallery', 'post type singular name', 'su-gallery' ),
		'menu_name'          => _x( 'Su-Gallery', 'admin menu', 'su-gallery' ),
		'name_admin_bar'     => _x( 'Gallery', 'add new on admin bar', 'su-gallery' ),
		'add_new'            => _x( 'Add New', 'Image_dh', 'su-gallery' ),
		'add_new_item'       => __( 'Add New Gallery', 'su-gallery' ),
		'new_item'           => __( 'New Gallery', 'su-gallery' ),
		'edit_item'          => __( 'Edit Gallery', 'su-gallery' ),
		'view_item'          => __( 'View Gallery', 'su-gallery' ),
		'all_items'          => __( 'All Gallery', 'su-gallery' ),
		'search_items'       => __( 'Search Gallery', 'su-gallery' ),
		'parent_item_colon'  => __( 'Parent Gallery:', 'su-gallery' ),
		'not_found'          => __( 'No Gallery found.', 'su-gallery' ),
		'not_found_in_trash' => __( 'No Gallery found in Trash.', 'su-gallery' )
	);

	$args = array(
		'labels'             => $labels,
        'description'        => __( 'Description.', 'su-gallery' ),
		'public'             => false,
		'publicly_queryable' => false,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'has_archive'        => false,
		'menu_icon'			 => 'dashicons-images-alt',
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title',  'page-attributes')
	);

	register_post_type( 'su_gallery', $args );
	
}
add_action( 'init', 'su_gallery_init' );
add_action( 'admin_init', 'su_gallery_meta_scripts' );
function su_gallery_meta_scripts(){
	global $post;
	if ( ! wp_script_is( 'jquery', 'enqueued' )) {

        //Enqueue
        wp_enqueue_script( 'jquery' );

    }
if(  !isset($post) || 'su_gallery' != $post->post_type )
	//wp_enqueue_media();
	wp_enqueue_script( 'su_gallery_meta-scripts', plugins_url( '/js/imageUpload.js', __FILE__ ) , array ( 'jquery' ), '1.1', true);
	wp_enqueue_script( 'su_gallery_ui-scripts',plugins_url( '/js/jquery-ui.js', __FILE__ ), array ( 'jquery' ), '1.12.1', true);
}
function su_gallery_scripts(){

wp_enqueue_style( 'fancybox', plugins_url( '/fancybox-master/dist/jquery.fancybox.min.css', __FILE__ ), array(), '3', 'all');
wp_enqueue_style( 'su-gallery', plugins_url( '/css/su-gallery.css', __FILE__ ), array(), '1', 'all');
wp_enqueue_style( 'su-hover', plugins_url( '/css/hover-min.css', __FILE__ ), array(), '1', 'all');
wp_enqueue_script( 'fancybox-script',  plugins_url( '/fancybox-master/dist/jquery.fancybox.min.js', __FILE__ ), array ( 'jquery' ), '3', true);

}

add_action( 'wp_enqueue_scripts', 'su_gallery_scripts' );


add_filter( 'manage_edit-su_gallery_columns',  'su_gallery_add_new_columns' );
add_filter( 'manage_edit-su_gallery_sortable_columns', 'su_gallery_register_sortable_columns' );

add_action( 'manage_posts_custom_column' , 'su_gallery_custom_columns' );

function su_gallery_add_new_columns($columns){

    $column_meta = array( 'shortcode' => 'Shortcode' );
    $columns = array_slice( $columns, 0, 2, true ) + $column_meta + array_slice( $columns, 2, NULL, true );
    return $columns;

}


function su_gallery_register_sortable_columns( $columns ) {
    $columns['shortcode'] = 'shortcode';
    return $columns;
}


function su_gallery_custom_columns($column) {

    global $post;

    switch ( $column ) {
        case 'shortcode':
            print_r("[su_gallery id=".$post->ID."]");
        break;
    }
}

include_once('meta.php');
include_once('shortcode.php');
?>