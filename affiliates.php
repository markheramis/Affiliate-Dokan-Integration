<?php

add_action('plugins_loaded', 'affiliates_dokan_plugins_loaded_affiliates_main');
if (!function_exists('affiliates_dokan_plugins_loaded_affiliates_main')) {

    function affiliates_dokan_plugins_loaded_affiliates_main() {
	
    }

}

function dokan_affiliate_on_create_affiliate($user_id, $data) {
    $postdata = $_POST;
    if ($data['role'] != 'customer' && $postdata['role'] != 'affiliate') {
	return;
    }
    $userdata = array(
	'user_email' => $data['user_email'],
	'user_login' => $data['user_login'],
	'first_name' => $_POST['fname'],
	'last_name' => $_POST['lname'],
	'user_url' => ''
    );
    Affiliates_Registration::store_affiliate($user_id, $userdata);
}

add_action('woocommerce_created_customer', 'dokan_affiliate_on_create_affiliate', 10, 2);

function dokan_affiliate_registration_redirect_affiliate($var) {
    $url = $var;
    
    return $url;
}

add_filter('woocommerce_registration_redirect', 'dokan_affiliate_registration_redirect_affiliate', 10, 1);
