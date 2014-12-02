<?php
/*
Plugin Name: Paypal Donation
Plugin URI: http://buffercode.com/paypal-donation-wordpress-plugin/
Description: This PayPal Donation WordPress Plugin gives high level of flexible to admin to share some of the real information for donation. 
Version: 1.2.2
Author: vinoth06
Author URI: http://buffercode.com/
License: GPLv2
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/
// Additing Action hook widgets_init
add_action( 'widgets_init', 'buffercode_paypal_donation'); 

function buffercode_paypal_donation() {
register_widget( 'buffercode_paypal_donation_info' );
}

class buffercode_paypal_donation_info extends WP_Widget {
function buffercode_paypal_donation_info () {
		$this->WP_Widget('buffercode_paypal_donation_info', 'Paypal Donation','Select the category to display');
                }

public function form( $instance ) { 
if ( isset( $instance[ 'buffercode_PDonation_title' ]) ) {
			$buffercode_PDonation_title = $instance[ 'buffercode_PDonation_title' ];
		}
else {
	$buffercode_PDonation_title = 'Donation';
	} 
?>
<p>Custom Title <input maxlength="50" class="widefat" name="<?php echo $this->get_field_name('buffercode_PDonation_title') ?>" type="text" value="<?php echo esc_attr( $buffercode_PDonation_title ); ?>" /></p>
<?php
}

function update($new_instance, $old_instance) {
$instance = $old_instance;
$instance['buffercode_PDonation_title'] = ( ! empty( $new_instance['buffercode_PDonation_title'] ) ) ? strip_tags( $new_instance['buffercode_PDonation_title'] ) : '';
return $instance;
}

function widget($args, $instance) {
extract($args);
echo $before_widget;
$buffercode_PDonation_title = apply_filters( 'widget_title', $instance['buffercode_PDonation_title'] );

/* Buffercode.com wordpress Paypal Donation plugin */

if ( !empty( $name ) ) { echo $before_title . $buffercode_PDonation_title .
$after_title; }

$buffercode_PDonation_expenses_1 = get_option('buffercode_PDonation_expenses_1');
$buffercode_PDonation_expenses_2 = get_option('buffercode_PDonation_expenses_2');
$buffercode_PDonation_expenses_3 = get_option('buffercode_PDonation_expenses_3');
$buffercode_PDonation_expenses_4 = get_option('buffercode_PDonation_expenses_4');
$buffercode_PDonation_expenses_5 = get_option('buffercode_PDonation_expenses_5');

$buffercode_PDonation_expenses_1_1 = get_option('buffercode_PDonation_expenses_1_1');
$buffercode_PDonation_expenses_2_1 = get_option('buffercode_PDonation_expenses_2_1');
$buffercode_PDonation_expenses_3_1 = get_option('buffercode_PDonation_expenses_3_1');
$buffercode_PDonation_expenses_4_1 = get_option('buffercode_PDonation_expenses_4_1');
$buffercode_PDonation_expenses_5_1 = get_option('buffercode_PDonation_expenses_5_1');

$buffercode_PDonation_total = $buffercode_PDonation_expenses_1_1 + $buffercode_PDonation_expenses_2_1 + $buffercode_PDonation_expenses_3_1 + $buffercode_PDonation_expenses_4_1 + $buffercode_PDonation_expenses_5_1;

$buffercode_PDonation_img_url1 = get_option('buffercode_PDonation_img_url1');
$buffercode_PDonation_img_url2 = get_option('buffercode_PDonation_img_url2');
$buffercode_PDonation_img_url3 = get_option('buffercode_PDonation_img_url3');

$buffercode_PDonation_img_url1_def = plugins_url('images/1.png',__FILE__);
$buffercode_PDonation_img_url2_def = plugins_url('images/2.png',__FILE__);
$buffercode_PDonation_img_url3_def = plugins_url('images/3.png',__FILE__);
!empty($buffercode_PDonation_img_url1) ? $buffercode_PDonation_img_url1 : $buffercode_PDonation_img_url1 = $buffercode_PDonation_img_url1_def;
!empty($buffercode_PDonation_img_url2) ? $buffercode_PDonation_img_url2 : $buffercode_PDonation_img_url2 = $buffercode_PDonation_img_url2_def;
!empty($buffercode_PDonation_img_url3) ? $buffercode_PDonation_img_url3 : $buffercode_PDonation_img_url3 = $buffercode_PDonation_img_url3_def;

$buffercode_PDonation_recvamt =get_option('buffercode_PDonation_recvamt');

