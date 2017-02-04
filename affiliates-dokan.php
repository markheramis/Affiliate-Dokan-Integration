<?php

/**
 * affiliates-dokan.php
 * 
 * Copyright (c) 2016 "Mark" Mark Heramis
 * 
 * This code is released under the GNU General Public License.
 * See COPYRIGHT.txt and LICENSE.txt.
 * 
 * This code is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * This header and all notices must be kept intact.
 * 
 * @author Mark Heramis
 * @package affiliates-dokan
 * @since affiliates-dokan 1.0.0
 *
 * Plugin Name: Affiliates-Dokan
 * Plugin URI: http://www.github.com/affiliates-dokan
 * Description: Integration between affiliates plugin and dokan multi-vendor plugin
 * Version: 1.0.0
 * Author: Mark Heramis
 * Author URI: http://www.markheramis.com
 * Donate-Link: http://www.markheramis.com
 */
include_once('util.php');

include_once('dokan.php');
include_once('affiliates.php');

function affiliates_dokan_after_user_registration($user_id) {
    $postdata = $_POST;
    $user = new WP_User($user_id);
    $role = reset($user->roles);
    if ($role == 'seller') {
	if (dokan_get_option('new_seller_enable_selling', 'dokan_selling') == 'off') {
	    update_user_meta($user_id, 'dokan_enable_selling', 'no');
	} else {
	    update_user_meta($user_id, 'dokan_enable_selling', 'yes');
	}
    }
}

function affiliates_dokan_plugins_loaded_affiliate_dokan_registration() {
    remove_action('user_register', 'dokan_admin_user_register');
    add_action('user_register', 'affiliates_dokan_after_user_registration', 10, 1);
}

add_action('plugins_loaded', 'affiliates_dokan_plugins_loaded_affiliate_dokan_registration');
