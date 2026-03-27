<?php
$tel      = get_field('tel', 'option');
$email    = get_field('email', 'option');

$reg_company = get_field('reg_company_name', 'option');
$reg_rto     = get_field('reg_rto_number', 'option');

$telegram = get_field('telegram', 'option');
$vk       = get_field('vk', 'option');
$ok       = get_field('ok', 'option');
$max      = get_field('max', 'option');
$whatsapp = get_field('whatsapp', 'option');

$socials = array_filter([
    'vk'       => ['url' => $vk,       'label' => 'ВКонтакте',    'icon' => 'icon-vk'],
    'ok'       => ['url' => $ok,       'label' => 'Одноклассники', 'icon' => 'icon-ok'],
    'telegram' => ['url' => $telegram, 'label' => 'Telegram',     'icon' => 'icon-telegram'],
    'whatsapp' => ['url' => $whatsapp, 'label' => 'WhatsApp',     'icon' => 'icon-whatsapp'],
    'max'      => ['url' => $max,      'label' => 'Max',           'icon' => 'icon-max'],
], function ($item) {
    return !empty($item['url']);
});
?>

</main>

<footer class="footer">
    <div class="container">
        <div class="footer__header">
            <div class="footer__column">
                <?php the_custom_logo(); ?>
                <?php if ($tel) :
                    $tel_clean = preg_replace('/[^0-9+]/', '', $tel);
                ?>
                    <a href="tel:<?php echo $tel_clean; ?>" class="footer__phone">
                        <?php echo $tel; ?>
                    </a>
                <?php endif; ?>
                <p class="footer__desc">Мы всегда на связи и готовы помочь</p>
                <a href="mailto:<?php echo $email ?>" class="footer__email"><?php echo $email ?></a>
                <p class="footer__desc">По любым вопросам пишите на почту</p>
            </div>

            <div class="footer__column">
                <nav aria-label="Основное меню" class="footer__menu">
                    <?php
                    wp_nav_menu([
                        'theme_location' => 'footer_main',
                        'container'      => false,
                        'menu_class'     => 'footer__menu-list',
                        'fallback_cb'    => '__return_false',
                    ]);
                    ?>
                </nav>
            </div>

            <div class="footer__column">
                <nav aria-label="Популярные направления" class="footer__menu">
                    <?php
                    wp_nav_menu([
                        'theme_location' => 'footer_cats',
                        'container'      => false,
                        'menu_class'     => 'footer__menu-list',
                        'fallback_cb'    => '__return_false',
                    ]);
                    ?>
                </nav>
            </div>

            <div class="footer__column">
                <div class="footer__reqs">
                    <div class="footer__reqs-icon">
                        <img
                            width="62"
                            height="68"
                            src="<?php echo get_template_directory_uri(); ?>/assets/img/flag.svg"
                            loading="lazy"
                            alt="Герб России">
                    </div>
                    <div class="footer__reqs-content">
                        <div class="footer__reqs-title">Мы в реестре туроператоров</div>
                        <div class="footer__reqs-text">
                            <?php echo esc_html($reg_company); ?><br>
                            РТО: <?php echo esc_html($reg_rto); ?>
                        </div>
                    </div>
                </div>
                <div class="footer__contacts">
                    <div class="footer__contacts-title">Связаться с нами</div>
                    <div class="footer__socials socials">
                        <?php foreach ($socials as $social) : ?>
                            <a href="<?php echo esc_url($social['url']); ?>"
                                class="socials__item <?php echo esc_attr($social['icon']); ?>"
                                target="_blank"
                                rel="nofollow"
                                aria-label="Читайте нас в <?php echo esc_attr($social['label']); ?>">
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <nav aria-label="Меню политик" class="footer__policies">
            <?php
            wp_nav_menu([
                'theme_location'  => 'policies_menu',
                'container'       => false,
                'menu_class'      => 'footer__policies-list',
                'fallback_cb'     => '__return_false',
                'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
            ]);
            ?>
        </nav>
    </div>
</footer>
</div>

<?php require_once(TEMPLATE_PATH . '_modals.php'); ?>

<?php wp_footer(); ?>
</body>

</html>