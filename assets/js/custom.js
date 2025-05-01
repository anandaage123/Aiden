jQuery(document).ready(function($) {
    // Add any custom JavaScript functionality here
    // For example, you could add validation or dynamic behavior
    
    // Example: Add a class to the store select when it's focused
    $('#user_store').on('focus', function() {
        $(this).addClass('focused');
    }).on('blur', function() {
        $(this).removeClass('focused');
    });
    
    // Example: Add validation before form submission
    $('form.register').on('submit', function(e) {
        var storeSelect = $('#user_store');
        if (!storeSelect.val()) {
            e.preventDefault();
            alert('Please select a store before submitting the form.');
            storeSelect.focus();
        }
    });
}); 