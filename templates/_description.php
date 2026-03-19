<?php
$advantages_title = get_field('description_advantages_title');
$advantages_list  = get_field('description_advantages_list');
$booking_title    = get_field('description_booking_title');
$booking_steps    = get_field('description_booking_steps');
?>

<section class="description">
    <div class="description__container container">
        <div class="description__column">
            <?php if ($advantages_title) : ?>
                <h2 class="description__title title"><?php echo esc_html($advantages_title); ?></h2>
            <?php endif; ?>

            <?php if ($advantages_list) : ?>
                <ul class="description__list">
                    <?php foreach ($advantages_list as $advantage) : ?>
                        <?php if ($advantage['text']) : ?>
                            <li><?php echo esc_html($advantage['text']); ?></li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>

        <div class="description__column">
            <?php if ($booking_title) : ?>
                <h2 class="description__title title"><?php echo esc_html($booking_title); ?></h2>
            <?php endif; ?>

            <?php if ($booking_steps) : ?>
                <ol class="description__steps">
                    <?php foreach ($booking_steps as $step) : ?>
                        <?php if ($step['text']) : ?>
                            <li><?php echo esc_html($step['text']); ?></li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ol>
            <?php endif; ?>
        </div>
    </div>
</section>