$buffercode_PDonation_code = get_option('buffercode_PDonation_code');
if(!empty($buffercode_PDonation_recvamt) || $buffercode_PDonation_recvamt != 0)
{
    $buffercode_PDonation_average =(  $buffercode_PDonation_recvamt / $buffercode_PDonation_total ) * 100;
    $buffercode_PDonation_average_round = round($buffercode_PDonation_average,0);
}
else
{
    $buffercode_PDonation_average_round = 0;
    $buffercode_PDonation_average = 0;
}
if($buffercode_PDonation_average < 41 )
{
    echo '<img width="150px" src="'. $buffercode_PDonation_img_url1  .'"  title="donation" style="display: block; margin:0 auto;" />';
}
elseif ($buffercode_PDonation_average > 40 && $buffercode_PDonation_average < 76)
{
    echo '<img width="150px" src="'. $buffercode_PDonation_img_url2  .'"  title="donation" style="display: block; margin:0 auto;" />';
}
else
{
    echo '<img width="150px" src="'. $buffercode_PDonation_img_url3  .'"  title="donation" style="display: block; margin:0 auto;" />';
}
?>
<br /><br /> <b>RECEIVED <i><?php echo  $buffercode_PDonation_average_round; ?> %</i> DONATION</b>
<?php if($buffercode_PDonation_average_round > 2 && $buffercode_PDonation_average_round < 101 ) {?>
    <hr width= "<?php echo $buffercode_PDonation_average_round; ?>%" align = "left"style="border: #000 solid 7px; margin-left:0px;" />
<?php } elseif ($buffercode_PDonation_average_round > 100) { ?>
    <hr width= "100%" style="border: #000 solid 7px" />
<?php }else { ?>
    <br /><br />
<?php }

if(empty($buffercode_PDonation_expenses_1) && empty($buffercode_PDonation_expenses_2)  && empty($buffercode_PDonation_expenses_3)  && empty($buffercode_PDonation_expenses_4) && empty($buffercode_PDonation_expenses_5) ) {echo '<br />';}else{
echo '<table border=0><tr><td colspan=2><b>Expense Details</b></td></tr>';
$buffercode_PDonation_curr_type = get_option('buffercode_PDonation_curr_type');
if(empty($buffercode_PDonation_curr_type)){ $buffercode_PDonation_curr_type = '$'; }
if(!empty($buffercode_PDonation_expenses_1)){ echo '<tr><td>'.$buffercode_PDonation_expenses_1.' - </td>';
echo '<td>'.$buffercode_PDonation_curr_type.$buffercode_PDonation_expenses_1_1.'</td></tr>'; }
if(!empty($buffercode_PDonation_expenses_2)){ echo '<tr><td>'.$buffercode_PDonation_expenses_2.' - </td>';
echo '<td>'.$buffercode_PDonation_curr_type.$buffercode_PDonation_expenses_2_1.'</td></tr>'; }
if(!empty($buffercode_PDonation_expenses_3)){ echo '<tr><td>'.$buffercode_PDonation_expenses_3.' - </td>';
echo '<td>'.$buffercode_PDonation_curr_type.$buffercode_PDonation_expenses_3_1.'</td></tr>'; }
if(!empty($buffercode_PDonation_expenses_4)){ echo '<tr><td>'.$buffercode_PDonation_expenses_4.' - </td>';
echo '<td>'.$buffercode_PDonation_curr_type.$buffercode_PDonation_expenses_4_1.'</td></tr>'; }
if(!empty($buffercode_PDonation_expenses_5)){ echo '<tr><td>'.$buffercode_PDonation_expenses_5.' - </td>';
echo '<td>'.$buffercode_PDonation_curr_type.$buffercode_PDonation_expenses_5_1.'</td></tr>';}
echo '</table><!-- Buffercode.com PayPal Donation WordPress Plugin--><br />';
}
echo $buffercode_PDonation_code;

echo $after_widget;
}
}
// Adding Menu
add_action('admin_menu', 'buffercode_PDonation_menu');

function buffercode_PDonation_menu() {
global $my_settings_page;
	$my_settings_page = add_options_page( 'Paypal Donation', 'Paypal Donation', 'manage_options', __FILE__, 'buffercode_PDonation_menu_setting' );
	//call register settings function
	add_action( 'admin_init', 'buffercode_PDonation_settings' );
        add_action('admin_enqueue_scripts', 'buffercode_PDonation_uploader_scripts');
add_action('admin_enqueue_style', 'buffercode_PDonation_uploader_styles'); 
}

