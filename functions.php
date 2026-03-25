<?php

require_once('includes/admin-custom.php');
require_once('includes/acf-custom.php');

// =========================================================================
// 1. CONSTANTS & ENV CONFIG
// =========================================================================

define('TEMPLATE_PATH', dirname(__FILE__) . '/templates/');

function load_env_configs($path)
{
    if (!file_exists($path)) return;

    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        list($name, $value) = explode('=', $line, 2);
        $_ENV[trim($name)] = trim($value);
    }
}
load_env_configs(ABSPATH . '.env');

// =========================================================================
// 2. THEME SETUP & SUPPORT
// =========================================================================

add_theme_support('title-tag');

add_action('after_setup_theme', function () {
    add_theme_support('post-thumbnails');
});

add_theme_support('custom-logo', [
    'height'      => 81,
    'width'       => 168,
    'flex-width'  => true,
    'flex-height' => true,
]);

function together_theme_setup()
{
    register_nav_menus([
        'header_menu' => 'Меню в шапке',
        'policies_menu' => 'Меню политик конфиденциальности',
    ]);
}
add_action('after_setup_theme', 'together_theme_setup');

// =========================================================================
// 3. ENQUEUE STYLES
// =========================================================================

function theme_enqueue_styles()
{
    $theme_dir = get_template_directory();
    $theme_uri = get_template_directory_uri();

    wp_enqueue_style('swiper', $theme_uri . '/assets/css/libs/swiper-bundle.min.css');
    wp_enqueue_style('fancybox', $theme_uri . '/assets/css/libs/fancybox.css');
    wp_enqueue_style('reset', $theme_uri . '/assets/css/reset.min.css');

    $main_css_ver = filemtime($theme_dir . '/assets/css/style.min.css');
    wp_enqueue_style('main-style', $theme_uri . '/assets/css/style.min.css', array(), $main_css_ver);
}
add_action('wp_enqueue_scripts', 'theme_enqueue_styles');

add_filter('style_loader_tag', 'theme_styles_add_attributes', 10, 2);
function theme_styles_add_attributes($tag, $handle)
{
    $async_styles = array('swiper', 'fancybox');

    if (in_array($handle, $async_styles)) {
        return str_replace(
            " media='all'",
            " media='print' onload=\"this.media='all'; this.onload=null;\"",
            $tag
        );
    }
    return $tag;
}

// =========================================================================
// 4. ENQUEUE SCRIPTS
// =========================================================================

function theme_enqueue_scripts()
{
    $theme_dir = get_template_directory();
    $theme_uri = get_template_directory_uri();

    wp_deregister_script('jquery');
    wp_enqueue_script('jquery', $theme_uri . '/assets/js/libs/jquery-4.0.0.min.js', array(), '4.0.0', true);

    wp_enqueue_script('swiper-js', $theme_uri . '/assets/js/libs/swiper-bundle.min.js', array(), null, true);
    wp_enqueue_script('fancybox-js', $theme_uri . '/assets/js/libs/fancybox.umd.js', array(), null, true);
    wp_enqueue_script('vanilla-calendar-pro-js', $theme_uri . '/assets/js/libs/vanilla-calendar-pro.min.js', array(), null, true);

    $app_js_ver = filemtime($theme_dir . '/assets/js/app.min.js');
    wp_enqueue_script('app-js', $theme_uri . '/assets/js/app.min.js', array('jquery'), $app_js_ver, true);

    if (is_front_page()) {
        $cal_ver = filemtime($theme_dir . '/assets/js/booking-calendar.min.js');
        wp_enqueue_script(
            'booking-calendar',
            $theme_uri . '/assets/js/booking-calendar.min.js',
            array('jquery'),
            $cal_ver,
            true
        );

        wp_localize_script('booking-calendar', 'calendarData', array(
            'tours' => get_all_tours_data(),
            'api_url' => admin_url('admin-ajax.php'),
        ));
    }
}
add_action('wp_enqueue_scripts', 'theme_enqueue_scripts');

add_filter('script_loader_tag', 'theme_scripts_add_attributes', 10, 2);
function theme_scripts_add_attributes($tag, $handle)
{
    $async_scripts = array(
        'swiper-js',
        'vanilla-calendar-pro-js',
        'booking-calendar',
        'fancybox-js'
    );

    if (in_array($handle, $async_scripts)) {
        return str_replace(' src', ' async src', $tag);
    }
    return $tag;
}

// =========================================================================
// 5. CUSTOM POST TYPES
// =========================================================================

