
<?php
$data = $args['data'];
?>

<section data-module="hero">
    <div class="hero-content">
        <div class="hero-text">
            <p class="subtitle">
                <?= esc_html($data['subtitle']) ?>
            </p>

            <h1 class="title">
                <?= nl2br(esc_html($data['title'])) ?>
            </h1>

            <p class="description">
                <?= esc_html($data['description']) ?>
            </p>

            <a class="button" href="<?= esc_url($data['button_link']) ?>">
                <?= esc_html($data['button_text']) ?>
                <span aria-hidden="true">↗</span>
            </a>
        </div>

        <div class="hero-images">
            <img
                class="portrait"
                src="<?= esc_url($data['portrait']['src']) ?>"
                alt="<?= esc_attr($data['portrait']['alt']) ?>"
            >

            <img
                class="secondary-image"
                src="<?= esc_url($data['secondary_image']['src']) ?>"
                alt="<?= esc_attr($data['secondary_image']['alt']) ?>"
            >
        </div>
    </div>
</section>
