var ChartColor = ["#5D62B4", "#54C3BE", "#EF726F", "#F9C446", "rgb(93.0, 98.0, 180.0)", "#21B7EC", "#04BCCC"];
var primaryColor = getComputedStyle(document.body).getPropertyValue('--primary');
var secondaryColor = getComputedStyle(document.body).getPropertyValue('--secondary');
var successColor = getComputedStyle(document.body).getPropertyValue('--success');
var warningColor = getComputedStyle(document.body).getPropertyValue('--warning');
var dangerColor = getComputedStyle(document.body).getPropertyValue('--danger');
var infoColor = getComputedStyle(document.body).getPropertyValue('--info');
var darkColor = getComputedStyle(document.body).getPropertyValue('--dark');
var lightColor = getComputedStyle(document.body).getPropertyValue('--light');

jQuery(function($) {
	
	$(document).ready(function() {
		
		$('.select2').select2();
		
		$(document).on('change', 'input[name=select_all]', function() {
			
			if ($(this).is(':checked')) {
				
				$('.table').find('input[type=checkbox]').each(function() {
					$(this).attr('checked', 'checked');
				});
				
			}
			else {

				$('.table').find('input[type=checkbox]').each(function() {
					$(this).removeAttr('checked');
				});

			}
			
		});
		
		$(document).on('click', '.delete_row', function() {
		
			var this_row = $(this).data('row');
			$('.row.' + this_row).remove();
			return;
		
		});
		
		$(document).on('click', '.add_row', function() {
			
			var this_row = $(this).data('row');
			var len = $('.' + this_row).length;
			var this_tpl = $(this).data('tpl');
			var this_html = '<div class="row ' + this_row + len + ' ' + this_row + '">' + $('#' + this_tpl).html() + '</div>';
			this_html = this_html.replace('row_experience0', this_row + len);
			this_html = this_html.replace('row_education0', this_row + len);
			this_html = this_html.replace('row_service0', this_row + len);
			this_html = this_html.replace('s2', 'select2');
			$(this_html).insertAfter($('.' + this_row).last());
			$('.select2').select2();
			return;
			
		});
		
		if ($('#show_tab').length) {
			
			var show_tab = $('#show_tab').val();
			$('.show_card').each(function() {
				
				if ($(this).data('card') == show_tab) {
					
					$(this).click();
					return;
				
				}
				
			});
			
		}
		
		function load_cities(country_id, elm) {

			$.ajax({
		
				url: $('#ajax_url').val(),
				type: 'post',
				data: 'action=load_cities&country_id=' + country_id,
				dataType: 'json',
				beforeSend: function() {
					$(elm).attr('disabled', 'disabled');
				},
				success: function(response) {
					
					if (response.status == 'error') {
						alert(response.msg);
					}
					if (response.status == 'ok') {
						
						$(elm).removeAttr('disabled');
						$(elm).html(response.html);
						
					}
					
				}
		
			});
			
		}
		
		$(document).on('change', '.load_cities', function() {
			
			load_cities($('.load_cities').val(), $('select[name=city_id]'));
			return;
			
		});
		$(document).on('keyup', '.load_cities', function() {
			$('.load_cities').change();
		});
		
		$(document).on('click', 'a.confirm', function() {
			
			var this_confirm = $(this).data('confirm');
			if (!confirm(this_confirm)) {
				return false;
			}
			
			return true;
			
		});
		
	});
});

