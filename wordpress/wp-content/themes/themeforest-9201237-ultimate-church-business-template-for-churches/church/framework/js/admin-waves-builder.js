var $currentContentEditor='content';
var $currentContentEditorInterval=0;
var $pbSavingDone=true;
var $pbSavingLast=0;
var $twBuilderScorollTop=0;
// Reset Content width
jQuery(function(){
    $homeURI = waves_script_data.home_uri;
    $homeURI+='/';
    if($homeURI[$homeURI.length-1]==='/'){$homeURI=$homeURI.substring(0,$homeURI.length-1);}
    twInitSortDragg(jQuery('#pagebuilder-area'),jQuery('#pagebuilder-area'));
    // Click to Add Item
    jQuery('.pb-add-layout').siblings('.data.hidden').find('>.row-container>.data>.custom-field-container [data-name="default_row"]').attr("value","false");
    
    jQuery('.pb-add-layout').click(function(e){e.preventDefault();
        var $curr=jQuery(this);
        var $data=$curr.siblings('.data').html();
        jQuery('.pb-add-layout-conteiner').addClass('loading');
        setTimeout(function(){
            if($curr.attr('data-possition')==='top'){
                jQuery('#pagebuilder-area').prepend($data);
            }else{
                jQuery('#pagebuilder-area').append($data);
            }
            // Sortable Draggable
            twInitSortDragg(jQuery('#pagebuilder-area'),jQuery('#pagebuilder-area'));
            pbSaveData();
            pbInitEvents();
        },100);
    });
    // Check Default Layouts
    jQuery('#pagebuilder-area>.action-container.builder-area>.data>.custom-field-container [data-name="default_layout"]').each(function(){
        jQuery(this).closest('.action-container.builder-area').addClass((jQuery(this).val()==='true'?'default':'additional')+'-layout');
    });
    pbInitEvents();
    pbInitTemplateEvents();
    pbSaveData();
    // Active current Layout
    jQuery('#pagebuilder-area>.row-container>.list>.change-layout>a.active').click();
});
function pbInitTemplateEvents(){
    // Template Action
    jQuery('.template-add').unbind('click').bind('click',function(e){e.preventDefault();
        var $currentTemplateName   = prompt('Template Name?');
        var $currentTemplateContent=jQuery('#pb_content').val();
        if($currentTemplateName===null){
            return false;
        }else if($currentTemplateName!==''){
            jQuery.ajax({
                type: "POST",
                url: ajaxurl,
                data: {
                    'action':'template_add',
                    'template_name':$currentTemplateName,
                    'template_content':$currentTemplateContent
                },
                success: function(response){
                    if(jQuery('.succes',response).text()!==''){
                        jQuery('ul.template-container').append('<li class="template-item"><a class="template-name">'+$currentTemplateName+'</a><span class="template-delete">X</span></li>');
                        pbInitTemplateEvents();
                    }else if(jQuery('.error',response).text()!==''){
                        alert(jQuery('.error',response).text());
                    }
                }
            });
        }else{
            alert('Template name is empty!!! Try again.');
        }
        jQuery('#template-save').removeClass('active').children('.template-container').slideUp();
    });
    jQuery('.template-name').unbind('click').bind('click',function(e){e.preventDefault();
        var $currentTemplateName = jQuery(this).text();
        var $currentResponse = 'waitingajax';
        if($currentTemplateName){
            jQuery.ajax({
                type: "POST",
                url: ajaxurl,
                data: {
                    'action':'template_get',
                    'template_name':$currentTemplateName
                },
                success: function(response){
                    $currentResponse=response;
                }
            });
            if(confirm("Your old contents are will delete ?")){
                var templateAjaxInt=setInterval(function(){
                    if($currentResponse!=='waitingajax'){
                        clearInterval(templateAjaxInt);
                        if(jQuery('.data',$currentResponse).html()!==''){
                            $currentResponse=jQuery('<div />').html(jQuery($currentResponse).html());
                            jQuery('>.data>.content .row-container>.list>.pagebuilder-elements-container',$currentResponse).html(jQuery('.pb-add-layout-conteiner>.data>.row-container>.list>.pagebuilder-elements-container').html());
                            twInitSortDragg(jQuery('>.data>.content',$currentResponse),jQuery('#pagebuilder-area'));
                            pbSaveData();
                            pbInitEvents();
                        }else if(jQuery('.error',$currentResponse).text()!==''){
                            alert(jQuery('.error',$currentResponse).text());
                        }
                    }
                },100);
            }
        }
        jQuery('#template-save').removeClass('active').children('.template-container').slideUp();
    });
    jQuery('.template-delete').unbind('click').bind('click',function(e){e.preventDefault();
        var $this = jQuery(this);
        var $currentTemplateName = $this.closest('.template-item').find('.template-name').text();
        if($currentTemplateName && confirm("Are you delete this template ?")){
            jQuery.ajax({
                type: "POST",
                url: ajaxurl,
                data: {
                    'action':'template_remove',
                    'template_name':$currentTemplateName
                },
                success: function(response){
                    $this.closest('.template-item').remove();
                    if(jQuery('.error',response).text()!==''){    
                        alert(jQuery('.error',response).text());
                    }
                }
            });
        }
        jQuery('#template-save').removeClass('active').children('.template-container').slideUp();
    });
    // Template Style
    jQuery('#template-save>.template').unbind('click').bind('click',function(e){e.preventDefault();e.stopPropagation();
        if(jQuery('#template-save').hasClass('active')){
            jQuery('#template-save').removeClass('active').children('.template-container').slideUp();
        }else{
            jQuery('#template-save').addClass('active').children('.template-container').slideDown();
        }
    });
}

