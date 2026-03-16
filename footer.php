<?php
$option_page = 'option';
$logo = get_field('logo', $option_page);
$requisites = get_field('requisites', $option_page);
$copyright = get_field('copyright', $option_page);

$is_error_404 = is_404();
$footer_class = 'footer';
if ($is_error_404) {
    $footer_class .= ' footer--error-404';
}
?>
</main>

<footer class="<?php echo esc_attr($footer_class); ?>">
    <div class="container">
        <?php if (!$is_error_404): ?>
            <div class="footer__top">
                <div class="footer__side">
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="footer__logo">
                        <img
                            src="<?php echo esc_url($logo['url']); ?>"
                            alt="<?php echo esc_attr($logo['alt']) ?: 'Логотип '; ?>">
                    </a>
                    <?php if ($requisites): ?>
                        <div class="footer__reqs">
                            <?php echo $requisites; ?>
                        </div>
                    <?php endif; ?>
                </div>
                <?php if (have_rows('social_links', 'option')): ?>
                    <div class="footer__socials socials">
                        <?php while (have_rows('social_links', 'option')): the_row();
                            $show_item = get_sub_field('show_item');

                            if (!$show_item) continue;

                            $icon = get_sub_field('icon');
                            $link = get_sub_field('link');
                            $hover_color = get_sub_field('hover_color');
                        ?>
                            <a href="<?php echo esc_url($link); ?>"
                                class="socials__item"
                                style="--hover-bg: <?php echo esc_attr($hover_color); ?>;"
                                target="_blank"
                                rel="nofollow">
                                <?php if ($icon): ?>
                                    <img src="<?php echo esc_url($icon['url']); ?>" alt="<?php echo esc_attr($icon['alt']); ?>">
                                <?php endif; ?>
                            </a>
                        <?php endwhile; ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="footer__body">
                <nav aria-label="Меню в подвале" class="footer__menu">
                    <?php
                    wp_nav_menu([
                        'theme_location' => 'footer_menu',
                        'container'      => false,
                        'menu_class'     => 'footer__menu-list',
                        'items_wrap'     => '<ul id="%1$s" class="%2$s" data-spollers="767.98, max">%3$s</ul>',
                        'walker'         => new Footer_Menu_Walker(),
                    ]);
                    ?>
                </nav>
            </div>
        <?php endif; ?>
        <div class="footer__bottom">
            <?php if ($copyright): ?>
                <div class="footer__copyright">
                    © <?php echo currentYear(); ?> <?php echo $copyright; ?>
                </div>
            <?php endif; ?>
            <nav aria-label="Меню политик конфиденциальности" class="footer__policies">
                <?php
                wp_nav_menu([
                    'theme_location' => 'menu_policies',
                    'container'      => false,
                    'menu_class'     => 'footer__policies-list',
                    'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                ]);
                ?>
            </nav>
            <a href="https://gektor-studio.com/" target="_blank" rel="noopener" class="footer__production">Сделано с ♥ в GEKTOR 2.0</a>
        </div>
    </div>
</footer>
</div>

<?php require_once(TEMPLATE_PATH . '_modals.php'); ?>

<?php wp_footer(); ?>
</body>

</html>