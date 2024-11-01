jQuery(document).ready(function($) {
    var $form = $('form');
    var $submitButton = $form.find('input[type="submit"]');
    var $feedback = $('<div class="bot-forge-feedback"></div>');
    $form.append($feedback);

    $form.on('submit', function() {
        $submitButton.prop('disabled', true).val('Saving...');
        $feedback.text('Saving changes...').show();
    });

    $(document).ajaxSuccess(function() {
        $submitButton.prop('disabled', false).val('Save Changes');
        $feedback.text('Changes saved successfully!').fadeOut(3000);
    });
});