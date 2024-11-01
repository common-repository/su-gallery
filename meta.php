<?php

add_action('add_meta_boxes','su_gallery_Metabox');

function su_gallery_Metabox(){
	add_meta_box('meta-builder','Others','su_gallery_Page_Controls','su_gallery','normal','default');
	add_meta_box('meta-shortcode','Shortcode','su_gallery_shortcode','su_gallery','side','high');

}
function su_gallery_shortcode(){
	global $post;
	print_r("[su_gallery id=".$post->ID."]");
	
}

function su_gallery_Page_Controls(){
	global $post;
	 
	?>
<style>
.meta-builder-imageGalleryUpload ul {
	display: block;
	margin: 0;
}
.meta-builder-imageGalleryUpload ul li {
	display: inline-block;
	border: 1px solid #999;
	margin-right: 12px;
	margin-bottom: 15px;
	position: relative;
	cursor: move;
}
.meta-builder-imageGalleryUpload ul li span.remove {
	position: absolute;
	top: -10px;
	right: -10px;
	font-size: 20px;
	line-height: 18px;
	height: 22px;
	width: 22px;
	text-align: center;
	cursor: pointer;
	background: #ffffff;
	color: #999999;
	border: 1px solid #999999;
	border-radius: 50%;
}
.meta-builder-imageGalleryUpload ul li span.remove:hover {
	color:#f31313;
	border: 1px solid #f31313;
}
.meta-builder-imageGalleryUpload ul li img {
	height:100px;
	width:100px;
	display:block;
}
</style>
<?php
	wp_nonce_field(basename(__FILE__),'meta_builder_nonce');
	$template = get_page_template_slug( $post->ID );

		?>
<h3>Gallery Images:</h3>
<div class="meta-builder-imageGalleryUpload">
  <ul  id="sortable">
    <?php
				$images = unserialize(get_post_meta($post->ID, 'gallery-images', true));
				
				if(!empty($images)){
					foreach($images as $image_id){
						
						
						$image_url = wp_get_attachment_url($image_id);
						
						$path = parse_url($image_url, PHP_URL_PATH);

						if(file_exists($_SERVER['DOCUMENT_ROOT'] . $path)){
						?>
    <li class="ui-state-default"> <img src="<?php echo $image_url; ?>">
      <input type="hidden" name="gallery-images[]" value="<?php echo $image_id; ?>">
      <span class="remove">&times;</span> </li>
    <?php
						}
					}}
				?>
  </ul>
  <button data-galleryName="gallery-images" type="button" class="meta-builder-gallery-upload-button button button-primary">Add Images</button>
  <p><i>Gallery Images</i></p>
</div>
<script>
  $( function() {
    $( "#sortable" ).sortable();
    $( "#sortable" ).disableSelection();
  } );
  </script>
<?php /*?>	<hr/>
		<h1 style="text-align:center;">Or</h1>
		<h3>Upload Video:</h3>
		<div class="video-uploader">
		<input type="text" value="<?php echo get_post_meta($post->ID, 'upload-video', true); ?>" name="upload-video">
		<button type="button" class="upload-video button button-primary">Upload</button>
		</div>
		
		<?php */
}


add_action('save_post','su_gallery_save_Controls',10,2);

function su_gallery_save_Controls($post_id, $post){
	//echo $_POST['offers_booking_link'];die;
	if(!isset($_POST['meta_builder_nonce'])|| !wp_verify_nonce($_POST['meta_builder_nonce'], basename(__FILE__)))
		return $post_id;
	
	if(!current_user_can('edit_post', $post->ID))
		return $post_id;
	
	if(isset($_POST['gallery-images']))
	update_post_meta( $post_id, 'gallery-images', serialize($_POST['gallery-images']) );
	
//	if(isset($_POST['upload-video']))
	//update_post_meta( $post_id, 'upload-video', $_POST['upload-video']);

	
}
?>