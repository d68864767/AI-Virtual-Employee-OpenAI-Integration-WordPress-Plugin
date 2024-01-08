<?php
/**
 * Plugin Name: AI Virtual Employee - OpenAI Integration
 * Description: Integrates OpenAI's AI with WordPress, enabling automated tasks and interactive challenges.
 * Version: 1.0
 * Author: Your Name
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Include the necessary files
require_once plugin_dir_path(__FILE__) . 'admin-settings.php';
require_once plugin_dir_path(__FILE__) . 'api-key-manager.php';
require_once plugin_dir_path(__FILE__) . 'task-manager.php';
require_once plugin_dir_path(__FILE__) . 'challenge-manager.php';

// Handle OpenAI API interactions
function handle_openai_request($task_type, $parameters) {
    $api_key = get_option('openai_api_key'); // Retrieve stored API key
    if (!$api_key) {
        return new WP_Error('no_api_key', __('No OpenAI API key has been set.', 'ai-virtual-employee'));
    }

    // Logic to interact with OpenAI API based on task_type and parameters
    // This is a placeholder for the actual API call logic
    $response = 'Response from OpenAI based on task_type and parameters'; // Mock response

    return $response;
}

// Register activation and deactivation hooks
function activate_ai_virtual_employee() {
    // Activation code here, such as setting up database tables or options
    add_option('openai_api_key', ''); // Add an option to store the OpenAI API key
}
register_activation_hook(__FILE__, 'activate_ai_virtual_employee');

function deactivate_ai_virtual_employee() {
    // Deactivation code here, such as cleaning up database tables or options
    delete_option('openai_api_key'); // Remove the stored OpenAI API key option
}
register_deactivation_hook(__FILE__, 'deactivate_ai_virtual_employee');

// Initialize the plugin
function init_ai_virtual_employee() {
    // Initialization code here, such as registering custom post types or taxonomies
}
add_action('plugins_loaded', 'init_ai_virtual_employee');

// Enqueue admin scripts and styles
function ai_virtual_employee_enqueue_admin_scripts() {
    wp_enqueue_script('ai-virtual-employee-admin-script', plugin_dir_url(__FILE__) . 'admin-script.js', array('jquery'), '1.0', true);
    wp_enqueue_style('ai-virtual-employee-admin-style', plugin_dir_url(__FILE__) . 'admin-style.css', array(), '1.0', 'all');
}
add_action('admin_enqueue_scripts', 'ai_virtual_employee_enqueue_admin_scripts');
?>
