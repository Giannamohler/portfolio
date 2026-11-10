<?php
$data = $args['data'];
?>

<section data-module="about">

    <div class="about-page-title">
        <h1>
            <?= esc_html($data['page_title']) ?>
        </h1>

        <span class="about-decoration" aria-hidden="true">✳</span>
    </div>

    <div class="about-content">

        <div class="about-text">

            <p class="about-subtitle">
                <?= esc_html($data['subtitle']) ?>
            </p>

            <h2 class="about-heading">
                <?= esc_html($data['title']) ?>
            </h2>

            <div class="about-description">
                <?= wpautop(esc_html($data['description'])) ?>
            </div>

            <div class="about-bottom">

                <p class="about-section-label">
                    <?= esc_html($data['section_label']) ?>
                </p>

                <a
                    class="about-button"
                    href="<?= esc_url($data['button_link']) ?>"
                >
                    <?= esc_html($data['button_text']) ?>
                    <span aria-hidden="true">↗</span>
                </a>

            </div>

        </div>

        <div class="about-image-wrapper">

            <?php if (!empty($data['image']['src'])) : ?>

                <img
                    class="about-image"
                    src="<?= esc_url($data['image']['src']) ?>"
                    alt="<?= esc_attr($data['image']['alt']) ?>"
                >

            <?php endif; ?>

            <?php if (!empty($data['image_caption'])) : ?>
                <p class="about-image-caption">
                    <?= esc_html($data['image_caption']) ?>
                </p>
            <?php endif; ?>

        </div>

    </div>

</section>