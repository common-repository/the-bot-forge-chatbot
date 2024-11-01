<?php
/*
Plugin Name: The Bot Forge Chatbot
Plugin URI: https://app.thebotforge.ai
Description: Embed The Bot Forge chatbot into your WordPress website.
Version: 1.6.1
Author: The Bot Forge
Author URI: https://thebotforge.ai
License: GPL-2.0-or-later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

define('THE_BOT_FORGE_CHATBOT_VERSION', '1.6.1');

// Admin Menu Hook
add_action('admin_menu', 'bot_forge_chatbot_admin_menu');
function bot_forge_chatbot_admin_menu() {
    add_menu_page(
        'The Bot Forge Chatbot Settings',
        'Bot Forge Chatbot',
        'manage_options',
        'the-bot-forge-chatbot',
        'bot_forge_chatbot_settings_page',
        'dashicons-testimonial',
        100
    );
}

// Settings Page Content
function bot_forge_chatbot_settings_page() {
    require_once plugin_dir_path(__FILE__) . 'admin/settings-page.php';
}

// Register and Enqueue the Chat Widget Script
function bot_forge_enqueue_chatbot_script() {
    $bot_id = get_option('bot_forge_chatbot_id');
    $pages = get_option('bot_forge_chatbot_pages');
    $should_enqueue = false;

    if (empty($pages)) {
        $should_enqueue = true;
    } else {
        $page_list = array_map('trim', explode(',', $pages));
        if (is_page($page_list)) {
            $should_enqueue = true;
        }
    }

    if ($bot_id && $should_enqueue) {
        wp_enqueue_script(
            'bot-forge-chatbot-script',
            'https://app.thebotforge.ai/chatWidget.js',
            array(),
            THE_BOT_FORGE_CHATBOT_VERSION,
            true
        );
    }
}
add_action('wp_footer', 'bot_forge_enqueue_chatbot_script');

function bot_forge_add_data_attribute($tag, $handle) {
    if ('bot-forge-chatbot-script' !== $handle) {
        return $tag;
    }
    $bot_id = get_option('bot_forge_chatbot_id');
    if ($bot_id) {
        $tag = str_replace(' src', ' data-bot-forge-id="'.esc_attr($bot_id).'" src', $tag);
    }
    return $tag;
}
add_filter('script_loader_tag', 'bot_forge_add_data_attribute', 10, 2);

// Register Settings
add_action('admin_init', 'bot_forge_chatbot_register_settings');
function bot_forge_chatbot_register_settings() {
    register_setting('bot_forge_chatbot_settings', 'bot_forge_chatbot_id');
    register_setting('bot_forge_chatbot_settings', 'bot_forge_chatbot_pages');
}

// Enqueue custom admin script
function bot_forge_chatbot_admin_scripts() {
    wp_enqueue_script('bot_forge_chatbot_admin_js', plugins_url('admin/js/admin-script.js', __FILE__), array('jquery'), THE_BOT_FORGE_CHATBOT_VERSION, true);
}
add_action('admin_enqueue_scripts', 'bot_forge_chatbot_admin_scripts');

?>