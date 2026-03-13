jQuery( function ( $ )
{
	
	'use strict';
	// var standerTrigger =$(document).find('#post-format-selector-0');

	 
	//wp.data.subscribe(function () { console.log( wp.data.select( 'core/editor' ).getEditedPostAttribute( 'format' ))});
	$(document).on('change', 'select[id*="post-format"]',function(){ 
		var prefix  = '_kp_';
		var $meta_boxes = $('[id^="'+ prefix +'meta_box_post_format_"]').slideUp();
		$('#' + prefix +  'meta_box_post_format_' + $( this ).val()).slideDown();	
	});
	$(document).on('load', 'select[id*="post-format"]',function(){ 
		alert('value1'  +$(this).val);
	});
	process_post_format();
	$('.rwmb-image-set .rwmb-image-set-inner ._kp_page_sidebar_position').click(function() {
		var selected_val = $(this).attr('data-value');
		if(selected_val == 'none'){			
			$("#_kp_page_sidebar_widget").closest('.rwmb-field').hide();
		}else{
			$("#_kp_page_sidebar_widget").closest('.rwmb-field').show();
		}
		
	});
	
	/*
	* Show or hide post formate metabox
	*/
	function process_post_format() {
		var prefix  = '_kp_';
		var $cbxPostFormats = $( 'input[name=post_format]', '#post-formats-select' );
		var $meta_boxes = $('[id^="'+ prefix +'meta_box_post_format_"]').slideUp();
		$cbxPostFormats.change(function(){
			$meta_boxes.slideUp();
			$('#' + prefix +  'meta_box_post_format_' + $( this ).val()).slideDown();
		});

		$cbxPostFormats.filter( ':checked' ).trigger( 'change' );

		$( 'body' ).on( 'change', '.checkbox-toggle input', function()
		{
			var $this = $( this ),
				$toggle = $this.closest( '.checkbox-toggle' ),
				action;
			if ( !$toggle.hasClass( 'reverse' ) )
				action = $this.is( ':checked' ) ? 'slideDown' : 'slideUp';
			else
				action = $this.is( ':checked' ) ? 'slideUp' : 'slideDown';

			$toggle.next()[action]();
		} );
		$( '.checkbox-toggle input' ).trigger( 'change' );
	}
	
	/* Color Picker */
    if( $('.kapee-color-box').length > 0 ) {
        $('.kapee-color-box').wpColorPicker();
    }
	 if( $('.kapee-image-clear').length > 0 ) {
		 var attachement_id = $('.kapee-attachment-id').val();
		 if(attachement_id == ''){
			 $('.kapee-image-clear').hide();
		 }
        $('.kapee-image-clear').click(function(){
			
			var image_url = $(this).attr('data-src');
			
			$('.kapee-attr-img').attr('src',image_url);
            $('.kapee-selected-attr-img').val('');
            $('.kapee-attachment-id').val('');
			$('.kapee-image-clear').hide('slow');
		});
    }
	
	/* Upload media image */
	$(document).on('click','.kapee-image-upload',function(e){
		e.preventDefault();
		var image = wp.media({ 
            title: 'Upload Image',
            multiple: false
        }).open()
        .on('select', function(e){
            var uploaded_image = image.state().get('selection').first();
            var image_url,attachment;
			attachment = uploaded_image.toJSON();
			var attachment_id = attachment.id ? attachment.id : '';
            if(typeof uploaded_image.toJSON().sizes.thumbnail === 'undefined') {
                image_url=attachment.url;
                image_url=attachment.url;
            }else{
                image_url = attachment.sizes.thumbnail.url;
            }
            $('.kapee-attr-img').attr('src',image_url);
            $('.kapee-selected-attr-img').val(image_url);
            $('.kapee-attachment-id').val(attachment_id);
			$('.kapee-image-clear').show('slow');
		
        });
	});
	
	/* Select Featured Post */
	$( document ).on( 'click', '.kapee-select-term-featured', function() {

		var current_obj = $(this);
		var term_id 	= $(this).attr('data-term-id');
		var feat_val 	= 1;
		
		if (current_obj.hasClass("dashicons-star-filled")){
			feat_val 	= 0;
		}

		var data = {
							action		: 'kapee_update_featured_term',
							term_id		: term_id,
							is_feat		: feat_val
						};
			$.post(ajaxurl,data,function(response) {
				var result = $.parseJSON(response);
				
				if( result.success == 1 ) {
					
					if (feat_val == 0) {
						current_obj.removeClass("dashicons-star-filled").addClass("dashicons-star-empty");
					}else{
						current_obj.removeClass("dashicons-star-empty").addClass("dashicons-star-filled");
					}
					
				}
        	});
	});
	
	$( document ).on( 'click', '.kapee-select-term-category-featured', function() {

		var current_obj = $(this);
		var term_id 	= $(this).attr('data-term-id');
		var feat_val 	= 1;
		
		if (current_obj.hasClass("dashicons-star-filled")){
			feat_val 	= 0;
		}

		var data = {
							action		: 'kapee_update_featured_termcat',
							term_id		: term_id,
							is_feat		: feat_val
						};
			$.post(ajaxurl,data,function(response) {
				var result = $.parseJSON(response);
				
				if( result.success == 1 ) {
					
					if (feat_val == 0) {
						current_obj.removeClass("dashicons-star-filled").addClass("dashicons-star-empty");
					}else{
						current_obj.removeClass("dashicons-star-empty").addClass("dashicons-star-filled");
					}
					
				}
        	});
	});
	
} );
jQuery(window).on("load", function(){
    var sidebar_position = $('.rwmb-image-set #_kp_page_sidebar_position').val();
	if(sidebar_position == 'none'){	
		$("#_kp_page_sidebar_widget").closest('.rwmb-field').hide();
	}
});

