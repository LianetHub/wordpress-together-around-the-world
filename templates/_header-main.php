<?php
$logo = get_field('logo', 'option');
$logo_descriptor = get_field('logo_descriptor', 'option');
$phone = get_field('tel', 'option');
$email = get_field('email', 'option');
?>


<div class="header__main">
    <a href="<?php echo esc_url(home_url('/')); ?>" class="header__logo">
        <span class="header__logo-icon">
            <img
                src="<?php echo esc_url($logo['url']); ?>"
                alt="<?php echo esc_attr($logo['alt']) ?: 'Логотип '; ?>">
        </span>
        <?php if ($logo_descriptor): ?>
            <span class="header__logo-descriptor">
                <?php echo esc_html($logo_descriptor); ?>
            </span>
        <?php endif; ?>
    </a>
    <div class="header__menu menu">
        <div class="menu__header">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="menu__logo">
                <img
                    src="<?php echo esc_url($logo['url']); ?>"
                    alt="<?php echo esc_attr($logo['alt']) ?: 'Логотип '; ?>">
            </a>
        </div>
        <nav aria-label="Меню" class="menu__body">
            <?php
            wp_nav_menu([
                'theme_location' => 'primary_menu',
                'container'      => false,
                'menu_class'     => 'menu__list',
                'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                'walker'         => new Menu_Nav_Walker(),
            ]);
            ?>
        </nav>
        <?php if ($phone || $email || $socials): ?>
            <div class="menu__footer">
                <?php if ($phone || $email): ?>
                    <div class="menu__contacts">
                        <?php if ($phone): ?>
                            <a href="tel:<?php echo esc_attr(preg_replace('/[^\d\+]/', '', $phone)); ?>" class="header__contacts-phone"><?php echo esc_html($phone); ?></a>
                        <?php endif; ?>
                        <?php if ($email): ?>
                            <a href="mailto:<?php echo esc_attr($email); ?>" class="header__contacts-email">
                                <?php echo esc_html($email); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <?php if (have_rows('social_links', 'option')): ?>
                    <div class="menu__socials socials">
                        <?php while (have_rows('social_links', 'option')): the_row();
                            $show_in_header = get_sub_field('show_in_header');
                            $show_item = get_sub_field('show_item');

                            if (!$show_item || !$show_in_header) continue;

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
        <?php endif; ?>
    </div>
    <?php if ($phone || $email): ?>
        <div class="header__contacts">
            <?php if ($phone): ?>
                <a href="tel:<?php echo esc_attr(preg_replace('/[^\d\+]/', '', $phone)); ?>" class="header__contacts-phone"><?php echo esc_html($phone); ?></a>
            <?php endif; ?>
            <?php if ($email): ?>
                <a href="mailto:<?php echo esc_attr($email); ?>" class="header__contacts-email">
                    <?php echo esc_html($email); ?>
                </a>
            <?php endif; ?>
        </div>
    <?php endif; ?>
    <?php if (have_rows('social_links', 'option')): ?>
        <div class="header__socials socials">
            <?php while (have_rows('social_links', 'option')): the_row();
                $show_in_header = get_sub_field('show_in_header');
                $show_item = get_sub_field('show_item');

                if (!$show_item || !$show_in_header) continue;

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
    <a href="#callback" data-fancybox aria-label="Заказать звонок" class="header__callback icon-phone-incoming"></a>
    <button type="button" aria-label="Открыть мобильное меню" class="header__menu-toggler icon-menu">
        <span></span><span></span><span></span>
    </button>
</div>