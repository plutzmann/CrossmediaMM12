jQuery(function(){
    waves_init_demo_actions();
});
function waves_reset_demo_backuplist(){
    jQuery.ajax({
        type: "POST",
        url: window.location,
        success: function(response){
            if(jQuery('#waves-demo-backup-list-container',response).attr('id')==='waves-demo-backup-list-container'){
                jQuery('#waves-demo-backup-list-container').html(jQuery('#waves-demo-backup-list-container',response).html());
                waves_init_demo_actions();
            }
        }
    });
}
function waves_init_demo_actions(){
    jQuery('#waves-demo-list-container>li>.demo-buttons>.button').unbind('click').bind('click', function(e){e.preventDefault();
        var $curr=jQuery(this);
        var $action=$curr.hasClass('active-demo-with-content')?'active-demo-with-content':'active-demo';
        var $currCont=$curr.closest('li');
        var $demoSlug=$currCont.data('slug');
        var $demoMenu=$currCont.data('menu');
        jQuery('html,body').animate({scrollTop: 0}, 500);
        if($action==='active-demo-with-content'){
            jQuery('#waves-demo-notice-container .active').removeClass('active');
        }
        jQuery('#waves-demo-container .button').attr('disabled', 'disabled');
        jQuery('#waves-'+$action+'-notice>.default').addClass('active').siblings('.ajax').removeClass('active');
        
        jQuery.ajax({
            type: "POST",
            url: ajaxurl,
            data: {
                action   :'waves-'+$action,
                demo_slug:$demoSlug,
                demo_menu:$demoMenu
            },
            success: function(response){
                jQuery('#waves-demo-container .button').removeAttr('disabled');
                if(jQuery('.succes',response).text()!==''){
                    jQuery('#waves-'+$action+'-notice>.ajax').removeClass('error').addClass('succes').addClass('active').text(jQuery('.succes',response).text()).siblings('.default').removeClass('active');
                }else if(jQuery('.error',response).text()!==''){
                    jQuery('#waves-'+$action+'-notice>.ajax').removeClass('succes').addClass('error').addClass('active').text(jQuery('.error',response).text()).siblings('.default').removeClass('active');
                }
                if($action==='active-demo-with-content'){
                    $curr.siblings('.active-demo').click();
                }else{
                    waves_reset_demo_backuplist();
                }
            }
        });
    });
    jQuery('#waves-demo-backup-list-container>li>.demo-backup-buttons>.button').unbind('click').bind('click', function(e){e.preventDefault();
        var $curr=jQuery(this);
        var $action=$curr.hasClass('restore-backup')?'restore-backup':'delete-backup';
        var $currCont=$curr.closest('li');
        var $backupID=$currCont.data('id');
        jQuery('html,body').animate({scrollTop: 0}, 500);
        jQuery('#waves-demo-notice-container .active').removeClass('active');
        jQuery('#waves-demo-container .button').attr('disabled', 'disabled');
        jQuery('#waves-backup-notice>.active').removeClass('active');
        if($action==='restore-backup'){
            jQuery('#waves-backup-notice>.restore').addClass('active');
        }else{
            jQuery('#waves-backup-notice>.delete').addClass('active');
        }
        
        jQuery.ajax({
            type: "POST",
            url: ajaxurl,
            data: {
                action   :'waves-backup-action',
                type     :$action,
                backup_id:$backupID
            },
            success: function(response){
                jQuery('#waves-demo-container .button').removeAttr('disabled');
                if(jQuery('.succes',response).text()!==''){
                    jQuery('#waves-backup-notice>.ajax').removeClass('error').addClass('succes').addClass('active').text(jQuery('.succes',response).text()).siblings('.active').removeClass('active');
                }else if(jQuery('.error',response).text()!==''){
                    jQuery('#waves-backup-notice>.ajax').removeClass('succes').addClass('error').addClass('active').text(jQuery('.error',response).text()).siblings('.active').removeClass('active');
                }
                waves_reset_demo_backuplist();
            }
        });
    });
}