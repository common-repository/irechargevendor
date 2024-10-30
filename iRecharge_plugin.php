<?php
/**
 * @package iRechargeVendor
 * @version 3.0
 */
/*
Plugin Name: iRechargeVendor
Plugin URI: http://irecharge.com.ng/
Description: This plugin enables your website visitors to recharge their mobile linee and power utilities. All major telecommunication networks in Nigeria are supported while for power utilities are ranged within AEDC, IKEDC, KEDCO, IBEDC, PHEDc, KAEDCO, JED also within Nigeria. To get started: 1) Click the "Activate" link to the left of this description, 3) Go through the Settings and select 'iRecharge Vendor Set' to set your Vendor ID, this is displayed on your profile at irecharge.com.ng/profile 4) put [irecharge] on any page area you want the plugin to appear.
Author: Komolafe Schneider, IST Nigeria
Contributor: Layi Funsho, IST Nigeria
Version: 3.0
Author URI: http://schneider@istrategytech.com/
License: GPLv2
*/



function process(){
    if(isset($_POST['dashboardId'])){
        if(wp_verify_nonce($_POST['crypt'], 'submit_vendor_id')){
            $ir_vendor_id = sanitize_text_field($_POST['dashboardId']);

            if ( $ir_vendor_id == null || strlen( $ir_vendor_id ) < 6  )  {
                wp_die( __( 'Please Enter a Valid Vendor ID' ) );
            }else
                update_option('dashboardId', $ir_vendor_id);
                ?>
                <div class="updated"><p><strong><?php _e('Options saved.'); ?></strong></p></div>
                <?php
        }else{
            //Normal page display
            $ir_vendor_id = get_option('dashboardId');
        }   
    }
}

add_action('init', 'process');

//admin settings
add_action('admin_menu', 'adminActions');
add_action('admin_init', 'initFields'); //to initialize our setting fields
//create short code for display 
add_action('init', 'ist_ir_register_shortcodes');
//register for script loader
add_action('wp_enqueue_scripts', 'irecharge_ext_init');



//function to add admin sublevel menu
function adminActions() {
    add_options_page("iRecharge Vendor Set", "iRecharge Vendor Set", "manage_options", "iRecharge-Vendor-Set", "istAdmin");
}


//function to initialize the settings fields
function initFields()
{
    register_setting('fieldGroup', 'irecharge_vendor_id');
}

//function to display form when the settings sublink is clicked on
function istAdmin()
{

    if ( !current_user_can( 'manage_options' ) )  {
        wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
    }
    //include('/istAdmin.php');
    ?>
        <div class='wrap'>
            <?php screen_icon(); ?>
            <h2>iRecharge Vendor Settings</h2><hr/>
            <form action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>" method="post">
                <?php settings_fields('fieldGroup'); ?>
                <?php @do_settings_fields('fieldGroup'); ?>
                <table class="form-table">
                    <tr valid="top">
                        <th scope="row"><label for="dashboardId">iRecharge Vendor ID</label></th>
                        <td>
                            <input type="hidden" name="crypt" value="<?php echo wp_create_nonce('submit_vendor_id') ?>">
                            <input type="text" name="dashboardId" id="dashboard_vendorid" value="<?php echo get_option('dashboardId'); ?>" />
                            <br/><small>Enter your iRecharge Vendor ID</small>
                        </td>
                    </tr>
                </table><?php @submit_button(); ?>
            </form>
        </div>
    <?php

}

//function to add shortcode
function ist_ir_register_shortcodes() {
    add_shortcode('irecharge','content');
}

