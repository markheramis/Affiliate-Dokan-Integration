<?php

/**
 * @todo create a dynamic template search engine using the wordpress template search API
 * @param type $slug the slug of the template file.
 * @param type $name the name of the template file.
 * @param type $args the array to be extracted to the template file.
 */
function affiliate_dokan_template_part($slug, $name = '', $args = array()) {
    $defaults = array(
	'pro' => false
    );
    $args = wp_parse_args($args, $defaults);
    if ($args && is_array($args)) {
	extract($args);
    }
    $tmp_path = plugin_dir_path(__FILE__) . "/template/$slug-$name.php";
    include_once($tmp_path);
}