add_action('init', function () {
    register_post_type('experts', [
        'labels' => [
            'name'               => 'Команда экспертов',
            'singular_name'      => 'Эксперт',
            'add_new'            => 'Добавить эксперта',
            'add_new_item'       => 'Добавить нового эксперта',
            'edit_item'          => 'Редактировать эксперта',
            'new_item'           => 'Новый эксперт',
            'view_item'          => 'Посмотреть эксперта',
            'search_items'       => 'Найти эксперта',
            'not_found'          => 'Экспертов не найдено',
            'not_found_in_trash' => 'В корзине экспертов не найдено',
            'menu_name'          => 'Эксперты',
        ],
        'public'              => false,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'menu_icon'           => 'dashicons-businessman',
        'hierarchical'        => false,
        'supports'            => ['title', 'thumbnail'],
        'has_archive'         => false,
        'rewrite'             => false,
        'query_var'           => false,
        'publicly_queryable'  => false,
    ]);
});

add_filter('register_taxonomy_args', 'disable_category_public_pages', 10, 2);
function disable_category_public_pages($args, $taxonomy)
{
    if ($taxonomy === 'category') {
        $args['publicly_queryable'] = false;
        $args['query_var'] = false;
    }
    return $args;
}

// =========================================================================
// 6. SECURITY & CLEANUP
// =========================================================================

remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
remove_action('wp_head', 'rel_canonical');
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'start_post_rel_link', 10, 0);
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
remove_action('wp_head', 'parent_post_rel_link', 10, 0);

add_filter('xmlrpc_enabled', '__return_false');

function remove_admin_bar_links()
{
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu('wp-logo');
    $wp_admin_bar->remove_menu('updates');
}
add_action('wp_before_admin_bar_render', 'remove_admin_bar_links');

add_filter('disable_wpseo_json_ld_search', '__return_true');

function allow_svg_uploads($mimes)
{
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'allow_svg_uploads');

add_action('wp_enqueue_scripts', function () {
    wp_dequeue_style('wp-img-auto-sizes-contain');
}, 99);

remove_action('wp_head', 'wp_img_auto_sizes_contain_css');

// =========================================================================
// 7. TEXT FORMATTING & UTILITIES
// =========================================================================

function currentYear()
{
    return date('Y');
}

function fix_widows_after_prepositions($text)
{
    if (empty($text) || !is_string($text)) {
        return $text;
    }

    $prepositions = ['в', 'и', 'или', 'к', 'с', 'на', 'у', 'о', 'от', 'для', 'за', 'по', 'без', 'из', 'над', 'под', 'при', 'про', 'через', 'об', 'со'];
    $pattern = implode('|', array_map('preg_quote', $prepositions));
    $regex = '/\b(' . $pattern . ')\s+/iu';

    return preg_replace_callback($regex, function ($matches) {
        return $matches[1] . "\xC2\xA0";
    }, $text);
}

add_filter('the_content', 'fix_widows_after_prepositions', 99);
add_filter('the_title', 'fix_widows_after_prepositions', 99);
add_filter('the_excerpt', 'fix_widows_after_prepositions', 99);
add_filter('widget_text_content', 'fix_widows_after_prepositions', 99);
add_filter('acf/format_value', 'fix_widows_after_prepositions', 99, 3);

add_filter('wpseo_breadcrumb_separator', '__return_empty_string');

function together_around_the_world_transliterate($text)
{
    $cyr = ['а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я', 'А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я'];
    $lat = ['a', 'b', 'v', 'g', 'd', 'e', 'io', 'zh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'ts', 'ch', 'sh', 'shb', '', 'y', '', 'e', 'yu', 'ya', 'a', 'b', 'v', 'g', 'd', 'e', 'io', 'zh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'ts', 'ch', 'sh', 'shb', '', 'y', '', 'e', 'yu', 'ya'];

    $text = str_replace($cyr, $lat, $text);
    return sanitize_title($text);
}

// =========================================================================
// 8. TOURS DATA FORMATTING
// =========================================================================

function get_formatted_tour_dates($date_from, $date_to, $type = 'card')
{

    if (!$date_from || !$date_to) return '';

    $months = ['01' => 'января', '02' => 'февраля', '03' => 'марта', '04' => 'апреля', '05' => 'мая', '06' => 'июня', '07' => 'июля', '08' => 'августа', '09' => 'сентября', '10' => 'октября', '11' => 'ноября', '12' => 'декабря'];

    $dt_from = DateTime::createFromFormat('d/m/Y', (string)$date_from);
    $dt_to = DateTime::createFromFormat('d/m/Y', (string)$date_to);

    if (!$dt_from || !$dt_to) return '';

    $d_from = $dt_from->format('d');
    $m_from = $dt_from->format('m');
    $y_from = $dt_from->format('Y');
    $d_to = $dt_to->format('d');
    $m_to = $dt_to->format('m');
    $y_to = $dt_to->format('Y');

    if ($type === 'card') {
        if ($m_from === $m_to && $y_from === $y_to) {
            return $d_from . '-' . $d_to . ' ' . $months[$m_from] . ' ' . $y_from;
        }
        return $d_from . ' ' . $months[$m_from] . ' - ' . $d_to . ' ' . $months[$m_to] . ' ' . $y_to;
    }

    if ($m_from === $m_to) {
        return $d_from . '-' . $d_to . ' ' . $months[$m_from];
    }
    return $d_from . ' ' . $months[$m_from] . ' - ' . $d_to . ' ' . $months[$m_to];
}

