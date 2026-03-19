<?php
$tel      = get_field('tel', 'option');
$email    = get_field('email', 'option');

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
    'max'      => ['url' => $max,      'label' => 'Max',          'icon' => 'icon-max'],
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
                    <a href="tel:<?php echo $tel_clean; ?>"
                        class="footer__phone">
                        <?php echo $tel; ?>
                    </a>
                <?php endif; ?>
                <p class="footer__desc">Мы всегда на связи и готовы помочь</p>
                <a href="mailto:<?php echo $email ?>" class="footer__email"><?php echo $email ?></a>
                <p class="footer__desc">По любым вопросам пишите на почту</p>
            </div>
            <div class="footer__column">
                <nav aria-label="Меню в подвале" class="footer__menu">
                    <ul class="footer__menu-list">
                        <li><a href="">Подбор туров</a></li>
                        <li><a href="">Новые туры</a></li>
                        <li><a href="">Все НАПРАВЛЕНИЯ</a></li>
                        <li><a href="">о НАС</a></li>
                        <li><a href="">кОМАНДА</a></li>
                    </ul>
                </nav>
            </div>
            <div class="footer__column">
                <nav aria-label="Меню в подвале" class="footer__menu">
                    <ul class="footer__menu-list">
                        <li><a href="">аБХАЗИЯ</a></li>
                        <li><a href="">аДЛЕР</a></li>
                        <li><a href="">мОСКВА</a></li>
                        <li><a href="">сАНКТ-пЕТЕРБУРГ</a></li>
                        <li><a href="">рОСТОВ-НА-дОНУ</a></li>
                        <li><a href="">еЛЕЦ</a></li>
                        <li><a href="">лИПЕЦК</a></li>
                        <li><a href="">Казань</a></li>
                    </ul>
                </nav>
            </div>
            <div class="footer__column">
                <div class="footer__reqs">
                    <div class="footer__reqs-icon">
                        <img
                            width="62"
                            height="68"
                            src="<?php echo get_template_directory_uri(); ?>/assets/img/flag.svg"
                            alt="Герб России">
                    </div>
                    <div class="footer__reqs-content">
                        <div class="footer__reqs-title">
                            Мы в реестре туроператоров
                        </div>
                        <div class="footer__reqs-text">
                            ООО “Вместе по миру”
                            РТО: 026332
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
            <ul class="footer__policies-list">
                <li class="footer__policies-item"><a href="" class="footer__policies-link">Пользовательское соглашение</a></li>
                <li class="footer__policies-item"><a href="" class="footer__policies-link">Политика конфидециальности</a></li>
                <li class="footer__policies-item"><a href="" class="footer__policies-link">Договор-оферта на оказание услуг</a></li>
            </ul>
        </nav>
    </div>
</footer>
</div>

<?php require_once(TEMPLATE_PATH . '_modals.php'); ?>

<?php wp_footer(); ?>
</body>

</html>