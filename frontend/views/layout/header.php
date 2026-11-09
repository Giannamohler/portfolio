
<?php
$menu = get_menu_by_slug(slug: 'main');
$logo = get_globals_logo();
?>

<header data-layout="header">
    <a class="logo-link" href="<?= esc_url(home_url('/')) ?>">
        <img
            class="logo"
            src="<?= esc_url($logo['src']) ?>"
            alt="<?= esc_attr($logo['alt']) ?>"
        >
    </a>

    <nav class="nav-container" aria-label="Hauptnavigation">
        <ul class="nav">
            <?php foreach ($menu as $item) : ?>
                <li class="nav-item">
                    <a
                        target="<?= esc_attr($item['target']) ?>"
                        href="<?= esc_url($item['url']) ?>"
                    >
                        <?= esc_html($item['title']) ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>
</header>
