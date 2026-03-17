<?php
$tel      = get_field('tel', 'options');
$email    = get_field('email', 'options');
$telegram = get_field('telegram', 'options');
$vk       = get_field('vk', 'options');
$ok       = get_field('ok', 'options');
$max      = get_field('max', 'options');
$whatsapp = get_field('whatsapp', 'options');

$socials = array_filter([
    'vk'       => ['url' => $vk,       'label' => 'ВКонтакте',    'icon' => 'icon-vk'],
    'ok'       => ['url' => $ok,       'label' => 'Одноклассники', 'icon' => 'icon-ok'],
    'telegram' => ['url' => $telegram, 'label' => 'Telegram',     'icon' => 'icon-telegram'],
    'whatsapp' => ['url' => $whatsapp, 'label' => 'WhatsApp',     'icon' => 'icon-whatsapp'],
    'max'      => ['url' => $max,      'label' => 'Max',          'icon' => 'icon-max'],
], function ($item) {
    return !empty($item['url']);
});
?>

<div class="header__main">
    <?php the_custom_logo(); ?>

    <?php if (!empty($socials)) : ?>
        <div class="header__socials socials">
            <?php foreach ($socials as $social) : ?>
                <a href="<?php echo esc_url($social['url']); ?>"
                    class="socials__item <?php echo esc_attr($social['icon']); ?>"
                    target="_blank"
                    rel="nofollow"
                    aria-label="Читайте нас в <?php echo esc_attr($social['label']); ?>">
                </a>
            <?php endforeach; ?>
            <!-- <a href="" class="socials__item icon-ok"></a> -->
        </div>
    <?php endif; ?>
    <nav aria-label="Главное меню" class="header__menu menu">
        <?php
        wp_nav_menu([
            'theme_location'  => 'header_menu',
            'container'       => false,
            'menu_class'      => 'menu__list',
            'fallback_cb'     => '__return_false',
            'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
        ]);
        ?>
    </nav>
    <?php if ($tel) :
        $tel_clean = preg_replace('/[^0-9+]/', '', $tel);
    ?>
        <a
            href="tel:<?php echo $tel_clean; ?>"
            class="header__btn btn btn-primary icon-phone">
            <span class="header__btn-text">Позвонить</span>
        </a>
    <?php endif; ?>
</div>