<?php
$project = get_project_by_id(get_the_ID())
?>

<main data-page="project">
    <section class="hero">
        <div class="container" data-utility="wrap-page">
            <p class="preline">
                <?php foreach ($project['project_categories'] as $category) : ?>
                    <span class="category-item"><?= $category ?></span>
                <?php endforeach; ?>
            </p>
            <p class="type">Projekt</p>
            <h1 class="title"><?= $project['title'] ?></h1>
        </div>
    </section>
    <section class="content">
        <div class="container" data-utility="wrap-page">
            <img class="image" src="<?= $project['image']['src'] ?>" alt="<?= $project['image']['alt'] ?>">
            <p class="lead"><?= $project['lead'] ?></p>
            <div data-utility="wysiwyg" class="text">
                <?= wpautop($project['text']); ?>
            </div>
        </div>
    </section>
</main>