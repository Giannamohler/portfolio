<?php
$data = $args['data'];
$projects = $data['projects'] ?? [];
?>

<section data-module="selected-projects">

    <div class="projects-heading">

        <div class="projects-heading-text">
            <p class="subtitle">
                <?= esc_html($data['subtitle']) ?>
            </p>

            <h2 class="title">
                <?= esc_html($data['title']) ?>
            </h2>
        </div>

        <a class="projects-button"
           href="<?= esc_url($data['button_link']) ?>">
            <?= esc_html($data['button_text']) ?>
            <span aria-hidden="true">↗</span>
        </a>

    </div>

    <?php if (!empty($data['description'])) : ?>
        <p class="projects-description">
            <?= esc_html($data['description']) ?>
        </p>
    <?php endif; ?>

    <div class="projects-grid">

        <?php foreach ($projects as $index => $project) : ?>

            <article class="project-card project-card-<?= $index + 1 ?>">

                <a href="<?= esc_url($project['url']) ?>"
                   class="project-card-link">

                    <div class="project-card-image">

                        <?php if (!empty($project['image']['src'])) : ?>
                            <img
                                src="<?= esc_url($project['image']['src']) ?>"
                                alt="<?= esc_attr($project['image']['alt']) ?>"
                            >
                        <?php endif; ?>

                    </div>

                    <div class="project-card-title">
                        <h3><?= esc_html($project['title']) ?></h3>
                        <span aria-hidden="true">↗</span>
                    </div>

                    <?php if (!empty($project['categories'])) : ?>
                        <p class="project-card-categories">
                            <?= esc_html(implode(' · ', $project['categories'])) ?>
                        </p>
                    <?php endif; ?>

                </a>

            </article>

        <?php endforeach; ?>

    </div>

</section>