function pbInitEvents(){
    // START - Builder Item Actions
    // Convert size
    jQuery('#pagebuilder-area .size.need-convert').each(function(){jQuery(this).text(jQuery('#size-list>li[data-class="'+jQuery(this).text()+'"]').attr('data-text')).removeClass('need-convert');});
    // Row Tools Actions
    jQuery('#pagebuilder-area>.row-container').each(function(){
        var $currRowCont=jQuery(this);
        // Layout Change
        jQuery('>.list>.change-layout>a',$currRowCont).unbind('click').bind('click',function(e){e.preventDefault();
            var $currentLayout = jQuery(this);
            var $currentValueArray = $currentLayout.attr('data-value').split(',');
            var $currentLayoutInput=jQuery('>.data>.custom-field-container [data-name="row_layout"]',$currRowCont);
            $currentLayout.addClass('active').siblings('a').removeClass('active');
            $currentLayoutInput.attr("value",$currentLayout.attr('data-input'));
            if($currentValueArray[0]!==''){
                var $currentBuilderArea='';
                var $currentBuilderAreaClasses='';
                for(var i = 0, length=$currentValueArray.length ; i<length; i++){
                    $currentBuilderArea=jQuery('>.builder-area',$currRowCont).eq(i);
                    $currentBuilderAreaClasses=$currentBuilderArea.attr('class').split(' ');
                    for(var ind=0,len=$currentBuilderAreaClasses.length;ind<len;ind++){
                        if($currentBuilderAreaClasses[ind].search('col-md-')!==-1){
                            $currentBuilderArea.removeClass($currentBuilderAreaClasses[ind]).addClass('col-md-'+$currentValueArray[i]);break;
                        }
                    }
                }
                //START - Sidebar elements moving
                var $oldSidebar=false;
                var $newSidebar=false;
                
                switch($currentLayoutInput.val()){
                    case'left':case'3-9-0':case'4-8-0':case'5-7-0':{
                        jQuery('>.builder-area',$currRowCont).eq(1).removeClass('right-sidebar').removeClass('no-sidebar').removeClass('triple-sidebar').addClass('left-sidebar');
                        $oldSidebar=jQuery('>.builder-area',$currRowCont).eq(-1);
                        $newSidebar=jQuery('>.builder-area',$currRowCont).eq(0);
                        break;
                    }
                    case'right':case'0-9-3':case'0-6-6':case'0-8-4':case'0-7-5':{
                        jQuery('>.builder-area',$currRowCont).eq(1).removeClass('left-sidebar') .removeClass('no-sidebar').removeClass('triple-sidebar').addClass('right-sidebar');
                        $oldSidebar=jQuery('>.builder-area',$currRowCont).eq(0);
                        $newSidebar=jQuery('>.builder-area',$currRowCont).eq(-1);
                        break;
                    }
                    case'triple':case'4-4-4':case'3-3-6':case'6-3-3':case'3-6-3':{
                        jQuery('>.builder-area',$currRowCont).eq(1).removeClass('left-sidebar').removeClass('no-sidebar').removeClass('right-sidebar').addClass('triple-sidebar');
                        break;
                    }
                    case 'full':case'0-12-0':default:{
                        jQuery('>.builder-area',$currRowCont).eq(1).removeClass('left-sidebar').removeClass('right-sidebar').removeClass('triple-sidebar').addClass('no-sidebar');
                    }
                }
                if($oldSidebar&&$newSidebar){
                    if($newSidebar.children().length===0){
                        $newSidebar.html($oldSidebar.html());
                        $oldSidebar.html('');
                    }
                }
                //END   - Sidebar elements moving
                pbSaveData();
                pbInitEvents();
            }
        });
        // Click to Add Item
        jQuery('>.list>.add-element>a.elements-dropdown',$currRowCont).unbind('click').bind('click',function(e){e.preventDefault();e.stopPropagation()
            var $curr=jQuery(this).parent();
            var $currEls=$curr.siblings('.pagebuilder-elements-container');
            if($curr.hasClass('active')){
                $curr.removeClass('active');
                $currEls.stop().slideUp();
            }else{
                $currRowCont.siblings('.row-container').find('>.list>.add-element').removeClass('active').siblings('.pagebuilder-elements-container').stop().slideUp();
                $curr.addClass('active');
                $currEls.stop().slideDown();
            }
        });
        jQuery('>.list>.pagebuilder-elements-container>.item',$currRowCont).unbind('click').bind('click',function(e){e.preventDefault();
            var $currSlug   = jQuery(this).attr('data-slug');
            var $newElement = jQuery('#items-list>[data-slug="'+$currSlug+'"]').clone();
            jQuery('>.builder-area',$currRowCont).eq(1).append($newElement);
            jQuery(this).closest('.pagebuilder-elements-container').stop().slideUp().siblings('.add-element.active').removeClass('active');
            pbSaveData();
            pbInitEvents();
        });
        jQuery('html').unbind('click').bind("click", function(){
            twHideToolsMenu();
        });
    });    
    //resize
    jQuery(".builder-area>.item>.list>.size-sizer-container>.sizer>a.down").unbind("click").bind("click",function(e){e.preventDefault();        
        var $this = jQuery(this);
        var $sizeList=jQuery('#size-list').clone();
        var $currentItem     = $this.closest('.action-container');
        var $currentSizeText = jQuery('>.list>.size-sizer-container>.size',$currentItem).text();
        var $currentSizeList = jQuery('li[data-text="'+$currentSizeText+'"]',$sizeList);
        var $sizerOP = false;
        $currentItem.removeClass($currentSizeList.attr('data-class'));
        if($currentItem.attr('data-min')){$sizeList.find('[data-class="'+$currentItem.attr('data-min')+'"]').addClass('min').siblings('.min').removeClass('min');}
        if($currentSizeList.hasClass('min')){
            if($sizerOP){
                $currentSizeList=$currentSizeList.siblings('.max');
            }
        }else{
            $currentSizeList=$currentSizeList.prev();
        }
        $currentItem.addClass($currentSizeList.attr('data-class'));
        jQuery('>.list>.size-sizer-container>.size',$currentItem).text($currentSizeList.attr('data-text'));
        pbSaveData();
    });
    
    jQuery(".builder-area>.item>.list>.size-sizer-container>.sizer>a.up").unbind("click").bind("click",function(e){e.preventDefault();
        var $this = jQuery(this);
        var $sizeList=jQuery('#size-list').clone();
        var $currentItem     = $this.closest('.action-container');
        var $currentSizeText = jQuery('>.list>.size-sizer-container>.size',$currentItem).text();
        var $currentSizeList = jQuery('li[data-text="'+$currentSizeText+'"]',$sizeList);
        var $sizerOP = false;
        $currentItem.removeClass($currentSizeList.attr('data-class'));
        if($currentItem.attr('data-min')){$sizeList.find('[data-class="'+$currentItem.attr('data-min')+'"]').addClass('min').siblings('.min').removeClass('min');}
        if($currentSizeList.hasClass('max')){
            if($sizerOP){
                $currentSizeList=$currentSizeList.siblings('.min');
            }
        }else{
            $currentSizeList=$currentSizeList.next();
        }
        $currentItem.addClass($currentSizeList.attr('data-class'));
        jQuery('>.list>.size-sizer-container>.size',$currentItem).text($currentSizeList.attr('data-text'));
        pbSaveData();
    });
		
    //duplicate
    jQuery(".builder-area>.item>.list>.actions>a.action-duplicate,.row-container>.list>.actions>a.action-duplicate").unbind("click").bind("click",function(e){
        twPublishEnable('disable');
        var $parent = jQuery(this).closest('.action-container');
        if($parent.css('position')==='relative'){
            e.preventDefault();
            var $newItem = $parent.clone().addClass('hidded').css('display','none');
            if($newItem.hasClass('row-container')&&$newItem.hasClass('default-row')){
                $newItem.removeClass('default-row').addClass('additional-row');
                jQuery('>.data>.custom-field-container [data-name="default_row"]',$newItem).attr("value",'false');
            }
            $parent.after($newItem).promise().done(function(){
                $newItem.removeClass('hidded').fadeIn('slow').promise().done(function(){
                    $parent.siblings('.action-container').css('opacity','');
                    // Sortable Draggable
                    twInitSortDragg(jQuery('#pagebuilder-area'),jQuery('#pagebuilder-area'));
                    pbSaveData();
                    pbInitEvents();
                });
            });
        }
    });
    //edit
    jQuery(".builder-area>.item>.list>.actions>a.action-edit,.row-container>.list>.actions>a.action-edit").unbind("click").bind("click",function(e){
        var $parent = jQuery(this).closest('.action-container');
        if($parent.css('position')==='relative'){
            e.preventDefault();
            jQuery('.action-container.item-modalled').removeClass('item-modalled');
            $parent.addClass('item-modalled');
            var html = $parent.children('.data').html();
            //pbInitModalSave
            jQuery( '<div id="pb-modal-container" class="'+$parent.attr('data-slug')+'" />' ).append(html).dialog({
                closeOnEscape: true,
                title: $parent.children('.list').children('.name').text(),
                resizable: false,
                width: 800,
                modal: true,
                open: function(event, ui){
                    jQuery(this).closest('.ui-dialog-content').removeClass('ui-dialog-content').addClass('waves-ui-dialog-content');
                    jQuery(this).closest('.ui-dialog').addClass('tw-pb-main-container');
                    jQuery(this).closest('.ui-dialog').focus();
                    if($parent.attr('data-help')){jQuery(this).closest('.ui-dialog').find('.ui-dialog-buttonpane').prepend('<a href="'+$parent.attr('data-help')+'" target="_blank" class="watch-tutorial">LINK</a>');}
                    pbModalInitActions(jQuery(this));
                    $twBuilderScorollTop=jQuery(window).scrollTop();
                    twDlgOpen(jQuery(this));
                },
                close: function(){
                    twDlgClose(jQuery(this));
                    twDlgCloseEditor(jQuery(this));
                    jQuery(this).closest('.ui-dialog').remove();
                    jQuery('body>#pb-modal-container').remove();
                    jQuery(window).scrollTop($twBuilderScorollTop);
                },
                buttons: {
                    "Save": function() {
                        pbModalSave(jQuery(this));
                        jQuery(this).dialog("close");
                        pbSaveData();
                    },
                    "Cancel": function() {
                        jQuery(this).dialog("close");
                    }
                }
            });
        }
    });
    //remove item
    jQuery(".builder-area>.item>.list>.actions>a.action-delete,.row-container>.list>.actions>a.action-delete").unbind("click").bind("click",function(e){
        var $currentDeleteModal = jQuery(this).closest('.action-container');
        if($currentDeleteModal.css('position')==='relative'){
            e.preventDefault();
            //pbInitModalSave
            jQuery( '<div id="pb-delete-modal-container" />' ).append('Are you sure to delete this Element?').dialog({
                closeOnEscape: true,
                title: 'Confirm',
                resizable: false,
                width: 800,
                modal: true,
                open: function(event, ui){
                    jQuery(this).closest('.ui-dialog-content').removeClass('ui-dialog-content').addClass('waves-ui-dialog-content');
                    jQuery(this).closest('.ui-dialog').addClass('tw-pb-main-container');
                    jQuery(this).closest('.ui-dialog').find('.ui-dialog-buttonset>.ui-button').first().focus();
                    $twBuilderScorollTop=jQuery(window).scrollTop();
                    jQuery(this).closest('.ui-dialog').addClass('tw-pb-for-delete');
                    twDlgOpen(jQuery(this));
                },
                close: function(){
                    twDlgClose(jQuery(this));
                    $currentDeleteModal=false;
                    jQuery(this).closest('.ui-dialog').remove();
                    jQuery('body>#pb-delete-modal-container').remove();
                    jQuery(window).scrollTop($twBuilderScorollTop);
                },
                buttons: {
                    "Yes": function() {
                        $currentDeleteModal.remove();
                        $currentDeleteModal=false;
                        pbSaveData();
                        jQuery(this).dialog("close");
                    },
                    "No": function() {
                        jQuery(this).dialog("close");
                    }
                }
            });
        }
    });
    //expand item
    jQuery(".row-container>.list>.actions>a.action-expand").unbind("click").bind("click",function(e){e.preventDefault();
        var $currBtn = jQuery(this);
        var $curr    = $currBtn.closest('.action-container');
        $curr.children('.builder-area').each(function(){
            jQuery(this).css('height',jQuery(this).height()+'px');
        }).promise().done(function(){
            if($curr.hasClass('closed')){
                $curr.children('.builder-area').slideDown("normal", function(){$curr.removeClass('closed');$currBtn.find('span').text('Close');}).css('min-height','');
            }else{
                $curr.children('.builder-area').css('min-height','0px').slideUp("normal", function(){$curr.addClass('closed');$currBtn.find('span').text('Expand');});
            }
        });
        
    });
    // END   - Builder Item Actions
}
	
