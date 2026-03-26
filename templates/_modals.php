<?php

$error_submitting_title = get_field('error_submitting_title', 'option');
$error_submitting_subtitle = get_field('error_submitting_subtitle', 'option');
$error_submitting_close_btn = get_field('error_submitting_close_btn', 'option') ?? "ок, закрыть";

$success_title = get_field('success_title', 'option');
$success_subtitle = get_field('success_subtitle', 'option');
$success_close_btn = get_field('success_close_btn', 'option') ?? "ок, закрыть";


?>


<div class="popup" id="callback">
    <h3 class="popup__title">Оставить заявку</h3>
    <div class="popup__form">
        <?php echo do_shortcode('[contact-form-7 id="9d04051" title="Контактная форма в модальном окне Оставить заявку"]') ?>
    </div>
</div>

<div class="popup popup--small" id="error-submitting">

    <?php if ($error_submitting_title): ?>
        <h3 class="popup__title title-sm">
            <?php echo esc_html($error_submitting_title) ?>
        </h3>
    <?php endif; ?>
    <?php if ($error_submitting_subtitle): ?>
        <p class="popup__subtitle">
            <?php echo esc_html($error_submitting_subtitle) ?>
        </p>
    <?php endif; ?>
    <button
        type="button"
        data-fancybox-close
        class="popup__btn btn btn-secondary">
        <?php echo esc_html($error_submitting_close_btn) ?>
    </button>
</div>

<div class="popup popup--small" id="success-submitting">
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
    <button
        type="button"
        data-fancybox-close
        class="popup__btn btn btn-secondary">
        <?php echo esc_html($success_close_btn) ?>
    </button>
</div>