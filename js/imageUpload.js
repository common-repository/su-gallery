jQuery(function($){
	
	
	$('.meta-builder-imageGalleryUpload').on('click','.meta-builder-gallery-upload-button', function(event){
		event.preventDefault();
		var current_gallery_box = $(this).parents('.meta-builder-imageGalleryUpload');
		var gallery_name = $(this).attr('data-galleryName');
		var image_list = $(current_gallery_box).find('ul');
		
		var frame = wp.media({
		  title: 'Select or Upload Image',
		  button: {
			text: 'Upload'
		  },
		  multiple: true 
		});
		
		frame.on( 'select', function() {
			var attachment = frame.state().get('selection').toJSON();
			for(var i=0; i< attachment.length; i++){
				$(image_list).append("<li><img src='"+attachment[i].url+"'/><input type='hidden' name='"+gallery_name+"[]' value='"+attachment[i].id+"'/><span class='remove'>&times;</span></li>");
				//console.log(attachment[i].id);
			}
			
		});

		frame.open();
	});
	
	$('.meta-builder-imageGalleryUpload').on('click','ul li span.remove', function(event){
		$(this).parent('li').remove();
	});
	
	$('.video-uploader').on('click','.upload-video', function(event){
		event.preventDefault();
		var inputBox = $(this).parents('.video-uploader').find('input');
		var frame = wp.media({
		  title: 'Select or Upload Video',
		  button: {
			text: 'Upload'
		  },
		  multiple: false 
		});
		
		frame.on( 'select', function() {
			var attachment = frame.state().get('selection').first().toJSON();
			$(inputBox).val(attachment.url);
		});

		frame.open();
	});
	
});