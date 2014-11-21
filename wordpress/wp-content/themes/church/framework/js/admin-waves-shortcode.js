var $twInsertShortcodeWaiting=false;
(function() {
    tinymce.PluginManager.requireLangPack('twshortcodegenerator');
    tinymce.create('tinymce.plugins.twshortcodegenerator', {
        init : function(ed, url) {
            ed.addCommand('twshortcodegenerator', function() {
                jQuery( '<div id="shortcode_container_dialog" data-current="none" />').append(jQuery('#tw-shortcode-template').html()).dialog({
                    title: 'Select the Shortcode',
                    resizable: true,
                    width: 800,
//                    height: 500,
                    modal: true,
                    open: function(){
                        jQuery(this).closest('.ui-dialog-content').removeClass('ui-dialog-content').addClass('waves-ui-dialog-content');
                        jQuery(this).closest('.ui-dialog').addClass('tw-pb-main-container');
                        jQuery(this).closest('.ui-dialog').focus();
                        pbModalInitActions(jQuery(this));
                        twDlgOpen(jQuery(this));
                    },
                    close: function(e){e.preventDefault();
                        twDlgClose(jQuery(this));
                        jQuery(this).closest('.ui-dialog').remove();
                        jQuery('body>#shortcode_container_dialog').remove();
                    },
                    buttons: {
                        "Done": function() {
                            var $curr=jQuery(this);
                            $twInsertShortcodeWaiting=true;
                            twInsertShortcode();
                            jQuery('[id="shortcode_container_dialog"]').eq(-1).addClass('loading-shortcode');
                            jQuery('[id="shortcode_container_dialog"]').eq(-1).siblings('.ui-dialog-titlebar').find('.ui-dialog-titlebar-close').hide();
                            jQuery('[id="shortcode_container_dialog"]').eq(-1).siblings('.ui-dialog-buttonpane').find('.ui-dialog-buttonset').hide();
                            $twInsertShortcodeWaitingInt=setInterval(function(){
                                if($twInsertShortcodeWaiting===false){
                                    clearInterval($twInsertShortcodeWaitingInt);
                                    $curr.dialog("close");
                                }
                            },100);
                        },
                        "Cancel": function() {
                            jQuery(this).dialog("close");
                        }
                    }
                });
            });
            ed.addButton('twshortcodegenerator', {title : 'ThemeWaves Shortcode Generator',cmd : 'twshortcodegenerator',image : url + '/../images/iconsmall.png'})
        },
        createControl : function(n, cm) {return null;},
        getInfo : function() {return {longname : "Shortcode",author : '',authorurl : '',infourl : '',version : "1.0"};}
    });
    tinymce.PluginManager.add('twshortcodegenerator', tinymce.plugins.twshortcodegenerator);
})();
// Functions
function twGetShortcode($itemSlug){
    jQuery('[id="shortcode_container_dialog"]').eq(-1).addClass('loading-shortcode');
    jQuery('[id="shortcode_container_dialog"]').eq(-1).children('.custom-field-container').html('');
    jQuery.ajax({
        type: "POST",
        url: ajaxurl,
        data: {
            'action':'waves_shortcode_modal',
            'shortcode_name':$itemSlug
        },
        success: function(response){
            jQuery('[id="shortcode_container_dialog"]').eq(-1).children('.custom-field-container').html(jQuery(response).find('.data>.custom-field-container').first().html());
            jQuery('[id="shortcode_container_dialog"]').eq(-1).attr('data-current',$itemSlug).removeClass('loading-shortcode');
            pbModalInitActions(jQuery('[id="shortcode_container_dialog"]').eq(-1));
        }
    });
}
function twInsertShortcode(){
    var $shortcodeContainer = jQuery('[id="shortcode_container_dialog"]').eq(-1);
    var $itemSlug = $shortcodeContainer.attr('data-current');
    if($itemSlug!=='none'){
        var item = '';
        $shortcodeContainer.each(function(){
            var $currentItem=jQuery(this);
            item += '{"slug":"'+$itemSlug+'","size":"shortcode-size",';
            item += '"settings":{';
            jQuery('.custom-field-container>.field-item>.field-data>.field',$currentItem).each(function(index){
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
                                    item += '"'+$currentContainerItemField.attr('data-name')+'":"'+encodeURIComponent($currentContainerItemField.val())+'"';
                                });
                            item += '}';
                        });
                    item += '}';
                }else{
                    item += '"'+$currentField.attr('data-name')+'":"'+encodeURIComponent($currentField.val())+'"';
                }
            }).promise().done(function(){
                item +='}}';
            });
        }).promise().done(function(){
            jQuery.ajax({
                type: "POST",
                url : ajaxurl,
                data: {
                    'action':'waves_shortcode_print',
                    'data':encodeURIComponent(item)
                },
                success: function(response){
                    window.tinymce.get($currentContentEditor).insertContent(response);
                    $twInsertShortcodeWaiting=false;
                }
            });
        });
    }else{
        $twInsertShortcodeWaiting=false;
    }
}