function buffercode_PDonation_settings() {
	register_setting( 'buffercode_PDonation_settings_group', 'buffercode_PDonation_expenses_1' );
                register_setting( 'buffercode_PDonation_settings_group', 'buffercode_PDonation_expenses_1_1' );
                register_setting( 'buffercode_PDonation_settings_group', 'buffercode_PDonation_expenses_2' );
                register_setting( 'buffercode_PDonation_settings_group', 'buffercode_PDonation_expenses_2_1' );
                register_setting( 'buffercode_PDonation_settings_group', 'buffercode_PDonation_expenses_3' );
                register_setting( 'buffercode_PDonation_settings_group', 'buffercode_PDonation_expenses_3_1' );
                register_setting( 'buffercode_PDonation_settings_group', 'buffercode_PDonation_expenses_4' );
                register_setting( 'buffercode_PDonation_settings_group', 'buffercode_PDonation_expenses_4_1' );
                register_setting( 'buffercode_PDonation_settings_group', 'buffercode_PDonation_expenses_5' );
                register_setting( 'buffercode_PDonation_settings_group', 'buffercode_PDonation_expenses_5_1' );
                
                register_setting( 'buffercode_PDonation_settings_group', 'buffercode_PDonation_img_url1' );
                register_setting( 'buffercode_PDonation_settings_group', 'buffercode_PDonation_img_url2' );
	register_setting( 'buffercode_PDonation_settings_group', 'buffercode_PDonation_img_url3' );
        
	register_setting( 'buffercode_PDonation_settings_group', 'buffercode_PDonation_recvamt' );
        
                register_setting( 'buffercode_PDonation_settings_group', 'buffercode_PDonation_code' );
                
                register_setting( 'buffercode_PDonation_settings_group', 'buffercode_PDonation_curr_type' );
                
}

