jQuery(function($) {
	$(document).ready(function() {
		
		var inputKey;
		var selectedCat;
		var selectedTags;
		
		function doSearch(key, hide_absolute) {
			
			inputKey = key;

			$('.selectTag').each(function() {
				
				if ($(this).hasClass('active')) {
					selectedTags += $(this).data('id') + ',';
				}
				
			});
			
			$.ajax({
				
				url: '/mentors',
				type: 'post',
				data: 'key=' + key + '&cat=' + selectedCat + '&tags=' + selectedTags,
				dataType: 'json',
				beforeSend: function() {
					
					$('.searchKey').removeClass('br');
					$('.list_results').remove();
					
				},
				success: function(response) {
					
					if (response.status == 'ok') {
						
						if (!hide_absolute) {
							
							$('#searchKey').addClass('br');
							$('.keysList').prepend(response.list);
						
						}
						
						if (response.mentors) {
							
							$('.nospec').hide();
							$('#count').text(response.count);
							$('.result_list').html(response.mentors);
							
						}
						
					}
					
				}
				
			});
			
		}
		
		$(document).on('keyup', '#searchKey', function() {
			
			if ($(this).val().length >= 3) {
				doSearch($(this).val());
			}
			else {
				
				$('#searchKey').removeClass('br');
				$('.list_results').remove();
				
			}
			
		});
		
		$(document).on('click', '.selectCat', function() {
			
			selectedCat = parseInt($(this).data('id'));
			
			$('#searchKey').val($(this).text());
			$('#searchKey').removeClass('br');
			$('.list_results').remove();
			
			$.ajax({
				
				url: '/mentors',
				type: 'post',
				data: 'cat=' + selectedCat + '&key=' + inputKey,
				dataType: 'json',
				beforeSend: function() {
					$('.tag_block').hide();
				},
				success: function(response) {
					
					if (response.status == 'ok') {
						
						$('.tag_block').html(response.tags);
						$('.tag_block').show();
						
					}
					
				}
				
			});
			
		});
		
		$(document).on('click', '.selectTag p', function() {
			
			if ($(this).parent().hasClass('active')) {
				
				$(this).parent().removeClass('active');
				$(this).parent().find('.removeTag').remove();

			}
			else {
				
				$(this).parent().addClass('active');
				$(this).parent().find('.removeTag').remove();
				$(this).append('<a href="javascript:void(0);" class="removeTag"></a>');
				
			}
			
			doSearch(inputKey, true);

			return;
			
		});
		
		$(document).on('click', '.removeTag', function() {
			
			$(this).parent().removeClass('active');
			return;
			
		});
		
	});
});