(function($) {
  'use strict';
  $(function() {
    var body = $('body');
    var contentWrapper = $('.content-wrapper');
    var scroller = $('.container-scroller');
    var footer = $('.footer');
    var sidebar = $('.sidebar');
	
	$(document).on('click', '.show_card', function() {
		
		var this_card = $(this).data('card');
		$('.card-body.dynamic').hide();
		$('.card-body.dynamic.' + this_card).slideToggle();
		$('.btn-tabs').removeClass('active');
		$(this).addClass('active');
		return;
		
	});

    //Add active class to nav-link based on url dynamically
    //Active class can be hard coded directly in html file also as required

    function addActiveClass(element) {
      if (current === "") {
        //for root url
        if (element.attr('href').indexOf("index.html") !== -1) {
          element.parents('.nav-item').last().addClass('active');
          if (element.parents('.sub-menu').length) {
            element.closest('.collapse').addClass('show');
            element.addClass('active');
          }
        }
      } else {
        //for other url
        if (element.attr('href').indexOf(current) !== -1) {
          element.parents('.nav-item').last().addClass('active');
          if (element.parents('.sub-menu').length) {
            element.closest('.collapse').addClass('show');
            element.addClass('active');
          }
          if (element.parents('.submenu-item').length) {
            element.addClass('active');
          }
        }
      }
    }

    var current = location.pathname.split("/").slice(-1)[0].replace(/^\/|\/$/g, '');
    $('.nav li a', sidebar).each(function() {
      var $this = $(this);
      //addActiveClass($this);
    })

    $('.horizontal-menu .nav li a').each(function() {
      var $this = $(this);
      //addActiveClass($this);
    })

    //Close other submenu in sidebar on opening any

    sidebar.on('show.bs.collapse', '.collapse', function() {
      sidebar.find('.collapse.show').collapse('hide');
    });


    //Change sidebar and content-wrapper height
    applyStyles();

    function applyStyles() {
      //Applying perfect scrollbar
      if (!body.hasClass("rtl")) {
        if (body.hasClass("sidebar-fixed")) {
          var fixedSidebarScroll = new PerfectScrollbar('#sidebar .nav');
        }
      }
    }

    $('[data-toggle="minimize"]').on("click", function() {
      if ((body.hasClass('sidebar-toggle-display')) || (body.hasClass('sidebar-absolute'))) {
        body.toggleClass('sidebar-hidden');
      } else {
        body.toggleClass('sidebar-icon-only');
      }
    });

    //checkbox and radios
    $(".form-check label,.form-radio label").append('<i class="input-helper"></i>');

    //fullscreen
    $("#fullscreen-button").on("click", function toggleFullScreen() {
      if ((document.fullScreenElement !== undefined && document.fullScreenElement === null) || (document.msFullscreenElement !== undefined && document.msFullscreenElement === null) || (document.mozFullScreen !== undefined && !document.mozFullScreen) || (document.webkitIsFullScreen !== undefined && !document.webkitIsFullScreen)) {
        if (document.documentElement.requestFullScreen) {
          document.documentElement.requestFullScreen();
        } else if (document.documentElement.mozRequestFullScreen) {
          document.documentElement.mozRequestFullScreen();
        } else if (document.documentElement.webkitRequestFullScreen) {
          document.documentElement.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);
        } else if (document.documentElement.msRequestFullscreen) {
          document.documentElement.msRequestFullscreen();
        }
      } else {
        if (document.cancelFullScreen) {
          document.cancelFullScreen();
        } else if (document.mozCancelFullScreen) {
          document.mozCancelFullScreen();
        } else if (document.webkitCancelFullScreen) {
          document.webkitCancelFullScreen();
        } else if (document.msExitFullscreen) {
          document.msExitFullscreen();
        }
      }
    })
    if ($.cookie('purple-free-banner')!="true") {
      document.querySelector('#proBanner').classList.add('d-flex');
      document.querySelector('.navbar').classList.remove('fixed-top');
    }
    else {
      document.querySelector('#proBanner').classList.add('d-none');
      document.querySelector('.navbar').classList.add('fixed-top');
    }
    
    if ($( ".navbar" ).hasClass( "fixed-top" )) {
      document.querySelector('.page-body-wrapper').classList.remove('pt-0');
      document.querySelector('.navbar').classList.remove('pt-5');
    }
    else {
      document.querySelector('.page-body-wrapper').classList.add('pt-0');
      document.querySelector('.navbar').classList.add('pt-5');
      document.querySelector('.navbar').classList.add('mt-3');
      
    }
    document.querySelector('#bannerClose').addEventListener('click',function() {
      document.querySelector('#proBanner').classList.add('d-none');
      document.querySelector('#proBanner').classList.remove('d-flex');
      document.querySelector('.navbar').classList.remove('pt-5');
      document.querySelector('.navbar').classList.add('fixed-top');
      document.querySelector('.page-body-wrapper').classList.add('proBanner-padding-top');
      document.querySelector('.navbar').classList.remove('mt-3');
      var date = new Date();
      date.setTime(date.getTime() + 24 * 60 * 60 * 1000); 
      $.cookie('purple-free-banner', "true", { expires: date });
    });
  });
})(jQuery);