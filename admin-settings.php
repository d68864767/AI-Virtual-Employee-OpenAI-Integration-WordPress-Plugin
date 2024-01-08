<?php
// admin-settings.php - Handles the admin settings interface for the AI Virtual Employee plugin

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Function to add the plugin settings page to the WordPress admin menu
function ai_virtual_employee_add_admin_menu() {
    add_menu_page(
        'AI Virtual Employee Settings', // Page title
        'AI Virtual Employee', // Menu title
        'manage_options', // Capability
        'ai-virtual-employee', // Menu slug
        'ai_virtual_employee_settings_page', // Function to display the settings page
        'dashicons-admin-generic', // Icon URL
        81 // Position
    );
}
add_action('admin_menu', 'ai_virtual_employee_add_admin_menu');

// Function to initialize plugin settings
function ai_virtual_employee_settings_init() {
    register_setting('ai_virtual_employee', 'ai_virtual_employee_settings');

    add_settings_section(
        'ai_virtual_employee_api_key_section', // ID
        __('OpenAI API Key', 'ai-virtual-employee'), // Title
        'ai_virtual_employee_settings_section_callback', // Callback
        'ai_virtual_employee' // Page
    );

    add_settings_field(
        'ai_virtual_employee_text_field_0', // ID
        __('API Key', 'ai-virtual-employee'), // Title
        'ai_virtual_employee_text_field_0_render', // Callback
        'ai_virtual_employee', // Page
        'ai_virtual_employee_api_key_section' // Section
    );
}
add_action('admin_init', 'ai_virtual_employee_settings_init');

// Render the text field for the API key input
function ai_virtual_employee_text_field_0_render() {
    $options = get_option('ai_virtual_employee_settings');
    ?>
    <input type='text' name='ai_virtual_employee_settings[ai_virtual_employee_text_field_0]' value='<?php echo $options['ai_virtual_employee_text_field_0']; ?>'>
    <?php
}

// Settings section callback
function ai_virtual_employee_settings_section_callback() {
    echo __('Enter your OpenAI API key to enable AI functionalities.', 'ai-virtual-employee');
}

// Settings page display callback
function ai_virtual_employee_settings_page() {
    ?>
    <div class="wrap">
        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
        <form action='options.php' method='post'>
            <?php
            settings_fields('ai_virtual_employee');
            do_settings_sections('ai_virtual_employee');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

// Enqueue admin styles and scripts
function ai_virtual_employee_admin_scripts() {
    wp_enqueue_style('ai-virtual-employee-admin-style', plugin_dir_url(__FILE__) . 'admin-style.css');
    wp_enqueue_script('ai-virtual-employee-admin-script', plugin_dir_url(__FILE__) . 'admin-script.js', array('jquery'), null, true);
}
add_action('admin_enqueue_scripts', 'ai_virtual_employee_admin_scripts');
?>
