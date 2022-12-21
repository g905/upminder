jQuery(function($) {
	$(document).ready(function() {
		
		var mentorSearchForm = $('#mentorSearch');
		var selectedCat;
		var loadedTags = false;

		$(document).on('change', '.sortList', function() {
			
			$('input[name=sort]').val($(this).val());
			mentorSearchForm.change();
			return;
			
		});
		
		$(document).on('click', '.resetFilters', function() {
			
			selectedTag = 0;
			loadedTags = false;

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
		
		$(document).on('click', '#searchKey', function() {
			
			$(this).val('');
			return;
			
		});
		
		var use = $('#searchKey');
		
		$(document).off('keyup', '#searchKey').on('keyup', '#searchKey1', function() {
			
			var use = $('#searchKey1');

			selectedCat = null;
			loadedTags = false;
			$('input[name=astag]').val('');
			
			if (use.val().length >= 3) {
				
				loadedTags = false;
				$('.tag_block').hide();

				$.ajax({
					
					url: '/mentors',
					type: 'post',
					data: mentorSearchForm.serialize(),
					dataType: 'json',
					beforeSend: function() {
						
						$('#searchKey').removeClass('br');
						$('.list_results').remove();
						
					},
					success: function(response) {
	
						if (response.status == 'ok') {

							$('#searchKey').addClass('br');
							$('.keysList').prepend(response.list);
							$('.keysList').addClass('opened');

						}
						
					}
					
				});
				
			}
			
		});
		
		$(document).off('keyup', '#searchKey').on('keyup', '#searchKey', function() {
			
			selectedCat = null;
			loadedTags = false;
			$('input[name=astag]').val('');
			
			if (use.val().length >= 3) {
				
				loadedTags = false;
				$('.tag_block').hide();

				$.ajax({
					
					url: '/mentors',
					type: 'post',
					data: mentorSearchForm.serialize(),
					dataType: 'json',
					beforeSend: function() {
						
						$('#searchKey').removeClass('br');
						$('.list_results').remove();
						
					},
					success: function(response) {
	
						if (response.status == 'ok') {

							$('#searchKey').addClass('br');
							$('.keysList').prepend(response.list);
							$('.keysList').addClass('opened');

						}
						
					}
					
				});
				
			}
			else {
				$('.list_results').remove();
			}
			
		});
		
		$(document).off('change', mentorSearchForm).on('change', mentorSearchForm, function() {
			
			$.ajax({
				
				url: '/mentors',
				type: 'post',
				data: mentorSearchForm.serialize(),
				dataType: 'json',
				beforeSend: function() {
					
					$('.hc').text('С чем нужно помочь?');
					$('#searchKey').removeClass('br');
					
				},
				success: function(response) {
					
					if (response.status == 'ok') {
						
						if (response.h2.length > 1) {
							$('.hc').text(response.h2);
						}
						
						if (!$('.keysList').hasClass('opened')) {
							
							$('#searchKey').addClass('br');
							$('.keysList').prepend(response.list);
							$('.keysList').addClass('opened');

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
		
		$(document).off('click', '.selectCat').on('click', '.selectCat', function() {
						
			console.log(' click');
			selectedCat = parseInt($(this).data('id'));
			mentorSearchForm.find('input[name=cat]').val(selectedCat);
			
			if ($(this).hasClass('asTag')) {
				
				if ($(window).width() > 1000) {
					$('#searchKey').val($(this).data('cat'));
				}
				else {
					$('#searchKey1').val($(this).data('cat'));
				}
				
			}
			
			else {
				if ($(window).width() > 1000) {
					$('#searchKey').val($(this).text());
				}
				else {
					$('#searchKey1').val($(this).text());
				}
				
			}
			
			$('.list_results').remove();
			
			if ($(this).hasClass('asTag')) {
				
				var selTag = parseInt($(this).data('tag'));
				mentorSearchForm.find('input[name=astag]').val(selTag);
				
			}
			
			mentorSearchForm.change();
			
			return;
			
		});
		
		/*
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
	
		});
		*/
		
		$(document).on('click', '.removeTag', function() {
			
			$(this).parent().click();
			return;
			
		});
		
		mentorSearchForm.change();
		
	});
});