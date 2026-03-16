<?php

/**
 * Компонент кнопки
 * Шаблон для вывода универсальной кнопки (ссылки или попапа) 
 * с гибкой настройкой стилей, типов и иконок через аргументы.
 *
 * @param array $args {
 * Аргументы, передаваемые в компонент через get_template_part.
 *
 * @type array  $data  Обязательный. Массив данных кнопки, полученный из ACF Group Field.
 * @type string $class Необязательный. Дополнительные классы для позиционирования (например, 'hero__offer-btn').
 * @type string $type  Необязательный. Тип кнопки для стилизации (по умолчанию 'primary'). Генерирует класс btn-{type}.
 * @type string $icon  Необязательный. Имя иконки (например, 'chevron-right'). Генерирует класс icon-{icon}.
 * }
 */
?>
<?php
$data = $args['data'] ?? [];
$custom_class = $args['class'] ?? '';
$icon = $args['icon'] ?? false;

if (empty($data)) {
    return;
}

$is_link = $data['is_link'] ?? false;
$btn_txt = $data['btn_txt'] ?? '';
$btn_link = '';
$btn_target = !empty($data['btn_target']) ? '_blank' : '_self';

if ($is_link) {
    $link_data = $data['btn_link'] ?? [];

    if (is_array($link_data)) {
        $btn_link = $link_data['url'] ?? '';

        if ($btn_target === '_self' && !empty($link_data['target'])) {
            $btn_target = $link_data['target'];
        }

        if (empty($btn_txt)) {
            $btn_txt = $link_data['title'] ?? '';
        }
    } else {
        $btn_link = $link_data;
    }

    if (empty($btn_link) || empty($btn_txt)) {
        return;
    }

    $is_anchor = strpos((string)$btn_link, '#') === 0;

    if (!$is_anchor) {
        global $wp;
        $current_url = home_url(add_query_arg([], $wp->request));

        if (is_singular()) {
            $current_url = get_permalink();
        }

        if (untrailingslashit($btn_link) === untrailingslashit($current_url)) {
            return;
        }
    }
} else {
    $btn_popup = $data['btn_popup'] ?? '';
    if (empty($btn_popup) || empty($btn_txt)) {
        return;
    }
}

$type = $data['btn_style'] ?? 'primary';
$classes = ['btn'];
$classes[] = 'btn-' . $type;

if ($icon) {
    $classes[] = 'icon-' . $icon;
}

if ($custom_class) {
    $classes[] = $custom_class;
}
?>

<?php if ($is_link) : ?>
    <?php
    if ($btn_target !== '_blank' && !in_array('anchor', $classes)) {
        $classes[] = 'anchor';
    }
    $class_string = implode(' ', array_unique($classes));
    ?>
    <a href="<?php echo esc_url($btn_link); ?>"
        class="<?php echo esc_attr($class_string); ?>"
        target="<?php echo esc_attr($btn_target); ?>"
        <?php echo $btn_target === '_blank' ? 'rel="noopener noreferrer"' : ''; ?>>
        <?php echo esc_html($btn_txt); ?>
    </a>

<?php else : ?>
    <?php
    $class_string = implode(' ', $classes);
    ?>
    <a href="<?php echo esc_attr($btn_popup); ?>"
        data-fancybox
        class="<?php echo esc_attr($class_string); ?>">
        <?php echo esc_html($btn_txt); ?>
    </a>
<?php endif; ?>