//make plugin show on page with registered shortcode
function content($args, $content)
{
    //Connect to the  updated option
    $ir_vendor_id = get_option('dashboardId');

    if($ir_vendor_id){ //if we get something, then display the widget

        echo    "<div id='tab-container' class='tab-container'>
                <ul class='nav nav-tabs'>
                <li class='active'><a data-toggle='tab' href='#home'>Airtime</a></li>
                <li><a data-toggle='tab' href='#menu1'>Power</a></li>
                </ul>

                <div class='tab-content'>
                <div id='home' class='tab-pane fade in active'>
                    <form action='' method=POST id='topup_form8975'>
                            <div id='topup_formxyz'><div id='left12345'>
                                <img src='img/logo.png' width='36' alt='irecharge' align='absmiddle'> iRecharge
                            </div>  
                            <div id='right12345'>
                                <img src='img/mtn.png' alt='mtn'>
                                <img src='img/airtel.png' alt='airtel'>
                                <img src='img/glo.jpg' alt='glo'>
                                <img src='img/etisalat.jpg' alt='etisalat'>
                            </div>
                            <div style='clear:both; line-height:0; height:0; overflow:hidden'></div>
                            </div>
                            <span id='topup_display_message123'>Instantly recharge your mobile phone. Major networks supported.</span>

                            <input type='hidden' name='vendorId' id='vendorId' value='$ir_vendor_id'>
                            <br>

                            <select required name='selected_network' id='selected_network'>
                                <option value=''>Select a network</option>
                                <option value='MTN'>MTN</option>
                                <option value='Glo'>GLO</option>
                                <option value='Etisalat'>Etisalat</option>
                                <option value='Airtel'>Airtel</option>
                            </select>
                            </br>
                            <input type='number' name='vtu_amount' id='vtu_amount' value='' placeholder='Enter amount' autocomplete='off' required>

                            <input type='phone' name='vtu_number' id='vtu_number' value='' placeholder='Enter phone number' autocomplete='off' minlength='11' required></br>

                            <input type='email' name='vtu_email' id='vtu_email' value='' size = '30' placeholder='Email address to send receipt' autocomplete='off' required></br>

                            <input type='button' value='Recharge Airtime' id='irecharge_airtime_button'></br>
                        </form>
                </div>
                <div id='menu1' class='tab-pane fade'>
                    <form action='' method=POST id='topup_form8975'>
                            <div id='topup_formxyz'><div id='left12345'>
                                <img src='img/logo.png' width='36' alt='irecharge' align='absmiddle'> iRecharge
                            </div>  
                            <div id='right12345'>
                                <img src='img/aedc.png' alt='AEDC'>
                                <img src='img/eko.png' alt='Eko'>
                                <img src='img/ibedc.png' alt='Ibadan Electricity'>
                                <img src='img/ikeja.jpg' alt='Ikeja Eletricity'>
                            </div>
                            <div style='clear:both; line-height:0; height:0; overflow:hidden'></div>
                            </div>
                            <span id='topup_display_message123'>Instantly recharge your Digital meter phone with the available networks supported.</span>

                            <input type='hidden' name='vendorId' id='vendorId' value='$ir_vendor_id'>
                            <br>
                            <select id='power_service' name='recharge_power_service'>
                                <option value=''>Select Utility</option>
                                <option value='AEDC'>AEDC Prepaid</option>
                                <option value='Ikeja_Electric_Bill_Payment'>Ikeja Postpaid</option>
                                <option value='Ikeja_Token_Purchase'>Ikeja Prepaid</option>
                                <option value='Eko_Prepaid'>Eko Prepaid</option>
                                <option value='Eko_Postpaid'>Eko Postpaid</option>
                                <option value='Ibadan_Disco_Prepaid'>Ibadan Prepaid</option>
                                <option value='Kano_Electricity_Disco'>Kedco Electricity</option>
                                <option value='Kaduna_Electricity_Disco'>Kaedco Electricity</option>
                                <option value=Jos_Disco>Jos Electricity Disco</option>
                                <option value=PhED_Electricity>PhED Electricity</option>
                            </select>
                            </br>
                            <input type='number' name='recharge_power_meter' id='power_meter' value='' placeholder='Enter Meter Number' autocomplete='off' required>

                             <input type='number' name='recharge_meter_amount' id='power_amount' value='' placeholder='Enter Amount' autocomplete='off' required>

                            <input type='email' name='recharge_power_email' id='power_email' value='' placeholder='Email address to send receipt' autocomplete='off' required>

                             <input type='number' name='recharge_power_number' id='power_number' value='' placeholder='Enter your phone number. No country code' autocomplete='off' minlength='11' required>

                            <input type='button' value='Recharge Power' id='irecharge_power_button'></br>

                        </form>
                </div>

            </div>
            
            <div style='border-top:solid thin #eee; padding:10px 0 10px 0; margin-top:10px; font-size:0.8em; text-align:left;' id='top_up_support123'>For support or enquiries
                <a href='http://www.facebook.com/irechargeng' target='_blank'>
                <img src='img/facebook_circle.png' alt='call' align='absmiddle'>
                </a>
                <a href='https://twitter.com/@i_recharge' target='_blank'>
                <img src='img/twitter_circle.png' alt='call' align='absmiddle'></a> 
                <br/>
                <img src='img/call.png' alt='call' align='absmiddl'> 
                    0700-isupport (0700-47877678)<br/>
                <a href='mailto:support@irecharge.com.ng'>
                    <img src='img/email.png' alt='call' align='absmiddle'> support@irecharge.com.ng
                </a>
            </div>";

    }
    else{ //else return null
        return 'null';
    }

}

//function to load external script
function irecharge_ext_init()

{
    wp_register_script('irecharge_pluginscript.js',plugins_url('js/irecharge_pluginscript.js',__FILE__), array('jquery'), '', true);
    wp_register_script('bootstrap.min.js',plugins_url('js/bootstrap.min.js',__FILE__), array('jquery'), '', true);
    wp_register_script('irecharge_jquerycookie.js',plugins_url('js/jquery_cookie.js',__FILE__), array('jquery'), '', true);
    wp_register_style( 'irecharge_pluginstyle.css', plugins_url('css/irecharge_pluginstyle.css', __FILE__), array());
    wp_register_style( 'bootstrap.min.css', plugins_url('css/bootstrap.min.css', __FILE__), array());

    wp_enqueue_scripts('jquery');
    wp_enqueue_scripts('irecharge_jquerycookie.js');
    wp_enqueue_scripts('irecharge_pluginscript.js');
    wp_enqueue_style('irecharge_pluginstyle.css');
    wp_enqueue_scripts('bootstrap.min.js');
    wp_enqueue_style('bootstrap.min.css');
    
}
