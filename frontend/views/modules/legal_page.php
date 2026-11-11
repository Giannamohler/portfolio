<?php
$data = $args['data'] ?? [];
$legal_type = $data['legal_type'] ?? '';
$contact = $data['global_contact'] ?? [];
$sections = $data['legal_sections'] ?? [];
?>

<main data-page="legal" class="legal-page">
    <header class="legal-page-header">
        <p class="legal-page-eyebrow">
            <?= $legal_type === 'impressum' ? 'Rechtliche Informationen' : 'Datenschutz' ?>
        </p>

        <h1 class="legal-page-title">
            <?= esc_html($data['title'] ?? '') ?>
        </h1>

        <?php if (!empty($data['intro'])) : ?>
            <div class="legal-page-intro">
                <?= wp_kses_post(wpautop($data['intro'])) ?>
            </div>
        <?php endif; ?>
    </header>

    <div class="legal-page-content">

        <?php if (in_array($legal_type, ['impressum', 'datenschutz'], true)) : ?>
            <section class="legal-contact-details">
                <h2>Verantwortliche Person</h2>

                <p>
                    <?= esc_html('Gianna Mohler') ?><br>
                    <?php if (!empty($contact['street'])) : ?>
                        <?= esc_html($contact['street']) ?><br>
                    <?php endif; ?>
                    <?php if (!empty($contact['postcode']) || !empty($contact['city'])) : ?>
                        <?= esc_html(trim(($contact['postcode'] ?? '') . ' ' . ($contact['city'] ?? ''))) ?><br>
                    <?php endif; ?>
                    <?php if (!empty($contact['country'])) : ?>
                        <?= esc_html($contact['country']) ?>
                    <?php endif; ?>
                </p>

                <?php if (!empty($contact['email'])) : ?>
                    <p>
                        E-Mail:
                        <a href="mailto:<?= esc_attr($contact['email']) ?>">
                            <?= esc_html($contact['email']) ?>
                        </a>
                    </p>
                <?php endif; ?>
            </section>
        <?php endif; ?>

        <?php foreach ($sections as $section) : ?>
            <section class="legal-content-section">
                <?php if (!empty($section['heading'])) : ?>
                    <h2><?= esc_html($section['heading']) ?></h2>
                <?php endif; ?>

                <?php if (!empty($section['content'])) : ?>
                    <div class="legal-rich-text">
                        <?= apply_filters('the_content', $section['content']) ?>
                    </div>
                <?php endif; ?>
            </section>
        <?php endforeach; ?>

    </div>
</main>