/* Import Demo*/
jQuery(document).on('click', '.kapee-cnt-wrap .theme', function(e) {

	var demo_name,demo_deails,modalcontainer;
	demo_name = jQuery(this).attr('data-name');
	modalcontainer = jQuery(this).closest('.kapee-import-demo-popup');
	jQuery('.kapee-import-demo-popup .kapee-install-options-section p span').removeAttr('style').removeAttr('class');
	var data = {
					action      	: 'get_demo_datails',
					demo_name   : demo_name
				};
				
	jQuery.post(ajaxurl,data,function(response) {
		console.log(response);
		var demo_deails = jQuery.parseJSON(response);
		jQuery('.kapee-import-demo-popup .demo-img img').attr('src',demo_deails.imgurl);
		jQuery('.kapee-import-demo-popup #kapee-install-options .demo-title').html(demo_deails.title);
		jQuery('.kapee-import-demo-popup #kapee-install-options #kapee-import-demo').attr('data-demo',demo_name);
		jQuery('.kapee-import-demo-popup #kapee-install-options .live-site').attr('href',demo_deails.preview_link);
		jQuery.magnificPopup.open({
			items: {
				src: '.kapee-import-demo-popup'
			},
			type: 'inline',
			mainClass: 'mfp-with-zoom',
			zoom: {
				enabled: true,
				duration: 300
			},
		});
	});
	
	
});
jQuery(function($) {
	
	$(document).on('click', '.kapee-close-popup', function(e) {
		$.magnificPopup.close();
	})
	/* Process message*/
	function alertLeavePage(e) {       
        e.returnValue = shopdal_demo_params.bindmessage;
        return dialogText;
    }

    function addAlertLeavePage() {
        $('#kapee-import-demo').attr('disabled', 'disabled');
        $(window).bind('beforeunload', alertLeavePage);
    }

    function removeAlertLeavePage() {
        $('#kapee-import-demo').removeAttr('disabled');
        $(window).unbind('beforeunload', alertLeavePage);
    }
	
	/* Process to import*/
	$(document).on('click', '#kapee-import-demo', function(e) {
		addAlertLeavePage();
		var current_demo = $(this).attr('data-demo'),options,
		options = {'demo':current_demo,'post_content':1,'slider':1,'widgets':1,'settings':1};
		if (options.demo) {
           // showImportMessage(demo, '');
            kapee_import_post_content(options);
        }
	});
	function kapee_import_post_content(options){
		if (!options.demo) {
			removeAlertLeavePage();
            return;
        }
		var module;
		if (options.post_content) {
			module = 'post_content';
			$('#'+module).addClass('spinner').css("visibility", "visible");
			data = {'action': 'kapee_import_'+module, 'current_demo': options.demo};
			$.ajax({
						url : ajaxurl,
						type : 'post',
						data : data,
						success : function( response ) {
							console.log(response);
							$('#'+module).removeClass("spinner");
							if( response == 'success'){				
								$('#'+module).addClass("dashicons dashicons-yes");
							}else{
								$('#'+module).addClass("dashicons dashicons-no");
							}
							kapee_import_slider(options);
						},
						error : function(response){
							$('#'+module).removeClass("spinner");
							$('#'+module).addClass("dashicons dashicons-no");
							kapee_import_slider(options);
						}
					});
		}else{
			kapee_import_slider(options);
		}
	}
	function kapee_import_slider(options){
		if (!options.demo) {
			removeAlertLeavePage();
            return;
        }
		var module;
		if (options.slider) {
			module = 'slider';
			$('#'+module).addClass('spinner').css("visibility", "visible");
			data = {'action': 'kapee_import_'+module, 'current_demo': options.demo};
			$.ajax({
						url : ajaxurl,
						type : 'post',
						data : data,
						success : function( response ) {
							console.log(response);
							$('#'+module).removeClass("spinner");
							if( response == 'success'){				
								$('#'+module).addClass("dashicons dashicons-yes");
							}else{
								$('#'+module).addClass("dashicons dashicons-no");
							}
							kapee_import_widgets(options);
						},
						error : function(response){
							$('#'+module).removeClass("spinner");
							$('#'+module).addClass("dashicons dashicons-no");
							kapee_import_widgets(options);
						}
					});
		}else{
			kapee_import_widgets(options);
		}
	}
	function kapee_import_widgets(options){
		if (!options.demo) {
			removeAlertLeavePage();
            return;
        }
		var module;
		if (options.widgets) {
			module = 'widgets';
			$('#'+module).addClass('spinner').css("visibility", "visible");
			data = {'action': 'kapee_import_'+module, 'current_demo': options.demo};
			$.ajax({
						url : ajaxurl,
						type : 'post',
						data : data,
						success : function( response ) {
							console.log(response);
							$('#'+module).removeClass("spinner");
							if( response == 'success'){				
								$('#'+module).addClass("dashicons dashicons-yes");
							}else{
								$('#'+module).addClass("dashicons dashicons-no");
							}
							kapee_import_settings(options);
						},
						error : function(response){
							$('#'+module).removeClass("spinner");
							$('#'+module).addClass("dashicons dashicons-no");
							kapee_import_settings(options);
						}
					});
		}else{
			kapee_import_settings(options);
		}
	}
	function kapee_import_settings(options){
		if (!options.demo) {
			removeAlertLeavePage();
            return;
        }
		var module;
		if (options.settings) {
			module = 'settings';
			$('#'+module).addClass('spinner').css("visibility", "visible");
			data = {'action': 'kapee_import_'+module, 'current_demo': options.demo};
			$.ajax({
						url : ajaxurl,
						type : 'post',
						data : data,
						success : function( response ) {
							console.log(response);
							$('#'+module).removeClass("spinner");
							if( response == 'success'){				
								$('#'+module).addClass("dashicons dashicons-yes");
							}else{
								$('#'+module).addClass("dashicons dashicons-no");
							}
							kapee_import_completed(options);
						},
						error : function(response){
							$('#'+module).removeClass("spinner");
							$('#'+module).addClass("dashicons dashicons-no");
							kapee_import_completed(options);
						}
					});
		}else{
			kapee_import_completed(options);
		}
	}
	function kapee_import_completed(options){
		$('#import-log').html(shopdal_demo_params.demo_success);
		$('#kapee-import-demo').fadeOut(300, function(){ $(this).remove();});
		 //$('#kapee-import-demo').remove();
		removeAlertLeavePage();
	}
});