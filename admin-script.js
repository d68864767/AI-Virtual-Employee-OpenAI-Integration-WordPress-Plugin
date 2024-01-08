// admin-script.js - JavaScript for AI Virtual Employee - OpenAI Integration plugin admin interactions

document.addEventListener('DOMContentLoaded', function() {
    // Selectors for various elements in the admin interface
    const apiKeyInput = document.getElementById('openai_api_key');
    const saveApiKeyButton = document.getElementById('save_api_key');
    const taskForm = document.getElementById('ai_task_form');
    const challengeForm = document.getElementById('ai_challenge_form');

    // Save API Key
    saveApiKeyButton.addEventListener('click', function(event) {
        event.preventDefault();
        const apiKey = apiKeyInput.value.trim();

        // Perform a simple check to ensure the API key is not empty
        if (apiKey === '') {
            alert('Please enter a valid OpenAI API key.');
            return;
        }

        // AJAX request to save the API key using WordPress's admin-ajax.php
        const data = {
            'action': 'save_openai_api_key', // Action hook for the AJAX request
            'openai_api_key': apiKey // The API key to save
        };

        // Use WordPress's built-in jQuery for AJAX
        jQuery.post(ajaxurl, data, function(response) {
            if (response.success) {
                alert('API Key saved successfully.');
            } else {
                alert('Failed to save API Key. Please try again.');
            }
        });
    });

    // Handle AI Task Form Submission
    if (taskForm) {
        taskForm.addEventListener('submit', function(event) {
            event.preventDefault();
            // Collect task data from the form
            // ... (form data collection logic)

            // AJAX request to handle the AI task
            // ... (AJAX request logic)
        });
    }

    // Handle AI Challenge Form Submission
    if (challengeForm) {
        challengeForm.addEventListener('submit', function(event) {
            event.preventDefault();
            // Collect challenge data from the form
            // ... (form data collection logic)

            // AJAX request to handle the AI challenge
            // ... (AJAX request logic)
        });
    }

    // Additional admin UI interactions can be added here
});