function pbSaveData(){
    var $currSaving=++$pbSavingLast;
    // Saving Datas
    twPublishEnable('disable');
    var savingInt=setInterval(function(){
        twPublishEnable('disable');
        if($pbSavingDone){
            $pbSavingDone=false;
            clearInterval(savingInt);
            var item = '';
            jQuery('#pagebuilder-area>.row-container').each(function(iRow){
                var $currentRow=jQuery(this);
                if(iRow){item += ',';}
                item += '"'+iRow+'":{';
                jQuery('>.data>.custom-field-container>.field-item>.field-data>.field',$currentRow).each(function(){
                    var $currentContainerField=jQuery(this);
                    item += '"'+$currentContainerField.attr('data-name')+'":"'+$currentContainerField.val()+'",';
                }).promise().done(function(){
                    item += '"layouts":{';
                    jQuery('>.builder-area',$currentRow).each(function(iCont){
                        var $currentContainer=jQuery(this);
                        var $size='';
                        var $classes=$currentContainer.attr('class').split(' ');
                        for(var i=0,len=$classes.length;i<len;i++){
                            if($classes[i].search('col-md-')!==-1){
                                $size=$classes[i];
                                break;
                            }
                        }
                        if(iCont){item += ',';}
                        item += '"'+iCont+'":{"size":"'+$size+'",';
                        item += '"items":{';
                        $currentContainer.children('.item').each(function(i){
                            var $currentItem=jQuery(this);
                            var $currentFieldVal='';
                            if(i){item += ',';}
                            item += '"'+i+'":{"slug":"'+$currentItem.attr('data-slug')+'","size":"' + jQuery('#size-list>li[data-text="'+jQuery('.list>.size-sizer-container>.size',$currentItem).text()+'"]').attr('data-class') + '",';
                            jQuery('.data .general-field-container>.field-item>.field-data>.field',$currentItem).each(function(){
                                var $currentField=jQuery(this);
                                item += '"'+$currentField.attr('data-name')+'":"'+encodeURIComponent($currentField.val())+'",';
                            }).promise().done(function(){
                                item += '"settings":{';
                                jQuery('.data .custom-field-container>.field-item>.field-data>.field',$currentItem).each(function(index){
                                    var $currentField=jQuery(this);
                                    if(index){item += ',';}
                                    if($currentField.attr('data-type')==='container'){
                                        item += '"'+$currentField.attr('data-name')+'":{';
                                            $currentField.children('.container-item').each(function(itemIndex){
                                                var $currentContainerItem=jQuery(this);
                                                if(itemIndex){item += ',';}
                                                item += '"'+itemIndex+'":{';
                                                    jQuery('.content>.field-item>.field-data>.field',$currentContainerItem).each(function(fieldIndex){
                                                        var $currentContainerItemField = jQuery(this);
                                                        if(fieldIndex){item += ',';}
                                                        $currentFieldVal='';
                                                        if($currentContainerItemField.attr('data-type')==="textArea"){
                                                            $currentFieldVal=$currentContainerItemField.html().replace(/&lt;/gi,'<').replace(/&gt;/gi, '>');
                                                        }else{
                                                            $currentFieldVal=$currentContainerItemField.val();
                                                        }
                                                        item += '"'+$currentContainerItemField.attr('data-name')+'":"'+encodeURIComponent($currentFieldVal)+'"';
                                                    });
                                                item += '}';
                                            });
                                        item += '}';
                                    }else{
                                        $currentFieldVal='';
                                        if($currentField.attr('data-type')==="textArea"){
                                            $currentFieldVal=$currentField.html().replace(/&lt;/gi,'<').replace(/&gt;/gi, '>');
                                        }else{
                                            $currentFieldVal=$currentField.val();
                                        }
                                        item += '"'+$currentField.attr('data-name')+'":"'+encodeURIComponent($currentFieldVal)+'"';
                                    }
                                }).promise().done(function(){
                                    item += '}}';
                                });
                            });
                        }).promise().done(function(){
                            item += '}}';
                        });
                    }).promise().done(function(){
                        item += '}}';
                    });
                });
            }).promise().done(function(){
                jQuery('textarea#pb_content').val(encodeURIComponent('{'+item+'}'));
                // Shortcode Build
                if($currSaving===$pbSavingLast){
                    twPublishEnable('enable');
                    $pbSavingDone=true;
                }else{
                    $pbSavingDone=true;
                }
            });
        }
    },500);
}
function pbModalInitActions($currentModal){
    //Font Icon Actions
    var $pbHideStr='';
    
    $pbHideStr+=' #shortcode_container_dialog [data-name="cc_type"]';
    $pbHideStr+=',#shortcode_container_dialog [data-name="cc_line_cap"]';
    $pbHideStr+=',#shortcode_container_dialog [data-name="fi_rotate"]';
    $pbHideStr+=',#shortcode_container_dialog [data-name="fi_box_shadow"]';
    
    $pbHideStr+=',#pb-modal-container [data-name="cc_type"]';
    $pbHideStr+=',#pb-modal-container [data-name="cc_line_cap"]';
    $pbHideStr+=',#pb-modal-container [data-name="fi_rotate"]';
    $pbHideStr+=',#pb-modal-container [data-name="fi_box_shadow"]';
    
    $pbHideStr+=',#pb-modal-content [data-name="cc_type"]';
    $pbHideStr+=',#pb-modal-content [data-name="cc_line_cap"]';
    $pbHideStr+=',#pb-modal-content [data-name="fi_rotate"]';
    $pbHideStr+=',#pb-modal-content [data-name="fi_box_shadow"]';
    
    jQuery($pbHideStr).closest('.field-item').hide();
    jQuery('[data-name="fi_icon"]',$currentModal).each(function(){
        var $currIconField = jQuery(this).closest('.field-item');
        var $currFi = $currIconField.siblings('.field-item.type-fi').hasClass('type-fi')?$currIconField.siblings('.field-item.type-fi'):$currentModal;
        var $currFiFields = $currIconField.parent().children('.field-item');
        //Font Icon Viewer
        jQuery('[data-name="fi_icon"]',$currFiFields).unbind('input').bind('input',function(){
            var $class='fa';
            var $style='text-align:center; margin: 0 auto; font-style: normal;';
            $style +='font-size:'       +jQuery('[data-name="fi_size"]',    $currFiFields).val()+'px;';
            $style +='width:'           +jQuery('[data-name="fi_size"]',    $currFiFields).val()+'px;';
            $style +='line-height:'     +jQuery('[data-name="fi_size"]',    $currFiFields).val()+'px;';
            $style +='padding:'         +jQuery('[data-name="fi_padding"]', $currFiFields).val()+'px;';
            $style +='color:'           +jQuery('[data-name="fi_color"]',   $currFiFields).val()+';';
            $style +='background-color:'+jQuery('[data-name="fi_bg_color"]',    $currFiFields).val()+';';
            $style +='border-color:'    +jQuery('[data-name="fi_border_color"]',$currFiFields).val()+';';
            $style +='border-width:'    +jQuery('[data-name="fi_rounded"]',     $currFiFields).val()+'px;';
            $style +='border-radius:'    +jQuery('[data-name="fi_rounded_size"]',     $currFiFields).val()+'px;';
            $style +='-moz-border-radius:'    +jQuery('[data-name="fi_rounded_size"]',     $currFiFields).val()+'px;';
            $style +='-webkit-border-radius:'    +jQuery('[data-name="fi_rounded_size"]',     $currFiFields).val()+'px;';
            if ((jQuery('[data-name="fi_box_shadow"]',     $currFiFields).val())==='true'){
                $style +='-webkit-box-shadow: inset 0px 0px 0px 2px ' +jQuery('[data-name="fi_color"]',     $currFiFields).val()+';';
                $style +='-moz-box-shadow: inset 0px 0px 0px 2px ' +jQuery('[data-name="fi_color"]',     $currFiFields).val()+';';
                $style +='box-shadow: inset 0px 0px 0px 2px ' +jQuery('[data-name="fi_color"]',     $currFiFields).val()+';';
            }
            if ((jQuery('[data-name="fi_rotate"]',     $currFiFields).val())==='true'){
                $class+=' fi-rotate';
            }
            $class+=' '+jQuery('[data-name="fi_icon"]', $currFiFields).val();
            jQuery('.fi-viewer',$currFi).html('<i class="'+$class+'" style="border-style: solid; '+$style+'"></i>');
        });
        jQuery('[data-name="fi_icon"]',$currFiFields).trigger('input');
        //Font Icon Modal
        jQuery('.show-fi-modal',$currFi).unbind('click').bind('click',function(e){e.preventDefault();
            var $currentButton=jQuery(this);
            if($currentButton.not('.loading')){
                $currentButton.addClass('loading');
                jQuery.ajax({
                    type: "POST",
                    url: ajaxurl,
                    data: {
                        'action':'get_fonticon'
                    },
                    success: function(response){
                        if(jQuery(response).hasClass('fonticon-ajax-data')){
                            jQuery( '<div id="fonticon_container_dialog" data-current="none" />').append(jQuery(response).html()).dialog({
                                title: 'Font Icon',
                                resizable: true,
                                width: 800,
                                modal: true,
                                open: function(){
                                    jQuery(this).closest('.ui-dialog-content').removeClass('ui-dialog-content').addClass('waves-ui-dialog-content');
                                    jQuery(this).closest('.ui-dialog').addClass('tw-pb-main-container');
                                    jQuery(this).closest('.ui-dialog').focus();
                                    pbModalSaveField($currFiFields,jQuery(this).find('.general-field-container').children('.field-item'));
                                    pbModalInitActions(jQuery(this));
                                    pbFiModalInitActions(jQuery(this));
                                    twDlgOpen(jQuery(this));
                                },
                                close: function(){
                                    twDlgClose(jQuery(this));
                                    jQuery(this).closest('.ui-dialog').remove();
                                    jQuery('body>#fonticon_container_dialog').remove();
                                },
                                buttons: {
                                    "Insert": function() {
                                        pbModalSaveField(jQuery(this).find('.general-field-container').children('.field-item'),$currentButton.closest('.field-item').parent().children('.field-item'));
                                        $currentButton.closest('.field-item').parent().find('[data-name="fi_icon"]').trigger('input');
                                        jQuery(this).dialog("close");
                                    },
                                    "Cancel": function() {
                                        jQuery(this).dialog("close");
                                    }
                                }
                            });
                        }
                        $currentButton.removeClass('loading');
                    }
                });
            }
        });
    });
    //Circle Chart Actions
    jQuery('[data-name="cc_icon"]',$currentModal).each(function(){
        var $currIconField = jQuery(this).closest('.field-item');
        var $currCc = $currIconField.siblings('.field-item.type-cc').hasClass('type-cc')?$currIconField.siblings('.field-item.type-cc'):$currentModal;
        var $currCcFields = $currIconField.parent().children('.field-item');
        //Circle Chart Viewer
        jQuery('[data-name="cc_icon"]',$currCcFields).unbind('input').bind('input',function(){
            var $html='';
            var $style='display:block; text-align:center; margin: 0 auto;';
            $style +='width:'      +jQuery('[data-name="cc_size"]',      $currCcFields).val()+'px;';
            $style +='line-height:'+jQuery('[data-name="cc_size"]',      $currCcFields).val()+'px;';
            var $cStyle='';
            $cStyle +='color:'+jQuery('[data-name="cc_font_color"]',$currCcFields).val()+';';
            $cStyle +='font-size:'  +jQuery('[data-name="cc_font_size"]', $currCcFields).val()+'px;';
            $html +='<div class="tw-circle-chart" data-percent="'+jQuery('[data-name="cc_percent"]',$currCcFields).val()+'">';
                $html +='<span style="'+$cStyle+'">';
                    if(jQuery('[data-name="cc_type"]', $currCcFields).val()==='fi'){
                        $html +='<i class="fa '+jQuery('[data-name="cc_icon"]', $currCcFields).val()+'" style="'+$style+'"></i>';
                    }else{
                        $html +=jQuery('[data-name="cc_text"]',$currCcFields).val();
                    }
                $html +='</span>';                
            $html +='</div>';
            jQuery('.cc-viewer',$currCc).html($html);
            jQuery('.tw-circle-chart',$currCc).easyPieChart({                
                lineWidth  : jQuery('[data-name="cc_line_width"]' ,$currCcFields).val(),
                size       : jQuery('[data-name="cc_size"]'       ,$currCcFields).val(),
                barColor   : jQuery('[data-name="cc_color"]'      ,$currCcFields).val(),
                trackColor : jQuery('[data-name="cc_track_color"]',$currCcFields).val(),
                scaleColor : false,
                lineCap    : jQuery('[data-name="cc_line_cap"]',$currCcFields).val()
            });
            
        });
        jQuery('[data-name="cc_icon"]',$currCcFields).trigger('input');
        //Circle Chart Modal
        jQuery('.show-cc-modal',$currCc).unbind('click').bind('click',function(e){e.preventDefault();
            var $currentButton=jQuery(this);
            if($currentButton.not('.loading')){
                $currentButton.addClass('loading');
                jQuery.ajax({
                    type: "POST",
                    url: ajaxurl,
                    data: {
                        'action':'get_circlechart'
                    },
                    success: function(response){
                        if(jQuery(response).hasClass('fonticon-ajax-data')){
                            jQuery( '<div id="circlechart_container_dialog" data-current="none" />').append(jQuery(response).html()).dialog({
                                title: 'Circle Chart',
                                resizable: true,
                                width: 800,
                                modal: true,
                                open: function(){
                                    jQuery(this).closest('.ui-dialog-content').removeClass('ui-dialog-content').addClass('waves-ui-dialog-content');
                                    jQuery(this).closest('.ui-dialog').addClass('tw-pb-main-container');
                                    jQuery(this).closest('.ui-dialog').focus();
                                    pbModalSaveField($currCcFields,jQuery(this).find('.general-field-container').children('.field-item'));
                                    pbModalInitActions(jQuery(this));
                                    pbCcModalInitActions(jQuery(this));
                                    twDlgOpen(jQuery(this));
                                },
                                close: function(){
                                    twDlgClose(jQuery(this));
                                    jQuery(this).closest('.ui-dialog').remove();
                                    jQuery('body>#circlechart_container_dialog').remove();
                                },
                                buttons: {
                                    "Insert": function() {
                                        pbModalSaveField(jQuery(this).find('.general-field-container').children('.field-item'),$currentButton.closest('.field-item').parent().children('.field-item'));
                                        $currentButton.closest('.field-item').parent().find('[data-name="cc_icon"]').trigger('input');
                                        jQuery(this).dialog("close");
                                    },
                                    "Cancel": function() {
                                        jQuery(this).dialog("close");
                                    }
                                }
                            });
                        }
                        $currentButton.removeClass('loading');
                    }
                });
            }
        });
    });
    //Upload Button Item
    jQuery('.field-item>.field-data>[data-type="button"]',$currentModal).each(function(){
        var $currentButton=jQuery(this);
        var $currentButtonSaveTo=$currentButton.attr('data-save-to');
        if($currentButtonSaveTo!==''){
            var $currentSaveField = $currentButton.closest('.field-item').siblings('.field-item').find('>.field-data>[data-name="'+$currentButtonSaveTo+'"]',$currentModal);
            $currentButton.unbind('click').bind('click',function(){
                if($currentSaveField.attr('data-type-org')==='gallery'){
                    /* Gallery */
                    var frame;
                    var images = $currentSaveField.val();
                    var selection = twLoadImages(images);
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

                    // Override insert button
                    function overrideGalleryInsert() {
                        frame.toolbar.get('view').set({
                            insert: {
                                style: 'primary',
                                text: waves_script_data.label_save,
                                click: function() {
                                    var models = frame.state().get('library'),
                                        ids = '';
                                    $currentSaveField.siblings('ul.gallery-images').html('');
                                    models.each( function( attachment ) {
                                        $currentSaveField.siblings('ul.gallery-images').append('<li><img src="'+attachment.attributes.url+'"></li>');
                                        ids += attachment.id + ','
                                    });

                                    $currentSaveField.attr("value",ids);
                                    this.el.innerHTML = waves_script_data.label_saving;
                                    selection = twLoadImages(ids);
                                    frame.close();
                                }
                            }
                        });
                    }
                }else{
                    var _custom_media = true,
                        _orig_send_attachment = wp.media.editor.send.attachment;
                    _custom_media = true;
                    wp.media.editor.send.attachment = function(props, attachment){
                        if ( _custom_media ) {
                            $currentSaveField.attr("value",attachment.url);
                        } else {
                          return _orig_send_attachment.apply( this, [props, attachment] );
                        }
                    };
                    jQuery('.add_media').on('click', function(){_custom_media = false;});
                    wp.media.editor.open($currentButton);
                    return false;
                }
            });
        }
    });
    //TextEditor Item
    jQuery('.field-item>.field-data>[data-tinymce="true"]',$currentModal).each(function(){
        var $currentEditor=jQuery(this);
        $currentEditor.addClass('wp-editor-area');
        if(!$currentEditor.closest('.container-item').hasClass('container-item')){
            var $currentEditorName=$currentEditor.attr('data-name')+'-'+$currentContentEditorInterval++;
            jQuery('#custom-content-list').append('<li data-content="'+$currentEditorName+'"></li>');
            pbModalContentEditor($currentEditorName,$currentEditor);
            window.wpActiveEditor=$currentContentEditor=$currentEditorName;
        }
    });
    //CheckBox Item
    jQuery('.field-item>.field-data>[data-type="checkbox"]',$currentModal).each(function(){
        var $currentCheck=jQuery(this);
        var $currentCheckText=$currentCheck.next('.checkbox-text');
        $currentCheckText.unbind('click').bind('click',function(){
            $currentCheck.attr("value",!$currentCheck.is(':checked')).attr("checked",!$currentCheck.is(':checked')).change();
        });
        $currentCheck.unbind('change').bind('change',function(){
            var $marginLeft='-39px';
            var $bgColor   ='#aeaeae';
            if($currentCheck.is(':checked')){
                $marginLeft='0px';
                $bgColor='#2dcb73';
                if($currentCheck.closest('.waves-ui-dialog-content.ui-widget-content').hasClass('accordion')){
                    $currentCheck.closest('.container-item').siblings('.container-item').find('.field-item>.field-data>[data-name="'+$currentCheck.attr('data-name')+'"]').attr("value","false").attr("checked",false).change();
                }
            }
            $currentCheckText.animate({
                marginLeft: $marginLeft,
                backgroundColor: $bgColor
            },300);
        });
        $currentCheck.change();
    });
    jQuery('.field-item>.field-data>select',$currentModal).unbind('change').bind('change',function(){
        var $currentSelect=jQuery(this);
        var $currentVal=$currentSelect.val();
        var $currentSelectText=$currentSelect.next('.select-text');
        var $currentSelectOption=$currentSelect.find('option[value="'+$currentVal+'"]');
        var $currentHideArray = $currentSelectOption.attr('hide')?$currentSelectOption.attr('hide').split(','):[""];
        $currentSelectOption.attr('selected','selected').siblings().removeAttr('selected');
        // Show not selected (For hide option)
        $currentSelectOption.siblings().each(function(){
            var $curr=jQuery(this);
            var $currShowArr = $curr.attr('hide')?$curr.attr('hide').split(','):[""];
            for(var i = 0, length=$currShowArr.length ; i<length; i++){
                if($currShowArr[i]!==''){
                    if($currShowArr[i]==='fi'||$currShowArr[i]==='cc'){
                        $currentSelect.closest('.field-item').siblings('.field-item.type-'+$currShowArr[i]).removeClass('hide-for-select').show();
                    }else{
                        $currentSelect.closest('.field-item').siblings('.field-item').find('>.field-data>[data-name="'+$currShowArr[i]+'"]').closest('.field-item').removeClass('hide-for-select').show();
                    }
                }
            }
        });
        // Hide selected (For hide option)
        if($currentHideArray[0]!==''){
            for(var i = 0, length=$currentHideArray.length ; i<length; i++){
                if($currentHideArray[i]==='fi'||$currentHideArray[i]==='cc'){
                    $currentSelect.closest('.field-item').siblings('.field-item.type-'+$currentHideArray[i]).addClass('hide-for-select').hide();
                }else{
                    $currentSelect.closest('.field-item').siblings('.field-item').find('>.field-data>[data-name="'+$currentHideArray[i]+'"]').closest('.field-item').addClass('hide-for-select').hide();
                }
            }
        }
        $currentSelectText.text($currentSelectOption.text());
        if($currentSelect.attr('id')==='style_shortcode'&&$currentVal!=='none'){
            $currentSelect.children('option[value="none"]').attr('selected','selected').siblings().removeAttr('selected');
            twGetShortcode($currentVal);
        }
    });
    jQuery('.field-item>.field-data>select',$currentModal).change();
    //Color Picker Item
    jQuery('.field-item>.field-data>[data-type="color"]',$currentModal).each(function(){
        var $currentInput=jQuery(this);
        jQuery($currentInput.siblings(".color-info")).ColorPicker({
            onShow: function (colpkr) {
                jQuery(colpkr).find('.colorpicker_hex>input').val($currentInput.val().replace('#','')).change();
                jQuery(colpkr).fadeIn(500);
                return false;
            },
            onHide: function (colpkr) {
                jQuery(colpkr).fadeOut(500);
                return false;
            },
            onChange: function (hsb, hex, rgb, el) {
                $currentInput.siblings('.color-info').css('background-color','#' + hex);
                $currentInput.val('#' + hex).change().trigger('input');
            }
        });
        $currentInput.unbind('input change').bind('input change',function(){
            if(jQuery(this).val()===''){
                jQuery(this).val(' ');
            }else if(jQuery(this).val().search(' ')!==-1){
                jQuery(this).val(jQuery(this).val().replace(/ /gi,''));
            }
            $currentInput.siblings('.color-info').css('background-color',jQuery(this).val());
        });
        jQuery(this).change();
    });
    //Container Item
    jQuery('.field-item>.field-data>[data-type="container"]',$currentModal).each(function(){
        var $currentContainer = jQuery(this);
        jQuery('.field-item>.field-data>[data-name="'+$currentContainer.attr('data-add-button')+'"]',$currentModal).unbind('click').bind('click',function(e){e.preventDefault();
            var $currentButton=jQuery(this);
            var $newElement = $currentButton.next('.data').find('[data-type="container"]');
            if($currentContainer.attr('data-container-type')==='toggle'){
                $currentContainer.append($newElement.html());
                pbModalInitActions($currentModal);
            }else{
                window.original_send_to_editor = window.send_to_editor;
                window.custom_editor = true;
                window.send_to_editor = function(html){
                    html = jQuery("<div />").html(html);
                    jQuery(html).find('img').each(function(){
                        $newElement.find('.image-src').attr('src',jQuery(this).attr('src'));
                        $newElement.find('[data-name="'+$newElement.attr('data-title-as')+'"]').attr('value',jQuery(this).attr('src'));
                        $currentContainer.append($newElement.html());
                    }).promise().done(function(){
                        tb_remove();
                        pbModalInitActions($currentModal);
                    });
                };
                tb_show('Upload', $homeURI+'/wp-admin/media-upload.php?post_ID=' + waves_script_data.post_id + '&type=image&TB_iframe=true',false);
                jQuery('#TB_overlay').css('z-index','9998');
                jQuery('#TB_window').css('z-index','9999');
            }
        });
        if($currentContainer.attr('data-container-type')==='toggle'){
            jQuery('.container-item>.content>.field-item>.field-data>[data-name="'+$currentContainer.attr('data-title-as')+'"]',$currentContainer).each(function(){
                var $currentChanger=jQuery(this);
                var $currentChangerType=$currentChanger.attr('data-type');
                if($currentChangerType==='select'){
                    $currentChanger.bind('change',function(){
                        $currentChanger.closest('.container-item').children('.list').children('.name').text($currentChanger.val());
                    });
                    $currentChanger.change();
                }else{
                    $currentChanger.unbind('input').bind('input',function(e){e.preventDefault();
                        $currentChanger.closest('.container-item').children('.list').children('.name').text($currentChanger.val());
                    });
                    $currentChanger.trigger('input');
                }
            });
        }
    });
    jQuery('.container-item>.list>.actions>.action-delete',$currentModal).unbind('click').bind('click',function(e){e.preventDefault();
        jQuery(this).closest('.container-item').remove();
    });
    jQuery('.container-item>.list>.actions>.action-duplicate',$currentModal).unbind('click').bind('click',function(e){e.preventDefault();
        var $parent = jQuery(this).closest('.container-item');
        var $newItem = $parent.clone().addClass('hidded').css('display','none');
        $parent.after($newItem).promise().done(function(){
            $newItem.removeClass('hidded').fadeIn('slow').promise().done(function(){
                pbModalInitActions($currentModal);
            });
        });
        return false;
    });
    jQuery('.container-item>.list>.actions>.action-edit',$currentModal).unbind('click').bind('click',function(e){e.preventDefault();
        var $parent = jQuery(this).closest('.container-item');
        $parent.addClass('item-modalled').siblings('.item-modalled').removeClass('item-modalled');
        var html = '<div class="custom-field-container">'+$parent.children('.content').html()+'</div>';
        jQuery( '<div id="pb-modal-content" />' ).append(html).dialog({
            closeOnEscape: true,
            title: 'Editing Elements',
            resizable: false,
            width: 800,
            modal: true,
            open: function(event, ui){
                jQuery(this).closest('.ui-dialog-content').removeClass('ui-dialog-content').addClass('waves-ui-dialog-content');
                jQuery(this).closest('.ui-dialog').addClass('tw-pb-main-container');
                jQuery(this).closest('.ui-dialog').focus();
                pbModalInitActions(jQuery(this));
                twDlgOpen(jQuery(this));
            },
            close: function(){
                twDlgClose(jQuery(this));
                twDlgCloseEditor(jQuery(this));
                jQuery(this).closest('.ui-dialog').remove();
                jQuery('body>#pb-modal-content').remove();
            },
            buttons: {
                "Save": function() {
                    pbModalSaveField(jQuery('>.custom-field-container>.field-item',this),jQuery('>.content>.field-item',$parent));
                    jQuery(this).dialog("close");
                    pbSaveData();
                },
                "Cancel": function() {
                    jQuery(this).dialog("close");
                }
            }
        });
    });
    jQuery('.field-item>.field-data>[data-type="container"]',$currentModal).sortable({distance: 20,placeholder: 'container-item placeholding'});
    //Category Item
    function catReseter($currentCategorySelector, $currentSaveTo){
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
            catReseter($currentCategorySelector, $currentSaveTo);
        });
    }
    jQuery('.field-item>.field-data>[data-type="category"]',$currentModal).each(function(){
        var $currentCategorySelector = jQuery(this);
        var $currentCategoryList = $currentCategorySelector.siblings('.category-list-container');
        var $currentSaveTo       = jQuery('.field-item>.field-data>[data-selector="'+$currentCategorySelector.attr('data-name')+'"]',$currentModal);
        $currentCategorySelector.change(function(){
            var $val  = $currentCategorySelector.val();
            var $noProblem = true;
            $currentCategoryList.children(".category-list-item").each(function(){
                if(jQuery(this).attr('data-value') == $val) {
                    $noProblem = false;
                }
            });
            if($val === 0 || $val == '0'){
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
                    catReseter($currentCategorySelector,$currentSaveTo);
                }
            }
        });
        catReseter($currentCategorySelector,$currentSaveTo);
    });
    jQuery('textarea',$currentModal).each(function(){
        var $currTextArea=jQuery(this);
        $currTextArea.unbind('input').bind('input',function(){$currTextArea.html($currTextArea.val());});
    });
}
function pbFiModalInitActions($currentFiModal){
    jQuery('[data-name="icon_type"]',$currentFiModal).unbind('change').bind('change',function(){
        if(jQuery(this).val()==='fa'){
            jQuery('ul.unstyled>.row.fontawesome',$currentFiModal).show();
            jQuery('ul.unstyled>.row.simple-line-icons',$currentFiModal).hide();
        }else{
            jQuery('ul.unstyled>.row.fontawesome',$currentFiModal).hide();
            jQuery('ul.unstyled>.row.simple-line-icons',$currentFiModal).show();
        }
    });
    jQuery('ul.unstyled>.row>div',$currentFiModal).unbind('click').bind('click',function(e){e.preventDefault();
        jQuery('ul.unstyled>.row>div.active',$currentFiModal).removeClass('active');
        jQuery(this).addClass('active');
        var $iconClass=jQuery(this).children('span.muted').eq(0).text().replace(' ','');
        jQuery('[data-name="fi_icon"]',$currentFiModal).val($iconClass).trigger('input');
    });
    jQuery('[data-name="fi_size"],[data-name="fi_padding"],[data-name="fi_color"],[data-name="fi_border_color"],[data-name="fi_bg_color"],[data-name="fi_rounded"],[data-name="fi_rounded_size"]',$currentFiModal).unbind('input').bind('input',function(){
        jQuery('[data-name="fi_icon"]',$currentFiModal).trigger('input');
    });
    jQuery('[data-name="fi_box_shadow"]').unbind('change').bind('change',function(){
        jQuery('[data-name="fi_icon"]',$currentFiModal).trigger('input');
    });
    jQuery('[data-name="fi_rotate"]').unbind('change').bind('change',function(){
        jQuery('[data-name="fi_icon"]',$currentFiModal).trigger('input');
    });
    jQuery('ul.unstyled>.row>div>.muted',$currentFiModal).each(function(){
        if(jQuery(this).text().trim()===jQuery('[data-name="fi_icon"]',$currentFiModal).val().trim()){
            var $tmp= jQuery(this).closest('.row').hasClass('fontawesome')?'fa':'sl';
            jQuery('[data-name="icon_type"] [value="'+$tmp+'"]',$currentFiModal).attr('selected','selected').siblings('option').removeAttr('selected');
            jQuery('[data-name="icon_type"]',$currentFiModal).change();
            jQuery(this).parent().click();
        }
    });
}
function pbCcModalInitActions($currentCcModal){
    jQuery('[data-name="icon_type"]',$currentCcModal).unbind('change').bind('change',function(){
        if(jQuery(this).val()==='fa'){
            jQuery('ul.unstyled>.row.fontawesome',$currentCcModal).show();
            jQuery('ul.unstyled>.row.simple-line-icons',$currentCcModal).hide();
        }else{
            jQuery('ul.unstyled>.row.fontawesome',$currentCcModal).hide();
            jQuery('ul.unstyled>.row.simple-line-icons',$currentCcModal).show();
        }
    });
    jQuery('ul.unstyled>.row>div',$currentCcModal).unbind('click').bind('click',function(e){e.preventDefault();
        jQuery('ul.unstyled>.row>div.active',$currentCcModal).removeClass('active');
        jQuery(this).addClass('active');
        var $iconClass=jQuery(this).children('span.muted').eq(0).text().replace(' ','');
        jQuery('[data-name="cc_icon"]',$currentCcModal).val($iconClass).trigger('input');
    });
    jQuery('[data-name="cc_type"]',$currentCcModal).bind('change',function(){
        if(jQuery(this).val()==='text'){
            jQuery('.fonticon-field-container>.container>.unstyled',$currentCcModal).hide();
        }else{
            jQuery('.fonticon-field-container>.container>.unstyled',$currentCcModal).show();
        }
        jQuery('[data-name="cc_icon"]',$currentCcModal).trigger('input');
    }).change();
    jQuery('[data-name="cc_line_width"],[data-name="cc_text"],[data-name="cc_percent"],[data-name="cc_size"],[data-name="cc_font_size"],[data-name="cc_font_color"],[data-name="cc_color"],[data-name="cc_track_color"]',$currentCcModal).unbind('input').bind('input',function(){
        jQuery('[data-name="cc_icon"]',$currentCcModal).trigger('input');
    });
    jQuery('[data-name="cc_line_cap"]',$currentCcModal).unbind('change').bind('change',function(){
        jQuery('[data-name="cc_icon"]',$currentCcModal).trigger('input');
    });
    
    
    
    jQuery('ul.unstyled>.row>div>.muted',$currentCcModal).each(function(){
        if(jQuery(this).text().trim()===jQuery('[data-name="cc_icon"]',$currentCcModal).val().trim()){
            var $tmp= jQuery(this).closest('.row').hasClass('fontawesome')?'fa':'sl';
            jQuery('[data-name="icon_type"] [value="'+$tmp+'"]',$currentCcModal).attr('selected','selected').siblings('option').removeAttr('selected');
            jQuery('[data-name="icon_type"]',$currentCcModal).change();
            jQuery(this).parent().click();
        }
    });
    
    
}
function pbModalSaveField($from,$to){
    $from.each(function(){
        var $currentField         = jQuery(this).children('.field-data').children('.field');
        var $currentFieldSlug     = $currentField.attr('data-name');
        var $currentFieldType     = $currentField.attr('data-type');
        var $currentFieldTypeOrg  = $currentField.attr('data-type-org');
        var $currentFieldAddButton= $currentField.attr('data-add-button');
        var $currentFieldValue    = $currentField.val();
        switch($currentFieldType){
            case 'select':{
                jQuery('>.field-data>.field[data-name="'+$currentFieldSlug+'"] option[value="'+$currentFieldValue+'"]',$to).attr('selected','selected').siblings().removeAttr('selected').closest('select').trigger('change');
                break;
            }
            case 'textArea':{
                if($currentField.attr('data-tinyMCE')==='true'){
                    tinymce.execCommand('mceAddEditor', false, $currentContentEditor);
                    var $tmpCont=tinymce.get($currentContentEditor).getContent();
                    jQuery('>.field-data>.field[data-name="'+$currentFieldSlug+'"]',$to).html($tmpCont);
                }else{
                    $currentFieldValue=$currentField.html().replace(/&lt;/gi,'<').replace(/&gt;/gi, '>');
                    jQuery('>.field-data>.field[data-name="'+$currentFieldSlug+'"]',$to).html($currentFieldValue);
                }
                break;
            }
            case 'container':{
                var $newContainer = jQuery('>.field-data>.field[data-name="'+$currentFieldSlug+'"]',$to);
                var $template=jQuery('>.field-data>.field[data-name="'+$currentFieldAddButton+'"]',$from).next('.data').children('.field-item').children('.field-data').children('.field').html();
                $template = jQuery('<div/>').append($template);
                $newContainer.html('');
                $currentField.children('.container-item').each(function(){
                    jQuery(this).find('>.content>.field-item>.field-data>.field').each(function(){
                        var $cField         = jQuery(this);
                        var $cFieldSlug     = $cField.attr('data-name');
                        var $cFieldType     = $cField.attr('data-type');
                        var $cFieldValue    = $cField.val();
                        switch($cFieldType){
                            case 'select':{
                                jQuery('.field[data-name="'+$cFieldSlug+'"] option[value="'+$cFieldValue+'"]',$template).attr('selected','selected').siblings().removeAttr('selected');
                                break;
                            }
                            case 'textArea':{
                                $cFieldValue=$cField.html().replace(/&lt;/gi,'<').replace(/&gt;/gi, '>');
                                jQuery('.field[data-name="'+$cFieldSlug+'"]',$template).html($cFieldValue);
                                break;
                            }
                            case 'checkbox':{
                                jQuery('.field[data-name="'+$cFieldSlug+'"]',$template).attr("value",$cField.is(':checked')).attr("checked",$cField.is(':checked'));
                                break;
                            }
                            default:{
                                jQuery('.field[data-name="'+$cFieldSlug+'"]',$template).attr("value",$cFieldValue);
                                break;
                            }
                        }
                    });
                    $newContainer.append($template.html());
                });
                break;
            }
            case 'checkbox':{
                jQuery('>.field-data>.field[data-name="'+$currentFieldSlug+'"]',$to).attr("value",$currentField.is(':checked')).attr("checked",$currentField.is(':checked')).change();
                break;
            }
            default:{
                jQuery('>.field-data>.field[data-name="'+$currentFieldSlug+'"]',$to).attr("value",$currentFieldValue).trigger('input');
                break;
            }
        }
        if($currentFieldTypeOrg==='gallery'){
            jQuery('>.field-data>.field[data-name="'+$currentFieldSlug+'"]',$to).siblings('ul.gallery-images').html($currentField.siblings('ul.gallery-images').html());
        }
    });
}
function pbModalSave($item){
    var $saveTo   = jQuery('.action-container.item-modalled');
    $saveTo.removeClass('item-modalled');
    pbModalSaveField($item.find('.general-field-container').children('.field-item'),jQuery('>.data>.general-field-container>.field-item',$saveTo));
    pbModalSaveField($item.find('.custom-field-container') .children('.field-item'),jQuery('>.data>.custom-field-container>.field-item' ,$saveTo));
}
/* Item Right Left Width */
/* ------------------------------------------------------------------- */
function pbItemRL($item){
    $item=jQuery($item);
    var $itemMarginRL  = parseInt($item.css('margin-left') .replace('px','')     ,10) + parseInt($item.css('margin-right').replace('px','')      ,10);
    var $itemPaddingRL = parseInt($item.css('padding-left').replace('px','')     ,10) + parseInt($item.css('padding-right').replace('px','')     ,10);
    var $itemBorderRL  = parseInt($item.css('border-left-width').replace('px',''),10) + parseInt($item.css('border-right-width').replace('px',''),10);
    var $itemRL = $itemMarginRL+$itemPaddingRL+$itemBorderRL;
    return $itemRL;
}
/* Content Editor */
function pbModalContentEditor($id,$currentEditor){
    var $language = jQuery('html').attr('lang');
    var $currentField = $currentEditor.closest('.field-data');
    $language = $language.substr(0,$language.indexOf('-'));
    var $newEditorDiv= jQuery('<div />').append($currentEditor.clone().attr('id',$id));
    $currentEditor.hide().closest('.field-data').append(
        '<div class="wp-editor-tools hide-if-no-js tmce-active">'+
            '<a class="change-to-html wp-switch-editor switch-html">Text</a>'+
            '<a class="change-to-visual wp-switch-editor switch-tmce">Visual</a>'+
            '<div class="wp-media-buttons"><a href="#" id="insert-media-button" class="button insert-media add_media" data-editor="'+$id+'" title="Add Media"><span class="wp-media-buttons-icon"></span> Add Media</a></div>'+
        '</div>'+
        '<div id="wp-content-editor-container" class="wp-editor-container">'+
            $newEditorDiv.html()+
        '</div>'
    ).promise().done(function(){
        tinymce.init({
            theme:"modern",
            skin:"lightgray",
            language:$language,
            formats:{alignleft:[{selector:'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li', styles: {textAlign:'left'}},{selector: 'img,table,dl.wp-caption', classes: 'alignleft'}],aligncenter: [{selector: 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li', styles: {textAlign:'center'}},{selector: 'img,table,dl.wp-caption', classes: 'aligncenter'}],alignright: [{selector: 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li', styles: {textAlign:'right'}},{selector: 'img,table,dl.wp-caption', classes: 'alignright'}],strikethrough: {inline: 'del'}},
            browser_spellcheck:true,
            fix_list_elements:true,
            entities:"38,amp,60,lt,62,gt",
            entity_encoding:"raw",
            keep_styles:false,
            paste_webkit_styles:"font-weight font-style color",
            preview_styles:"font-family font-size font-weight font-style text-decoration text-transform",
            wpeditimage_disable_captions:false,
            wpeditimage_html5_captions:false,
            plugins:"charmap,hr,media,paste,tabfocus,textcolor,fullscreen,wordpress,wpeditimage,wpgallery,wplink,wpdialogs,wpview,wpfullscreen",
            external_plugins:{twshortcodegenerator:$homeURI+"/framework/js/admin-waves-shortcode.js"},
            selector:$id,
            resize:false,
            convert_urls:false,
            menubar:false,
            wpautop:true,
            indent:false,
            toolbar1:"bold,italic,strikethrough,bullist,numlist,blockquote,hr,alignleft,aligncenter,alignright,link,unlink,wp_more,spellchecker,wp_fullscreen,wp_adv,|,twshortcodegenerator",
            toolbar2:"formatselect,underline,alignjustify,forecolor,pastetext,removeformat,charmap,outdent,indent,undo,redo,wp_help",
            toolbar3:"",
            toolbar4:"",
            tabfocus_elements:"insert-media-button,save-post",
            body_class:"content post-type-page post-status-publish",
            add_unload_trigger:false
        });
        jQuery('a.change-to-html',$currentField).unbind('click').bind('click',function() {
            jQuery(this).closest('.wp-editor-tools').removeClass('tmce-active').addClass('html-active');
            tinymce.execCommand("mceRemoveEditor", true, $id);
        });
        jQuery('a.change-to-visual',$currentField).unbind('click').bind('click',function() {
            jQuery(this).closest('.wp-editor-tools').removeClass('html-active').addClass('tmce-active');
            tinymce.execCommand("mceAddEditor", true, $id);
        }).click();
    });
}
function twSortDragg($container,$items,$placeholder,$connectWith){
    //Sortables
    jQuery($container).sortable({
        items: $items,
        distance: 20,
        placeholder: $placeholder,
        connectWith: $connectWith,
        revert: true,
        update: function(event, ui){
            pbSaveData();
            pbInitEvents();
        },
        start: function(event, ui) {
            var plus;
            if(ui.item.hasClass('col-md-3')) plus = 'col-md-3';
            else if(ui.item.hasClass('col-md-4')) plus = 'col-md-4';
            else if(ui.item.hasClass('col-md-6')) plus = 'col-md-6';
            else if(ui.item.hasClass('col-md-8')) plus = 'col-md-8';
            else if(ui.item.hasClass('col-md-9')) plus = 'col-md-9';
            else if(ui.item.hasClass('col-md-12')) plus = 'col-md-12';
            else plus = '';
            ui.placeholder.addClass(plus);
        }
    });
}
function twInitSortDragg($from,$to){
    var $fromRow = jQuery('>.row-container',$from).clone();
    $to.html('');
    // Rows
    twSortDragg("#pagebuilder-area",">.row-container","row-container placeholding","#pagebuilder-area");
    $fromRow.each(function(){
        $to.append(jQuery(this).clone());
    });
    // Items
    jQuery('>.row-container>.builder-area',$to).html('');
    twSortDragg("#pagebuilder-area>.row-container>.builder-area",">.item","item placeholding","#pagebuilder-area>.row-container>.builder-area");
    jQuery('>.builder-area',$fromRow).each(function($i){
        jQuery('>.row-container>.builder-area',$to).eq($i).html(jQuery(this).html());
    });
    // Draggable
    try{
        jQuery('.pagebuilder-elements-container>.item').draggable({
            connectToSortable: '#pagebuilder-area>.row-container>.builder-area',
            distance: 20,
            helper: 'clone',
            revert: "invalid",
            start : function( event, ui ){
                var $curr       = jQuery(this);
                var $currSlug   = $curr.attr('data-slug');
                var $newElement = jQuery('#items-list>[data-slug="'+$currSlug+'"]').clone();
                $curr.html($newElement.html());
            },
            stop  : function( event, ui ) {
                var $curr       = jQuery(this);
                $curr.children('.list').remove();
                $curr.children('.data').remove();
                twHideToolsMenu();
            }
        });
    }catch(err){}
    jQuery('.pb-add-layout-conteiner').removeClass('loading');
}
function twPublishEnable($status){
    if($status==='enable'){
        jQuery('#publish').removeAttr('disabled').removeClass('button-primary-disabled').siblings('.spinner').css('display','');
    }else{
        jQuery('#publish').attr('disabled','disabled').addClass('button-primary-disabled').siblings('.spinner').css('display','inline');
    }    
}

