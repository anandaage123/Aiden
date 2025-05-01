/**
 * WP Store Selector JavaScript
 * Version: 1.0.0
 */
jQuery(document).ready(function($) {
    /**
     * Add focus/blur effects to store selection dropdown
     */
    $('#user_store').on('focus', function() {
        $(this).addClass('focused');
    }).on('blur', function() {
        $(this).removeClass('focused');
    });
    
    /**
     * Form validation before submission
     * Ensures a store is selected before allowing form submission
     */
    $('form.register').on('submit', function(e) {
        var storeSelect = $('#user_store');
        if (!storeSelect.val()) {
            e.preventDefault();
            alert('Please select a store before submitting the form.');
            storeSelect.focus();
        }
    });
}); 