function get_formatted_tour_departure($date_from, $time_str)
{
    $months = ['01' => 'января', '02' => 'февраля', '03' => 'марта', '04' => 'апреля', '05' => 'мая', '06' => 'июня', '07' => 'июля', '08' => 'августа', '09' => 'сентября', '10' => 'октября', '11' => 'ноября', '12' => 'декабря'];
    $days = ['1' => 'понедельник', '2' => 'вторник', '3' => 'среда', '4' => 'четверг', '5' => 'пятница', '6' => 'суббота', '7' => 'воскресенье'];

    $dt = DateTime::createFromFormat('d/m/Y', $date_from);
    if (!$dt) return '';

    $d = $dt->format('d');
    $m = $dt->format('m');
    $w = $dt->format('N');
    $t = DateTime::createFromFormat('H:i:s', $time_str);
    $time_formatted = $t ? $t->format('H:i') : $time_str;

    return $time_formatted . ', ' . $d . ' ' . $months[$m] . ', ' . $days[$w];
}

function get_tour_duration($date_from, $date_to)
{
    if (!$date_from || !$date_to) return 0;

    $dt_from = DateTime::createFromFormat('d/m/Y', (string)$date_from);
    $dt_to = DateTime::createFromFormat('d/m/Y', (string)$date_to);

    if (!$dt_from || !$dt_to) return 0;

    $diff = $dt_from->diff($dt_to);

    return $diff->days + 1;
}

function get_category_tour_data($term_id)
{
    $args = [
        'post_type'      => 'post',
        'posts_per_page' => 1,
        'cat'            => $term_id,
        'meta_key'       => 'tour_price',
        'orderby'        => 'meta_value_num',
        'order'          => 'ASC',
    ];

    $query = new WP_Query($args);
    $data = ['price' => 0, 'days' => 0];

    if ($query->have_posts()) {
        $query->the_post();
        $data['price'] = get_field('tour_price');

        $date_from = get_field('tour_date_from');
        $date_to   = get_field('tour_date_to');

        $data['days'] = get_tour_duration($date_from, $date_to);
    }

    wp_reset_postdata();
    return $data;
}

// =========================================================================
// 9. FORM SUBMISSIONS (TELEGRAM)
// =========================================================================

add_action('wpcf7_mail_sent', function ($contact_form) {
    $submission = WPCF7_Submission::get_instance();
    if ($submission) {
        $data = $submission->get_posted_data();
        $token   = $_ENV['TELEGRAM_BOT_TOKEN'] ?? '';
        $chat_id = $_ENV['TELEGRAM_CHAT_ID'] ?? '';

        if (!$token || !$chat_id) return;

        $username = esc_html($data['username'] ?? 'Не указано');
        $phone = esc_html($data['phone'] ?? 'Не указано');
        $clean_phone = preg_replace('/[^\d+]/', '', $phone);

        $message = "<b>Новая заявка с сайта «Вместе по миру»</b>\n\n";
        $message .= "<b>Имя:</b> " . $username . "\n";
        $message .= "<b>Телефон:</b> <a href='tel:" . $clean_phone . "'>" . $phone . "</a>";

        $url = "https://api.telegram.org/bot{$token}/sendMessage?chat_id={$chat_id}&parse_mode=html&text=" . urlencode($message);
        wp_remote_get($url);
    }
}, 10, 1);

// =========================================================================
// 10. BOOKING CALENDAR MODULE
// =========================================================================

function get_all_tours_data()
{
    $args = [
        'post_type'      => 'post',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
    ];

    $query = new WP_Query($args);
    $events = [];

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();

            $raw_date_from = get_field('tour_date_from');
            $raw_date_to   = get_field('tour_date_to');
            $price         = get_field('tour_price');
            $is_from       = get_field('tour_price_from');

            $dt_from = DateTime::createFromFormat('d/m/Y', (string)$raw_date_from);
            $dt_to   = DateTime::createFromFormat('d/m/Y', (string)$raw_date_to);

            if ($dt_from) {
                $date_key = $dt_from->format('Y-m-d');
                $price_formatted = $price ? number_format($price, 0, '', ' ') : '0';
                $price_str = $is_from ? 'от ' . $price_formatted : $price_formatted;

                $duration_text = '';
                if ($dt_to) {
                    $diff = $dt_from->diff($dt_to)->days + 1;
                    $duration_text = 'Продолжительность ' . $diff . ' ' . ($diff == 1 ? 'день' : ($diff < 5 ? 'дня' : 'дней'));
                }

                $categories = get_the_category();
                $cat_id = !empty($categories) ? $categories[0]->term_id : 'all';

                $events[$date_key][] = [
                    'title'    => get_the_title(),
                    'price'    => $price_str,
                    'link'     => get_permalink(),
                    'duration' => $duration_text,
                    'cat_id'   => $cat_id
                ];
            }
        }
        wp_reset_postdata();
    }
    return $events;
}
