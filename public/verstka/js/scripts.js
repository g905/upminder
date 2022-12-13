jQuery(function($) {
	$(document).ready(function() {
		
		var mentorSearchForm = $('#mentorSearch');
		var selectedCat;
		var loadedTags = false;
		var isTyping = true;
		
		$(document).on('change', '.sortList', function() {
			
			$('input[name=sort]').val($(this).val());
			mentorSearchForm.change();
			return;
			
		});
		
		$(document).on('click', '.resetFilters', function() {
			
			selectedTag = 0;
			loadedTags = false;
			isTyping = true;
			
			$('input[name=short]').val('id');
			$('input[name=cat]').val('');
			$('input[name=astag]').val('');
			
			$('.tag_block').html('');
			$('.tag_block').hide();
			$('#searchKey').val('');
			
			mentorSearchForm.change();
			
		});
		
		$(document).on('click', '.asTag', function() {
			
			/*
			var thisId = $(this).data('id');
			var thisClass = 'catAsTag_' + thisId;
			$('.' + thisClass).remove();
			mentorSearchForm.prepend('<input type="checkbox" name="tags[]" value="' + thisId + '" class="' + thisClass + '">');
			
			mentorSearchForm.change();
			return;
			*/
			
		});
		
		$(document).on('change', '.updateForm', function() {
			
			mentorSearchForm.change();
			return;
			
		});
		
		$(document).on('keyup', '#searchKey', function() {
			
			selectedCat = null;
			loadedTags = false;
			$('input[name=astag]').val('');
			
			if ($(this).val().length >= 3) {
				
				isTyping = false;
				//mentorSearchForm.change();
				return;
				
			}
			
		});
		
		$(document).off('change', mentorSearchForm).on('change', mentorSearchForm, function() {
			
			$.ajax({
				
				url: '/mentors',
				type: 'post',
				data: mentorSearchForm.serialize(),
				dataType: 'json',
				beforeSend: function() {
					
					$('#searchKey').removeClass('br');
					$('.list_results').remove();
					//$('.tag_block').hide();
					
				},
				success: function(response) {
					
					if (response.status == 'ok') {
						
						if (!selectedCat) {
							
							$('#searchKey').addClass('br');
							$('.keysList').prepend(response.list);

						}
						
						if (response.tags && !loadedTags) {
							
							$('.tag_block').html(response.tags);
							$('.tag_block').show();
							loadedTags = true;
							
							if (response.tags.indexOf('checked') > 0) {
								mentorSearchForm.change();
							}
						
						}
																	
						$('.nospec').hide();
						$('#count').text(response.count);
						$('.result_list').html(response.mentors);
						
						if (response.count == 0) {
							$('.nospec').show();
						}
						
					}
					
				}
				
			});
			
		});
		
		$(document).on('click', '.selectCat', function() {
						
			selectedCat = parseInt($(this).data('id'));
			mentorSearchForm.find('input[name=cat]').val(selectedCat);
			$('#searchKey').val($(this).text());
			
			if ($(this).hasClass('asTag')) {
				
				var selTag = parseInt($(this).data('tag'));
				mentorSearchForm.find('input[name=astag]').val(selTag);
				
			}
			
			mentorSearchForm.change();
			
			return;
			
		});
		
		$(document).on('click', '.selectTag label', function() {
			
			/*
			if ($(this).parent().hasClass('active')) {
				
				$(this).parent().removeClass('active');
				$(this).parent().find('.removeTag').remove();

			}
			else {
				
				$(this).parent().addClass('active');
				$(this).parent().find('.removeTag').remove();
				$(this).append('<a href="javascript:void(0);" class="removeTag"></a>');
				
			}
			*/
			
			return;
			
		});
		
		$(document).on('click', '.removeTag', function() {
			
			$(this).parent().click();
			return;
			
		});
		
		mentorSearchForm.change();
		
	});
});