function buffercode_PDonation_menu_setting() {
     $buffercode_PDonation_curr_type = get_option('buffercode_PDonation_curr_type');
?>
<div class="wrap">
    <!-- Buffercode.com PayPal Donation WordPress Plugin-->
<h2>PayPal Donation Setting Page</h2>

<form method="post" action="options.php">
    <?php settings_fields( 'buffercode_PDonation_settings_group' ); ?>
    <?php do_settings_sections( 'buffercode_PDonation_settings_group' );?>
	 
    <table class="form-table">
        <tr valign="top">
            <th>Upload Image</th>
            <td>
                <label for="upload_image">
                    <input placeholder="Image 1"  id="upload_image1" type="text" size="25" name="buffercode_PDonation_img_url1" value="<?php echo get_option('buffercode_PDonation_img_url1') ?>" />
                    <input class="upload_image_button" class="button" type="button" value="Upload Image" /><br />[Upload Image for below 40% Donation]<br />
                    <input placeholder="Image 2"  id="upload_image2" type="text" size="25" name="buffercode_PDonation_img_url2" value="<?php echo get_option('buffercode_PDonation_img_url2') ?>" />
                    <input class="upload_image_button" class="button" type="button" value="Upload Image" />
                     <br />[Upload Image for between 40% to 75% Donation]<br />
                    <input placeholder="Image 3"  id="upload_image3" type="text" size="25" name="buffercode_PDonation_img_url3" value="<?php echo get_option('buffercode_PDonation_img_url3') ?>" /> 
                    <input class="upload_image_button" class="button" type="button" value="Upload Image" />
                   <br />[Upload Image for above 90% Donation]<br />
                    <br />Enter a URL (with http://) or upload an image
                    </label>
            </td>
       </tr>
       <tr valign="top">
       <th>Expenses</th>
           
           <td><input placeholder="Server Cost"  type="text"  name="buffercode_PDonation_expenses_1" value="<?php echo get_option('buffercode_PDonation_expenses_1') ?>" />
            <input placeholder="100"  type="text" size="5" name="buffercode_PDonation_expenses_1_1" value="<?php echo get_option('buffercode_PDonation_expenses_1_1') ?>" /><?php echo $buffercode_PDonation_curr_type; ?><br />
           <input placeholder="Author Salary"  type="text"  name="buffercode_PDonation_expenses_2" value="<?php echo get_option('buffercode_PDonation_expenses_2') ?>" />
            <input placeholder="300"  type="text" size="5" name="buffercode_PDonation_expenses_2_1" value="<?php echo get_option('buffercode_PDonation_expenses_2_1') ?>" /><?php echo $buffercode_PDonation_curr_type; ?><br />
           <input placeholder="Service Cost"  type="text" name="buffercode_PDonation_expenses_3" value="<?php echo get_option('buffercode_PDonation_expenses_3') ?>" />
            <input placeholder="200"  type="text" size="5" name="buffercode_PDonation_expenses_3_1" value="<?php echo get_option('buffercode_PDonation_expenses_3_1') ?>" /><?php echo $buffercode_PDonation_curr_type; ?><br />
           <input placeholder="Others"  type="text" name="buffercode_PDonation_expenses_4" value="<?php echo get_option('buffercode_PDonation_expenses_4') ?>" />
            <input placeholder="140"  type="text" size="5" name="buffercode_PDonation_expenses_4_1" value="<?php echo get_option('buffercode_PDonation_expenses_4_1') ?>" /><?php echo $buffercode_PDonation_curr_type; ?><br />
           <input placeholder="Others"  type="text" name="buffercode_PDonation_expenses_5" value="<?php echo get_option('buffercode_PDonation_expenses_5') ?>" />
            <input placeholder="580"  type="text" size="5" name="buffercode_PDonation_expenses_5_1" value="<?php echo get_option('buffercode_PDonation_expenses_5_1') ?>" /><?php echo $buffercode_PDonation_curr_type; ?>
           </td>
       </tr>
       
       <tr  valign="top">
           <th>Received Amount</th>
           <td><input placeholder="150"  type="text" size="5" name="buffercode_PDonation_recvamt" value="<?php echo get_option('buffercode_PDonation_recvamt') ?>" /><?php echo get_option('buffercode_PDonation_curr_type') ?></td>
       </tr>
      
       
       <tr  valign="top">
           <th>Currency Type</th>
           <td>
       <select name="buffercode_PDonation_curr_type" >
            <?php
            $buffercode_PDonation_curr_options = array('$'=>'1', '€' =>'2','£' =>'3','¢'=>'4','Rs'=>'5');
            foreach ($buffercode_PDonation_curr_options as $buffercode_PDonation_curr_value => $buffercode_PDonation_curr_target_code) {
            echo '<option value="' . $buffercode_PDonation_curr_value . '" id="' . $buffercode_PDonation_curr_target_code . '"', $buffercode_PDonation_curr_type == $buffercode_PDonation_curr_value ? ' selected="selected"' : '', '>', $buffercode_PDonation_curr_value, '</option>';
            }?>	
       </select>
               <?php echo  $buffercode_PDonation_curr_type; ?>
           </td>
       </tr>
              
       <tr  valign="top">
           <th>Paypal Code</th>
           <td><textarea placeholder="paste your paypal code" rows="5" cols="40"  type="text" name="buffercode_PDonation_code" value=""><?php echo get_option('buffercode_PDonation_code') ?></textarea></td>
       </tr>
       
       <tr valign="top">
            <td>Designed by - <a href="http://buffercode.com">Buffercode</a></td>
        </tr>

       <tr valign="top">
          <td><?php submit_button();  ?></td>
        </tr>
    </table>
    
</form>
</div>
<?php 
} 

function buffercode_PDonation_uploader_scripts($hook_suffix) {
global $my_settings_page;
if ( $my_settings_page == $hook_suffix )
{
    wp_enqueue_script('media-upload');
    wp_enqueue_script('thickbox');
    wp_enqueue_script( 'paypal-script', plugin_dir_url( __FILE__ ) . '/js/upload-js.js' );
}
}

function buffercode_PDonation_uploader_styles() {
wp_enqueue_style('thickbox');
}


register_deactivation_hook( __FILE__, 'buffercode_PDonation_deactive' );

function buffercode_PDonation_deactive() {
	delete_option( 'buffercode_PDonation_expenses_1' );
	delete_option( 'buffercode_PDonation_expenses_1_1' );
	delete_option( 'buffercode_PDonation_expenses_2' );
	delete_option( 'buffercode_PDonation_expenses_2_1' );
	delete_option( 'buffercode_PDonation_expenses_3' );
	delete_option( 'buffercode_PDonation_expenses_3_1' );
	delete_option( 'buffercode_PDonation_expenses_4' );
	delete_option( 'buffercode_PDonation_expenses_4_1' );
	delete_option( 'buffercode_PDonation_expenses_5' );
	delete_option( 'buffercode_PDonation_expenses_5_1' );
	delete_option( 'buffercode_PDonation_img_url1' );
	delete_option( 'buffercode_PDonation_img_url2' );
	delete_option( 'buffercode_PDonation_img_url3' );
	delete_option( 'buffercode_PDonation_recvamt' );
	delete_option( 'buffercode_PDonation_code' );
                }
?>