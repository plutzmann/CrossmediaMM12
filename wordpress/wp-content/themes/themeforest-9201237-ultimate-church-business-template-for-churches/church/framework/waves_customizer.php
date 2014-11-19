<?php
function waves_customizer($wp_customize){
    global $waves_cus;
    
    //  ======== LOOP - START =====================
    foreach($waves_cus as $section_id=>$section){
        //-------------------Section-------------------
        //---------------------------------------------
        $wp_customize->add_section( $section_id, array(
            'title'          => $section['title'],
            'priority'       => $section['priority'],
            'description'    => $section['description'],
        ));
            //  ======== LOOP - START =====================
            foreach ($section['options'] as $option){
                update_option($option['setting']['id'],tw_option($option['setting']['id']));
                //-------------------Setting-------------------
                $wp_customize->add_setting( $option['setting']['id'], array(
                    'default'  => $option['setting']['default'],
                    'type'     => $option['setting']['type'],
                    'transport'=> $option['setting']['transport']
                ) );
                //-------------------Control-------------------
                $wp_customize->add_control($option['control']['id'], array(
                    'label'    => $option['control']['label'],
                    'section'  => $section_id,
                    'settings' => $option['setting']['id'],
                    'type'     => $option['control']['type'],
                    'choices'  => $option['control']['choices']
                ) );
            }
            //  ======== LOOP - END =====================
    }
    //  ======== LOOP - END =====================
}
add_action('customize_register','waves_customizer');

global $waves_cus;
$waves_cus=array(
    'waves_new_options'=>array(
        'title'=>'New Options',
        'priority'=>35,
        'description'=>'Modify theme',
        'options'=>array(
            array(
                'setting'=>array(
                    'id'=>'menu_position',
                    'default'=>'top',
                    'type' => 'option',
                    'transport'=>'refresh',//'postMessage'
                ),
                'control'=>array(
                    'id'=>'waves_menu_position',
                    'label'=>'Menu Position',
                    'type'=>'select',
                    'choices'    => array(
                        'top'=>'Static Top',
                        'fixed'=>'Fixed Top',// EX. 'left'=>"Left Sidebar" OR 'right'=>"Right Sidebar"
                    ),
                )
            ),
        ),
    ),
);

add_action('customize_save_after', 'waves_customizer_save');
function waves_customizer_save( $wp_customize ) {
    global $waves_cus;
    $data=array();
    foreach($waves_cus as $section_id=>$section){
        foreach ($section['options'] as $option){
            $setting_id=$option['setting']['id'];
            $data[$setting_id]=get_option($setting_id);
        }
    }
    of_save_options($data);
}