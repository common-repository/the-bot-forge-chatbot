<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Enqueue custom admin stylesheet
function bot_forge_chatbot_admin_styles($hook) {
    if ('settings_page_bot_forge_chatbot' != $hook) {
        return;
    }
    wp_enqueue_style('bot_forge_chatbot_admin_css', plugins_url('admin/css/admin-style.css', __FILE__), array(), THE_BOT_FORGE_CHATBOT_VERSION);
    // Enqueue WordPress Dashicons
    wp_enqueue_style('dashicons');
}
add_action('admin_enqueue_scripts', 'bot_forge_chatbot_admin_styles');

// Admin notice for missing Bot ID
function bot_forge_chatbot_admin_notice() {
    $screen = get_current_screen();
    if ($screen->id !== 'settings_page_bot_forge_chatbot') {
        return;
    }
    $bot_id = get_option('bot_forge_chatbot_id');
    if (empty($bot_id)) {
        echo '<div class="notice notice-warning is-dismissible">
            <p><strong>Action Required:</strong> You need to <a href="https://app.thebotforge.ai" target="_blank">create a free account</a> and enter your Bot Forge Chatbot ID to activate the plugin.</p>
        </div>';
    }
}
add_action('admin_notices', 'bot_forge_chatbot_admin_notice');

// Optionally suppress admin notices on your settings page
function bot_forge_suppress_admin_notices() {
    $screen = get_current_screen();
    if ($screen->id === 'settings_page_bot_forge_chatbot') {
        remove_all_actions('admin_notices');
        remove_all_actions('all_admin_notices');
    }
}
add_action('admin_head', 'bot_forge_suppress_admin_notices', 1);
?>
<div class="wrap">
    <img src="<?php echo plugins_url('images/logo-blacktext.png', __FILE__); ?>" alt="The Bot Forge Logo" style="max-width: 300px; height: auto;">
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
    
    <p>Welcome to The Bot Forge, a cutting-edge platform where you can create your own AI-powered chatbots trained on your proprietary data!</p>

    <!-- CTA Button Without Icon -->
    <a href="https://app.thebotforge.ai" target="_blank" class="button button-primary button-hero">Create Your Free Account Now</a>
    
    <h2>Quick Setup</h2>
    <p>Follow these simple steps to get your chatbot up and running:</p>
    <ol>
        <li><strong><span class="dashicons dashicons-admin-users"></span> Create an Account:</strong>
            <a href="https://app.thebotforge.ai" target="_blank" class="button">Sign Up for Free</a>
        </li>
        <li><strong><span class="dashicons dashicons-format-chat"></span> Create Your Chatbot:</strong> Use our intuitive platform to set up your chatbot.</li>
        <li><strong><span class="dashicons dashicons-admin-network"></span> Copy Your Bot ID:</strong> Find it under the Share tab in the WordPress section.</li>
        <li><strong><span class="dashicons dashicons-admin-settings"></span> Enter Bot ID Below:</strong> Paste the Bot ID to connect your chatbot with your WordPress site.</li>
    </ol>

    <form method="post" action="options.php">
        <?php settings_fields('bot_forge_chatbot_settings'); ?>
        <?php do_settings_sections('bot_forge_chatbot_settings'); ?>

        <h2>Bot Settings</h2>
        <table class="form-table">
            <tr valign="top">
                <th scope="row"><label for="bot_forge_chatbot_id">Bot Forge Chatbot ID</label></th>
                <td><input type="text" id="bot_forge_chatbot_id" name="bot_forge_chatbot_id" value="<?php echo esc_attr(get_option('bot_forge_chatbot_id')); ?>" class="regular-text" /></td>
            </tr>
        </table>

        <h2>Page Settings (Optional)</h2>
        <p>Enter the page IDs or slugs where you want the chatbot to appear. Separate multiple entries with commas. Leave blank to appear on all pages.</p>
        <table class="form-table">
            <tr valign="top">
                <th scope="row"><label for="bot_forge_chatbot_pages">Page IDs or Slugs</label></th>
                <td><input type="text" id="bot_forge_chatbot_pages" name="bot_forge_chatbot_pages" value="<?php echo esc_attr(get_option('bot_forge_chatbot_pages')); ?>" class="regular-text" /></td>
            </tr>
        </table>

        <?php submit_button(); ?>
    </form>

    <!-- Testimonials Section -->
    <h2>What Our Users Say</h2>
    <div class="bot-forge-testimonials">
        <blockquote>
            <p>"The Bot Forge was a huge help during our last event. Attendees could get information instantly by scanning a QR code, which reduced the workload on our staff and improved the overall attendee experience."</p>
            <cite>- Mark L</cite>
        </blockquote>
        <blockquote>
            <p>"Implementing The Bot Forge on our website has been a game-changer. Our customer inquiries are handled instantly, and the bot’s ability to recommend products has boosted our sales significantly."</p>
            <cite>- John D</cite>
        </blockquote>
        <blockquote>
            <p>"We use The Bot Forge for onboarding new employees and managing HR queries. The chatbot has streamlined our processes and freed up valuable time for our HR team to focus on more strategic tasks."</p>
            <cite>- Sarah K</cite>
        </blockquote>
    </div>

    <!-- Support Section -->
    <h2>Need Assistance?</h2>
    <p>If you need help getting started or have any questions, we're here to help!</p>
    <ul>
        <li><span class="dashicons dashicons-sos"></span> Visit our <a href="https://chat.thebotforge.ai" target="_blank">Support Page</a></li>
        <li><span class="dashicons dashicons-email-alt"></span> Email us at <a href="mailto:support@thebotforge.ai">support@thebotforge.ai</a></li>
        <li><span class="dashicons dashicons-admin-site"></span> Visit our <a href="https://thebotforge.ai" target="_blank">Main Webpage</a></li>
    </ul>
</div>