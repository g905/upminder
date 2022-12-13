jQuery(function($) {
	
	var cropper = null;
													
	function update_fields(cx) {
					
		var dt = cx.getData();
		$('#p_x').val(Math.round(dt.x));
		$('#p_y').val(Math.round(dt.y));
		$('#p_width').val(Math.round(dt.width));
		$('#p_height').val(Math.round(dt.height));
		$('#p_angle').val(dt.rotate);
				
	}
	
	/* Обработка изображения */
	$(document).on('click', '#p_crop', function() {
		
		$.ajax({
			
			url: $('#p_start_form').attr('action'),
			type: 'post',
			data: $('#p_start_form').serialize(),
			dataType: 'json',
			beforeSend: function() {
				$('.col_right').addClass('loading');
			},
			success: function(response) {
				
				$('#p_start_form').html(response.text);
				
				setTimeout(function() {
					$('.col_right').removeClass('loading');
				}, 1000);
				
			}
			
		});
		
	});
	
	/* Выбран вариант */
	$(document).on('click', '#p_select', function() {
		
		$.ajax({
			
			url: $('#p_start_form').attr('action'),
			type: 'post',
			data: $('#p_start_form').serialize(),
			dataType: 'json',
			beforeSend: function() {
				$('.col_right').addClass('loading');
			},
			success: function(response) {
				
				$('#p_start_form').html(response.text);
				
				setTimeout(function() {
					$('.col_right').removeClass('loading');
				}, 1000);
				
			}
			
		});
		
	});
		
	/* DropArea & Загрузка изображения */
	$(document).on('dragover', '#p_drop', function(e) {
		
		e.preventDefault();
		e.stopPropagation();
		
	});
	
	$(document).on('dragenter', '#p_drop', function(e) {
		
		e.preventDefault();
		e.stopPropagation();
		
	});
	
	$(document).on('drop', '#p_drop', function(e) {
		
		if (e.originalEvent.dataTransfer && e.originalEvent.dataTransfer.files.length) {
			
			e.preventDefault();
			e.stopPropagation();
			
			var this_file = e.originalEvent.dataTransfer.files[0];
			var form_data = new FormData();
			form_data.append('action', 'upload');
			form_data.append('image', this_file);
			
			$.ajax({
				
				url: $('#p_start_form').attr('action'),
				type: 'post',
				data: form_data,
				dataType: 'json',
				cache: false,
				processData: false,
				contentType: false,
				beforeSend: function() {
					$('.col_right').addClass('loading');
				},
				success: function(response) {
					
					if (response.status == 'ok') {
						
						$('#p_start_form').html(response.text);
						
						/* Cropper */
						cropper = new Cropper($('#preview_photo')[0], {
							
							viewMode: 1,
							dragMode: 'move',
							aspectRatio: 0.7,
							autoCropArea: 0.65,
							restore: false,
							guides: true,
							center: true,
							highlight: true,
							cropBoxMovable: false,
							cropBoxResizable: false,
							toggleDragModeOnDblclick: false,
							ready: function(event) {
								update_fields(event.target.cropper);
							},
							zoom: function(event) {
								update_fields(event.target.cropper);
							},
							crop: function(event) {
								
								var img = $('#image')[0];
								update_fields(event.target.cropper);
							
							}
							
						});
												
					}
					
					setTimeout(function() {
						$('.col_right').removeClass('loading');
					}, 1000);
					
				}
				
			});
			
		}
		
	});
	
	$(document).on('click', '.select_photo', function() {
		
		var this_variant = $(this).data('var');
		$('.select_photo').removeClass('selected');
		$(this).addClass('selected');
		$('#p_variant').val(this_variant);
		
	});
	
	$(document).on('click', '.photo_cmd', function() {
					
		var this_cmd = $(this).data('cmd');
		if (this_cmd == 'rotate_b90') {
			cropper.rotate(-90);
		}
		if (this_cmd == 'rotate_t90') {
			cropper.rotate(90);
		}
		if (this_cmd == 'zoom_in') {
			cropper.zoom(0.1);
		}
		if (this_cmd == 'zoom_out') {
			cropper.zoom(-0.1);
		}
					
	});
	
	$(document).on('change', '#p_start_form', function() {
		
			var form_data = new FormData();
			form_data.append('action', 'upload');
			form_data.append('image', $('#p_image')[0].files[0]);
			
			$.ajax({
				
				url: $('#p_start_form').attr('action'),
				type: 'post',
				data: form_data,
				dataType: 'json',
				cache: false,
				processData: false,
				contentType: false,
				beforeSend: function() {
					$('.col_right').addClass('loading');
				},
				success: function(response) {
					
					if (response.status == 'ok') {
						
						$('#p_start_form').html(response.text);
						
						/* Cropper */
						cropper = new Cropper($('#preview_photo')[0], {
							
							viewMode: 1,
							dragMode: 'move',
							aspectRatio: 0.7,
							autoCropArea: 0.65,
							restore: false,
							guides: true,
							center: true,
							highlight: true,
							cropBoxMovable: false,
							cropBoxResizable: false,
							toggleDragModeOnDblclick: false,
							ready: function(event) {
								update_fields(event.target.cropper);
							},
							zoom: function(event) {
								update_fields(event.target.cropper);
							},
							crop: function(event) {
								
								var img = $('#image')[0];
								update_fields(event.target.cropper);
							
							}
							
						});
												
					}
					
					setTimeout(function() {
						$('.col_right').removeClass('loading');
					}, 1000);
					
				}
				
			});
		
	});
	
	$(document).off('click', '#p_image_select').on('click', '#p_image_select', function() {
		
		$('#p_image').click();
		return;
		
	});
	
});