<?php
$menu = get_menu_by_slug(slug: 'legals');
$logo = get_globals_logo();
?>

<footer data-layout="footer">
    <img class="logo" src="<?= $logo['src'] ?>" alt="<?= $logo['alt'] ?>">
    <nav class="nav-container">
        <ul class="nav">
        <?php foreach ($menu as $item) : ?>
            <li class="nav-item">
                <a target="<?= $item['target'] ?>" href="<?= $item['url'] ?>">
                <?= $item['title'] ?>
                </a>
            </li>
        <?php endforeach; ?>
        </ul>        
    </nav>
</footer>
