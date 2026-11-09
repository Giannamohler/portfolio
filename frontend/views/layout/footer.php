<?php
$legal_menu = get_menu_by_slug(slug: 'legals');
$socials = get_globals_socials();
$email = carbon_get_theme_option('email');
?>

<footer data-layout="footer">

    <div class="footer-top">

        <div class="footer-heading">
            <h2>In Kontakt bleiben.</h2>

            <a class="footer-arrow"
               href="mailto:<?= esc_attr($email) ?>"
               aria-label="E-Mail schreiben">
                ↗
            </a>
        </div>

        <div class="footer-contact">

            <a class="footer-email"
               href="mailto:<?= esc_attr($email) ?>">
                <?= esc_html($email) ?>
            </a>

            <div class="footer-socials">
                <?php foreach ($socials as $social) : ?>
                    <a href="<?= esc_url($social['link']) ?>"
                       target="_blank"
                       rel="noopener noreferrer"
                       aria-label="<?= esc_attr($social['title']) ?>">

                        <img
                            src="<?= esc_url($social['icon']['src']) ?>"
                            alt="<?= esc_attr($social['icon']['alt']) ?>"
                        >

                    </a>
                <?php endforeach; ?>
            </div>

        </div>

    </div>

    <div class="footer-bottom">

        <p class="footer-copyright">
            Gianna Mohler · Portfolio
        </p>

        <nav class="footer-legal" aria-label="Rechtliche Informationen">
            <?php foreach ($legal_menu as $item) : ?>
                <a href="<?= esc_url($item['url']) ?>">
                    <?= esc_html($item['title']) ?>
                </a>
            <?php endforeach; ?>
        </nav>

    </div>

</footer>