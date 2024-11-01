<?php
add_shortcode('su_gallery','su_get_gallery');


function su_get_gallery($args){
	 ob_start();
	 if(isset($args['id'])){
		$postid=$args['id'];
		$images = unserialize(get_post_meta($postid, 'gallery-images', true));
		if(!empty($images)){?>
		<div class="su-gallery">
		<?php
			foreach($images as $image_id){
				$image_url = wp_get_attachment_url($image_id);
				
				$path = parse_url($image_url, PHP_URL_PATH);
				if(file_exists($_SERVER['DOCUMENT_ROOT'] . $path)){?>
				<a href="<?php echo $image_url; ?>" data-fancybox="images" class="su-img hvr-shadow-radial">
							<?php print_r(wp_get_attachment_image($image_id)); ?>
				</a><?php
				}
			}
			?>
		</div>
		<?php 
		}
	 }
	 else{
			$pargs = array('post_type' => 'su_gallery',
										'posts_per_page' =>-1,
										 );
			$loop = new WP_Query( $pargs );
			
			while ( $loop->have_posts() ) : $loop->the_post();
			
			 	$postid=get_the_ID();
				$images = unserialize(get_post_meta($postid, 'gallery-images', true));
				if(!empty($images)){?>
				<div class="su-gallery">
                <h3><?php echo ucwords(get_the_title());?> </h3>
				<?php
					foreach($images as $image_id){
						$image_url = wp_get_attachment_url($image_id);
						
						$path = parse_url($image_url, PHP_URL_PATH);
						if(file_exists($_SERVER['DOCUMENT_ROOT'] . $path)){?>
						<a href="<?php echo $image_url; ?>" data-fancybox="images" class="su-img hvr-shadow-radial">
									<?php print_r(wp_get_attachment_image($image_id)); ?>
						</a><?php
						}
					}
					?>
				</div>
				<?php 
				}
			endwhile;
	}
	$output = ob_get_clean();
	return $output;
}
?>
