<?php
/*
Plugin Name: SVS Pricing Tables
Plugin URI: http://svs-websoft.com
Description: Pricing tables made easy.
Author: SVS WebSoft
Version: 1.0.4
Author URI: http://svs-websoft.com
*/

// Check if file is called directly
if (!defined('WPINC')) {
    die;
}

require_once "app/controller/svs_pt_controller_main.php";
require_once "app/model/svs_pt_model_main.php";

// plugin entry point
$svs_pricing_tables_controller = new SVS_PT_Controller_Main($wpdb);

// Create table structure on plugin install
register_activation_hook(__FILE__, array($svs_pricing_tables_controller, "createDatabase"));


// Add admin menu "SVS Pricing Tables"

add_action('admin_menu', 'svs_pricing_tables_menu');

function svs_pricing_tables_menu()
{
    global $svs_pricing_tables_controller;
    add_menu_page('SVS Pricing Tables', 'Pricing Tables', 'manage_options', 'svs_pricing_tables', array($svs_pricing_tables_controller,'index'), 'dashicons-list-view');
}

// Enqueue scripts
add_action('admin_enqueue_scripts', array('SVS_PT_Controller_Main', 'adminEnqueueScripts'));


// Register shortcodes
add_shortcode('svs_pricing_tables', array($svs_pricing_tables_controller, 'pricingTablesShortcode'));