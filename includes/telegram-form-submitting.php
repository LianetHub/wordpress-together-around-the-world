<?php

add_action('wpcf7_mail_sent', function ($contact_form) {
    $submission = WPCF7_Submission::get_instance();
    if ($submission) {
        $data = $submission->get_posted_data();
        $token = "YOUR_BOT_TOKEN";
        $chat_id = "YOUR_CHAT_ID";

        $message = "Новая заявка с сайта Вместе по миру:\n";
        $message .= "Телефон: " . $data['your-tel'] . "\n";
        $message .= "Комментарий: " . $data['your-message'];

        file_get_contents("https://api.telegram.org/bot$token/sendMessage?chat_id=$chat_id&text=" . urlencode($message));
    }
}, 10, 1);

add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style('main-style', get_stylesheet_uri());
    if (is_front_page()) {
        wp_enqueue_script('calendar-module', get_template_directory_uri() . '/js/calendar.js', [], null, true);
    }
});
