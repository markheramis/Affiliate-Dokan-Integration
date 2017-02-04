<?php

if (!function_exists('affiliates_dokan_woocommerce_registration_form_fields')) {

    function affiliates_dokan_woocommerce_registration_form_fields() {
	$postdata = $_POST;
	$role = isset($postdata['role']) ? $postdata['role'] : 'customer';
	$role_style = ( $role == 'customer' ) ? ' style="display:none"' : '';
	affiliate_dokan_template_part('form', 'registration', array(
	    'postdata' => $postdata,
	    'role' => $role,
	    'role_style' => $role_style
	));
    }

}
if (!function_exists('affiliates_dokan_seller_registration_error')) {
    /**
     * Validates seller registration form from my-account page
     *
     * @param WP_Error $error
     * @return \WP_Error
     */
    function affiliates_dokan_seller_registration_error($error) {
	$allowed_roles = apply_filters('dokan_register_user_role', array('customer', 'seller','affiliate'));
	// is the role name allowed or user is trying to manipulate?
	if (isset($_POST['role']) && !in_array($_POST['role'], $allowed_roles)) {
	    return new WP_Error('role-error', __('Cheating, eh?', 'dokan'));
	}
	// TEMPORARY SOLUTION
	if (isset($_POST['role'])) {
	    $role = $_POST['role'];
	    if ($role == 'seller') {

		$first_name = trim($_POST['fname']);
		if (empty($first_name)) {
		    return new WP_Error('fname-error', __('Please enter your first name.', 'dokan'));
		}
		$last_name = trim($_POST['lname']);
		if (empty($last_name)) {
		    return new WP_Error('lname-error', __('Please enter your last name.', 'dokan'));
		}
		$phone = trim($_POST['phone']);
		if (empty($phone)) {
		    return new WP_Error('phone-error', __('Please enter your phone number.', 'dokan'));
		}
	    }
	}
	// END TEMPORARY SOLUTION
	return $error;
    }

}
if (!function_exists('affiliates_dokan_plugins_loaded_dokan_main')) {

    function affiliates_dokan_plugins_loaded_dokan_main() {
	remove_action('register_form', 'dokan_seller_reg_form_fields');
	add_action('register_form', 'affiliates_dokan_woocommerce_registration_form_fields');

	remove_filter('woocommerce_process_registration_errors', 'dokan_seller_registration_errors');
	remove_filter('registration_errors', 'dokan_seller_registration_errors');

	add_filter('woocommerce_process_registration_errors', 'affiliates_dokan_seller_registration_error');
	add_filter('registration_errors', 'affiliates_dokan_seller_registration_error');
    }

}
add_action('plugins_loaded', 'affiliates_dokan_plugins_loaded_dokan_main');
