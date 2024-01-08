<?php
// task-manager.php - Manages AI tasks and interactions with the OpenAI API

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Function to handle the creation of a new AI task
function create_ai_task($task_data) {
    // Validate and sanitize task data
    $task_data = sanitize_ai_task_data($task_data);

    // Insert the new task into a custom table or a custom post type if needed
    // For simplicity, we'll assume a custom post type 'ai_task' is used
    $task_id = wp_insert_post(array(
        'post_title'  => $task_data['title'],
        'post_content'=> $task_data['description'],
        'post_status' => 'publish',
        'post_type'   => 'ai_task',
        'meta_input'  => array(
            'task_type'   => $task_data['task_type'],
            'parameters'  => $task_data['parameters'],
            // Additional meta fields can be added here
        ),
    ));

    // Check for errors
    if (is_wp_error($task_id)) {
        // Handle the error accordingly
        return $task_id;
    }

    // Return the ID of the created task
    return $task_id;
}

// Function to sanitize AI task data
function sanitize_ai_task_data($task_data) {
    // Sanitize each element of the task data array
    $task_data['title'] = sanitize_text_field($task_data['title']);
    $task_data['description'] = sanitize_textarea_field($task_data['description']);
    $task_data['task_type'] = sanitize_text_field($task_data['task_type']);
    $task_data['parameters'] = array_map('sanitize_text_field', $task_data['parameters']);

    // Return the sanitized data
    return $task_data;
}

// Function to execute an AI task
function execute_ai_task($task_id) {
    // Retrieve the task details from the database
    $task = get_post($task_id);
    $task_type = get_post_meta($task_id, 'task_type', true);
    $parameters = get_post_meta($task_id, 'parameters', true);

    // Check if the task exists and is valid
    if (!$task || is_wp_error($task)) {
        return new WP_Error('task_not_found', __('The AI task was not found.', 'ai-virtual-employee'));
    }

    // Execute the task by sending a request to the OpenAI API
    $response = handle_openai_request($task_type, $parameters);

    // Check for errors in the response
    if (is_wp_error($response)) {
        // Handle the error accordingly
        return $response;
    }

    // Process the response and update the task with the results
    // For simplicity, we'll assume the response is stored in post content
    wp_update_post(array(
        'ID'           => $task_id,
        'post_content' => $response,
    ));

    // Return the response
    return $response;
}

// Optionally, you can add additional functions to list tasks, update tasks, delete tasks, etc.

// Hook into WordPress to add custom post type or handle other initialization tasks
function ai_virtual_employee_register_task_post_type() {
    // Register the 'ai_task' custom post type if it's not already registered
    // This is a placeholder for the actual post type registration code
}

add_action('init', 'ai_virtual_employee_register_task_post_type');
