jQuery(document).ready(function(){
    jQuery('.field-waves.field-waves-is-mega input').live('change',function(){
        if(jQuery(this).is(':checked')){
            jQuery(this).closest('.field-waves').siblings('.field-waves.field-waves-column').show();
        }else{
            jQuery(this).closest('.field-waves').siblings('.field-waves.field-waves-column').hide();
        }
    }).change();
});