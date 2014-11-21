function showHidePostFormatField(){    
    jQuery('#normal-sortables>[id*="tw-format-"]').each(function(){
       if(jQuery(this).attr('id').replace("tw","post")===jQuery('#post-formats-select input:radio:checked').attr('id').replace('image', 'gallery')){
           jQuery(this).css('display', 'block');
       } else {
           jQuery(this).css('display', 'none');
       }
    });    
}

jQuery(function(){
    setTimeout(function(){
        jQuery('#blog_meta_settings .type_select>[name="show_filter"],#port_meta_settings .type_select>[name="show_filter"]').bind('change',function(){
            if(jQuery(this).val()==='true'){
                jQuery(this).closest('#show_filter').siblings('#filter_type').show();
            }else{
                jQuery(this).closest('#show_filter').siblings('#filter_type').hide();
            }
        }).change();
    },100);
    
    
    /* Date Picker */
    if(jQuery('input.need-date').hasClass('need-date')){
        jQuery('input.need-date').each(function(){
            var $currCalendarField=jQuery(this);
            $currCalendarField.datepicker({
                dateFormat:'dd-mm-yy',
                setDate:$currCalendarField.val()
            });
        });
    }
    
    /* Category Reseter */
    function blogCatReseter($currentCategorySelector, $currentSaveTo){
        var $currentCategoryList = $currentCategorySelector.siblings('.category-list-container');
        var $currentSaveToArray=$currentSaveTo.val().split(',');
        $currentCategorySelector.find('option').show();
        $currentCategoryList.html('');
        for (var i = 0, length=$currentSaveToArray.length ; i<length; i++){
            if($currentSaveToArray[i]!==''){
                $currentCategoryList.append('<div class="category-list-item clearfix" data-value="'+$currentSaveToArray[i]+'"><div class="name">'+$currentCategorySelector.find('option[value="'+$currentSaveToArray[i]+'"]').hide().text()+'</div><div class="actions"><a href="#" class="action-delete">X</a></div></div>');
            }
        }
        $currentCategoryList.find(".category-list-item .action-delete").unbind('click').bind('click',function(e){e.preventDefault();
            var $oldArray=$currentSaveTo.val().split(',');
            var $newArray=[];
            var $delValue=jQuery(this).closest(".category-list-item").attr('data-value');
            jQuery(this).closest(".category-list-item").remove();
            for (var i = 0, length=$oldArray.length ; i<length; i++){
                if($oldArray[i]!==$delValue && $oldArray[i]!==''){
                    $newArray.push($oldArray[i]);
                }
            }
            $currentSaveTo.val($newArray.join(','));
            blogCatReseter($currentCategorySelector, $currentSaveTo)
        });
    }
    jQuery('.type_select>[name="blog_page_category"],.type_select>[name="port_page_category"]').each(function(){
        var $currentCategorySelector = jQuery(this);
        jQuery($currentCategorySelector).after('<div class="category-list-container" />');
        var $currentCategoryList = $currentCategorySelector.siblings('.category-list-container');
        var $currentSaveTo       = jQuery('[name="'+$currentCategorySelector.attr('name')+'_ids"]');
        $currentCategorySelector.change(function(){
            var $val  = $currentCategorySelector.val();
            var $noProblem = true;
            $currentCategoryList.children(".category-list-item").each(function(){
                if(jQuery(this).attr('data-value') == $val) {
                    $noProblem = false;
                }
            });
            if($val == 0 || $val == '0'){
                return false;
            }else{
                $currentCategorySelector.children('option[value="0"]').attr('selected','selected').siblings().removeAttr('selected');
                $currentCategorySelector.change();
                if($noProblem){
                    var $currentSaveToArray = $currentSaveTo.val().split(',');
                    if($currentSaveToArray.indexOf($val)<0){
                        if($currentSaveToArray[0]===''){
                            $currentSaveToArray[0]=$val;
                        }else{
                            $currentSaveToArray.push($val);
                        }
                        $currentSaveTo.val($currentSaveToArray.join(','));
                    }
                    blogCatReseter($currentCategorySelector,$currentSaveTo);
                }
            }
        });
        blogCatReseter($currentCategorySelector, $currentSaveTo);
    });
		
    /* Color Picker */
    jQuery(".color_picker").ColorPicker({
        onShow: function (colpkr) {
            jQuery(colpkr).fadeIn(500);
            return false;
        },
        onHide: function (colpkr) {
            jQuery(colpkr).fadeOut(500);
            return false;
        },
        onChange: function (hsb, hex, rgb, el) {
            jQuery(el).parent().find('.color_picker_inner').css('backgroundColor', '#' + hex);
            jQuery(el).parent().find('.color_picker_value').val('#' + hex);
        }
    });

    
    /* Check show hide */
    jQuery('.check-show-hide').change(function() {
        var datashow = jQuery(this).attr('data-show');
        var datahide = jQuery(this).attr('data-hide');
        if(jQuery(this).is(':checked')) {
            jQuery(datashow).fadeIn();
            jQuery(datahide).fadeOut();
        } else {
            jQuery(datashow).fadeOut();
            jQuery(datahide).fadeIn();
        }
    });
    jQuery('.check-show-hide').each(function() {
        jQuery(this).change();
    }); 
    
    
    
    /* Page template */
    var selector = "#page_template";
    var defaultpage = "#page_meta_settings";
    var comingsoon = "#comingsoon_meta_settings";
    var onepage = "#onepage_meta_settings";
    var blogpage = "#blog_meta_settings";
    var portpage = "#port_meta_settings";
    var pagebuilder = "#waves_pagebuilder";
    jQuery(selector).bind('change', function(){
        var template = jQuery(this).val();
        if(template=='page-portfolio.php'){
            jQuery(comingsoon+','+blogpage+','+onepage+','+pagebuilder).fadeOut();
            jQuery(defaultpage+','+portpage).fadeIn();                   
        } else if(template=='template-onepage.php'){
            jQuery(comingsoon+','+blogpage+','+portpage).fadeOut();
            jQuery(defaultpage+','+onepage+','+pagebuilder).fadeIn();                   
        } else if(template=='template-comingsoon.php'){
            jQuery(defaultpage+','+onepage+','+blogpage+','+portpage).fadeOut();
            jQuery(comingsoon+','+pagebuilder).fadeIn();                   
        } else if(template=='page-blog.php'){
            jQuery(comingsoon+','+onepage+','+pagebuilder+','+portpage).fadeOut();
            jQuery(blogpage).fadeIn();                   
        } else {
            jQuery(defaultpage+','+pagebuilder).fadeIn();
            jQuery(comingsoon+','+onepage+','+blogpage+','+portpage).fadeOut(); 
        }
    });    
    jQuery(selector).change();
            
    /* Select options */            
    jQuery(".tw-metaboxes select").each(function(){
        $this = jQuery(this);
        if( $this.attr("data-value") != "" ){
            $this.val($this.attr("data-value"));
        }
    });
    

    jQuery(".tw-metaboxes tr.header_type select").change(function(){
        var $this = jQuery(this);
        var $title = ".tw-metaboxes tr.subtitle, .tw-metaboxes tr.title_bg_image, .tw-metaboxes tr.title_prllx, .tw-metaboxes tr.bg_dark";
        if( $this.val() == "subtitle" ){
            jQuery($title).fadeIn();
            jQuery(".tw-metaboxes tr.slider_id").fadeOut();
            jQuery(".tw-metaboxes tr.googlemap").fadeOut();
        } else if($this.val() == "slider") {
            jQuery(".tw-metaboxes tr.slider_id").fadeIn();
            jQuery($title).fadeOut();
            jQuery(".tw-metaboxes tr.googlemap").fadeOut();
        } else if($this.val() == "map") {
            jQuery(".tw-metaboxes tr.googlemap").fadeIn();
            jQuery(".tw-metaboxes tr.slider_id").fadeOut();
            jQuery($title).fadeOut();
        } else {
            jQuery(".tw-metaboxes tr.googlemap").fadeOut();
            jQuery(".tw-metaboxes tr.slider_id").fadeOut();
            jQuery($title).fadeOut();
        }
    });
    jQuery(".tw-metaboxes tr.header_type select").change();
    
    jQuery(".tw-metaboxes tr.theme_layout select").change(function(){
        var $this = jQuery(this);
        var $title = ".tw-metaboxes tr.bg_color, .tw-metaboxes tr.bg_image, .tw-metaboxes tr.bg_image_repeat, .tw-metaboxes tr.margin_top_bottom";
        if( $this.val() == "boxed" ){
            jQuery($title).fadeIn();
        } else {
            jQuery($title).fadeOut();
        }
    });
    jQuery(".tw-metaboxes tr.theme_layout select").change();
    // One page 
    jQuery("#onepage_meta_settings tr.onepage_header select").change(function(){
        var $this = jQuery(this);
        jQuery('#onepage_meta_settings tr.onepage_slider,#onepage_meta_settings tr.gallery_image_ids,#onepage_meta_settings tr.onepage_video_m4v').stop().fadeOut();
        switch($this.val()){
            case "slide":{
                jQuery('#onepage_meta_settings tr.gallery_image_ids').stop().fadeIn();
                break;
            }
            case "slideshow":{
                jQuery('#onepage_meta_settings tr.onepage_slider').stop().fadeIn();
                break;
            }
            case "video":{
                jQuery('#onepage_meta_settings tr.onepage_video_m4v').stop().fadeIn();
                break;
            }
        }
    });
    jQuery("#onepage_meta_settings tr.onepage_header select").change();
    
    /* Page layout options */
    jQuery(".tw-metaboxes .type_layout a").each(function(){
        $val = jQuery(".tw-metaboxes .type_layout input").val();
        $this = jQuery(this);
        if( $this.data("value") == $val ){
            $this.addClass("active");
        }
    });
    jQuery(".tw-metaboxes .type_layout a").click(function(){
        jQuery(".tw-metaboxes .type_layout a").removeClass("active");
        $val = jQuery(this).data('value');
        jQuery(".tw-metaboxes .type_layout input").val($val);
        jQuery(this).addClass("active");
    })
    
    
    
    /* Post format */
    showHidePostFormatField();
    jQuery('#post-formats-select input').change(showHidePostFormatField);
    
    
    /* Gallery */
    
    var frame;
    var images = waves_script_data.image_ids;
    var selection = loadImages(images);

    jQuery('#gallery_images_upload').on('click', function(e) {
            e.preventDefault();

            // Set options for 1st frame render
            var options = {
                    title: waves_script_data.label_create,
                    state: 'gallery-edit',
                    frame: 'post',
                    selection: selection
            };

            // Check if frame or gallery already exist
            if( frame || selection ) {
                    options['title'] = waves_script_data.label_edit;
            }

            frame = wp.media(options).open();

            // Tweak views
            frame.menu.get('view').unset('cancel');
            frame.menu.get('view').unset('separateCancel');
            frame.menu.get('view').get('gallery-edit').el.innerHTML = waves_script_data.label_edit;
            frame.content.get('view').sidebar.unset('gallery'); // Hide Gallery Settings in sidebar

            // When we are editing a gallery
            overrideGalleryInsert();
            frame.on( 'toolbar:render:gallery-edit', function() {
            overrideGalleryInsert();
            });

            frame.on( 'content:render:browse', function( browser ) {
                if ( !browser ) return;
                // Hide Gallery Setting in sidebar
                browser.sidebar.on('ready', function(){
                    browser.sidebar.unset('gallery');
                });
                // Hide filter/search as they don't work 
                    browser.toolbar.on('ready', function(){ 
                            if(browser.toolbar.controller._state == 'gallery-library'){ 
                                    browser.toolbar.$el.hide(); 
                            } 
                    }); 
            });

            // All images removed
            frame.state().get('library').on( 'remove', function() {
                var models = frame.state().get('library');
                    if(models.length == 0){
                        selection = false;
                        jQuery.post(ajaxurl, { 
                            ids: '',
                            action: 'themewaves_save_images',
                            post_id: waves_script_data.post_id,
                            nonce: waves_script_data.nonce 
                        });
                    }
            });

            // Override insert button
            function overrideGalleryInsert() {
                    frame.toolbar.get('view').set({
                            insert: {
                                    style: 'primary',
                                    text: waves_script_data.label_save,

                                    click: function() {                                            
                                            var models = frame.state().get('library'),
                                                ids = '';

                                            models.each( function( attachment ) {
                                                ids += attachment.id + ','
                                            });

                                            this.el.innerHTML = waves_script_data.label_saving;
                                            
                                            jQuery.ajax({
                                                    type: 'POST',
                                                    url: ajaxurl,
                                                    data: { 
                                                        ids: ids, 
                                                        action: 'themewaves_save_images', 
                                                        post_id: waves_script_data.post_id, 
                                                        nonce: waves_script_data.nonce 
                                                    },
                                                    success: function(){
                                                        selection = loadImages(ids);
                                                        jQuery('input#gallery_image_ids').val( ids );
                                                        frame.close();
                                                    },
                                                    dataType: 'html'
                                            }).done( function( data ) {
                                                    jQuery('.gallery-thumbs').html( data );
                                            }); 
                                    }
                            }
                    });
            }
        });
					
        // Load images
        function loadImages(images) {
                if( images ){
                    var shortcode = new wp.shortcode({
                        tag:    'gallery',
                        attrs:   { ids: images },
                        type:   'single'
                    });

                    var attachments = wp.media.gallery.attachments( shortcode );

                    var selection = new wp.media.model.Selection( attachments.models, {
                            props:    attachments.props.toJSON(),
                            multiple: true
                    });

                    selection.gallery = attachments.gallery;

                    // Fetch the query's attachments, and then break ties from the
                    // query to allow for sorting.
                    selection.more().done( function() {
                            // Break ties with the query.
                            selection.props.set({ query: false });
                            selection.unmirror();
                            selection.props.unset('orderby');
                    });

                    return selection;
                }
                return false;
        }
});

function browseimage(id){
    var elementId = id;
    window.original_send_to_editor = window.send_to_editor;
    window.custom_editor = true;    
    window.send_to_editor = function(html){
        if (elementId != undefined) {
            jQuery(html).find('img').each(function(){
                    var imgurl = jQuery(this).attr('src');
                    jQuery('input[name="'+elementId+'"]').val(imgurl);
                    return;
            });
        } else {
            window.original_send_to_editor(html);
        }
        elementId = undefined;
    };
    wp.media.editor.open();
}

window.original_send_to_editor = window.send_to_editor;
window.custom_editor = true;