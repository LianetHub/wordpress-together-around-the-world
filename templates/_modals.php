<?php

$privacy_txt = get_field('privacy_txt', 'option');

$callback_form_image = get_field('callback_form_image', 'option');
$callback_form_title = get_field('callback_form_title', 'option');
$callback_form_subtitle = get_field('callback_form_subtitle', 'option');
$callback_form_btn = get_field('callback_form_btn', 'option') ?? "Отправить";

$error_title = get_field('error_title', 'option');
$error_subtitle = get_field('error_subtitle', 'option');
$error_close_btn = get_field('error_close_btn', 'option') ?? "ок, закрыть";
$error_icon = get_field('error_icon', 'option');

$success_title = get_field('success_title', 'option');
$success_subtitle = get_field('success_subtitle', 'option');
$success_close_btn = get_field('success_close_btn', 'option') ?? "ок, закрыть";
$success_icon = get_field('success_icon', 'option');

?>

<!-- 
<div class="popup" id="callback">
    <div class="popup__content">
        <?php if ($callback_form_title): ?>
            <h3 class="popup__title title-sm"> <?php echo esc_html($callback_form_title) ?></h3>
        <?php endif; ?>
        <?php if ($callback_form_subtitle): ?>
            <p class="popup__subtitle"><?php echo esc_html($callback_form_subtitle) ?></p>
        <?php endif; ?>
        <form action="<?php echo esc_url(admin_url('admin-ajax.php')); ?>" method="POST" class="popup__form form">
            <input type="hidden" name="action" value="send_callback_form">
            <label class="popup__form-field form__field">
                <span class="form__field-label form__field-label--required">Ваше имя</span>
                <input type="text" name="username" data-required class="form__control" placeholder="Введите имя">
            </label>
            <label class="popup__form-field form__field">
                <span class="form__field-label form__field-label--required">Ваш телефон</span>
                <input type="tel" name="phone" data-required class="form__control" placeholder="+7 (___) ___-__-__">
            </label>
            <div class="popup__form-footer">
                <button type="submit" class="form__btn btn btn-primary btn-sm">
                    <?php echo esc_html($callback_form_btn) ?>
                </button>
                <div class="form__policy">
                    <?php echo wp_kses_post($privacy_txt) ?>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="popup popup--small" id="error-submitting">
    <?php if ($error_icon): ?>
        <div class="popup__icon">
            <img src="<?php echo esc_url($error_icon['url']); ?>" alt="<?php echo esc_attr($error_icon['alt']) ?: 'Иконка'; ?>">
        </div>
    <?php endif; ?>
    <?php if ($error_title): ?>
        <h3 class="popup__title title-sm">
            <?php echo esc_html($error_title) ?>
        </h3>
    <?php endif; ?>
    <?php if ($error_subtitle): ?>
        <p class="popup__subtitle">
            <?php echo esc_html($error_subtitle) ?>
        </p>
    <?php endif; ?>
    <button type="button" data-fancybox-close class="popup__btn btn btn-secondary">
        <?php echo esc_html($error_close_btn) ?>
    </button>
</div>

<div class="popup popup--small" id="success-submitting">
    <?php if ($success_icon): ?>
        <div class="popup__icon">
            <img src="<?php echo esc_url($success_icon['url']); ?>" alt="<?php echo esc_attr($success_icon['alt']) ?: 'Иконка'; ?>">
        </div>
    <?php endif; ?>
    <?php if ($success_title): ?>
        <h3 class="popup__title title-sm">
            <?php echo esc_html($success_title) ?>
        </h3>
    <?php endif; ?>
    <?php if ($success_subtitle): ?>
        <p class="popup__subtitle">
            <?php echo esc_html($success_subtitle) ?>
        </p>
    <?php endif; ?>
    <button type="button" data-fancybox-close class="popup__btn btn btn-secondary">
        <?php echo esc_html($success_close_btn) ?>
    </button>
</div> -->