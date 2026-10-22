<?php
$project = get_project_by_id( id: get_the_ID());
?>

<main data-page="project">
    <p class="preline">Project</p>
    <h1 class="title"><?= $project ['title'] ?></h1>
    <img class="image" src="<?= $project['image']['src'] ?>" alt="<?= $project['image']['alt'] ?>">
    <p class="lead"><?= $project['lead'] ?></p>
    <div class="text">
        <?= wpautop($project['text']) ?>
    </div>
</main>