function twLoadImages(images) {
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
function twHideToolsMenu(){
    jQuery('.add-element.active').removeClass('active').siblings('.pagebuilder-elements-container').stop().slideUp();
    jQuery('#template-save').removeClass('active').children('.template-container').slideUp();
}
function twDlgOpen($dlg){
    jQuery('body').css('overflow','hidden');
    if($dlg.attr('id')!=='pb-delete-modal-container'){
        $dlg.height($dlg.closest('.ui-dialog').height()-149);
    }
}
function twDlgClose($dlg){
    if(jQuery('body>.ui-dialog.tw-pb-main-container').length===1){
        jQuery('body').css('overflow','');
    }
}
function twDlgCloseEditor($dlg){
    if(jQuery('.field-item>.field-data>[data-tinymce="true"]',$dlg).length>0){
        var $currentEditorName='content';
        if(jQuery('#custom-content-list>li[data-content="'+$currentContentEditor+'"]').length>0){
            jQuery('#custom-content-list>li[data-content="'+$currentContentEditor+'"]').remove();
            if(jQuery('#custom-content-list>li').length>0){
                $currentEditorName=jQuery('#custom-content-list>li').eq(-1).attr('data-content');
            }
        }
        window.wpActiveEditor=$currentContentEditor=$currentEditorName;
    }
}
// Resize
jQuery(window).resize(function(){jQuery('body>.ui-dialog>.waves-ui-dialog-content').each(function(){twDlgOpen(jQuery(this));});});