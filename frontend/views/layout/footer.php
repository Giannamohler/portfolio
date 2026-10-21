<?php
$menu = get_menu_by_slug(slug: 'legals');
?>

<footer data-layout="footer">
    <mark>hier kommt der footer</mark>
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
