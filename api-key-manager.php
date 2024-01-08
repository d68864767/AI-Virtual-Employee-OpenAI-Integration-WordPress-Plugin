<?php
// api-key-manager.php - Manages the storage and retrieval of the OpenAI API key

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Function to retrieve the OpenAI API key from the database
function get_openai_api_key() {
    // Retrieve the API key from the 'ai_virtual_employee_settings' option
    $options = get_option('ai_virtual_employee_settings');
    return isset($options['ai_virtual_employee_text_field_0']) ? $options['ai_virtual_employee_text_field_0'] : '';
}

// Function to update the OpenAI API key in the database
function update_openai_api_key($new_api_key) {
    // Get the current options array from the database
    $options = get_option('ai_virtual_employee_settings');
    
    // Update the API key in the options array
    $options['ai_virtual_employee_text_field_0'] = sanitize_text_field($new_api_key);
    
    // Update the options array in the database
    update_option('ai_virtual_employee_settings', $options);
}

// Function to delete the OpenAI API key from the database
function delete_openai_api_key() {
    // Get the current options array from the database
    $options = get_option('ai_virtual_employee_settings');
    
    // Remove the API key from the options array
    unset($options['ai_virtual_employee_text_field_0']);
    
    // Update the options array in the database
    update_option('ai_virtual_employee_settings', $options);
}

// Function to check if the OpenAI API key is set
function is_openai_api_key_set() {
    $api_key = get_openai_api_key();
    return !empty($api_key);
}

// Optionally, you can add hooks or filters that are related to the API key management
// For example, you might want to verify the API key before saving it
add_filter('pre_update_option_ai_virtual_employee_settings', 'validate_openai_api_key', 10, 2);

// Function to validate the OpenAI API key format before saving it
function validate_openai_api_key($value, $old_value) {
    // Perform validation checks on the API key
    // For example, check if the key format matches expected patterns or if it's not empty
    if (isset($value['ai_virtual_employee_text_field_0']) && !empty($value['ai_virtual_employee_text_field_0'])) {
        // Here you could add additional checks, such as making a test request to OpenAI's API
        // For now, we'll just sanitize the text field
        $value['ai_virtual_employee_text_field_0'] = sanitize_text_field($value['ai_virtual_employee_text_field_0']);
    } else {
        // If the API key is not valid, revert to the old value and add an error message
        add_settings_error(
            'ai_virtual_employee_settings',
            'ai_virtual_employee_api_key_error',
            __('Invalid API Key. Please enter a valid OpenAI API key.', 'ai-virtual-employee'),
            'error'
        );
        $value['ai_virtual_employee_text_field_0'] = $old_value['ai_virtual_employee_text_field_0'];
    }
    
    return $value;
}
?>
