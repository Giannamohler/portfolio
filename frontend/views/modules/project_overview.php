<?php

$data = $args['data'] ?? [];

$sections = [
    [
        'key' => 'stills',
        'title' => $data['stills_title'] ?? 'Stills',
        'projects' => $data['stills_projects'] ?? [],
    ],
    [
        'key' => 'motion',
        'title' => $data['motion_title'] ?? 'Motion',
        'projects' => $data['motion_projects'] ?? [],
    ],
];

?>

<main data-page="project-overview">

    <section class="project-overview">

        <div class="project-overview-header">

            <h1 class="project-overview-title">
                <?= esc_html($data['title'] ?? 'Selected Work') ?>
            </h1>

        </div>


        <?php foreach ($sections as $section) : ?>

            <section
                class="project-category-section"
                data-project-carousel="<?= esc_attr($section['key']) ?>"
            >

                <div class="project-category-header">

                    <h2 class="project-category-title">
                        <?= esc_html($section['title']) ?>
                    </h2>

                    <div class="project-carousel-controls">

                        <button
                            class="project-carousel-button"
                            type="button"
                            data-carousel-prev
                            aria-label="Vorherige Projekte"
                        >
                            
                        </button>

                        <button
                            class="project-carousel-button"
                            type="button"
                            data-carousel-next
                            aria-label="Weitere Projekte"
                        >
                            
                        </button>

                    </div>

                </div>


                <?php if (!empty($section['projects'])) : ?>

                    <div class="project-carousel">

                        <div
                            class="project-carousel-track"
                            data-carousel-track
                        >

                            <?php foreach ($section['projects'] as $project) : ?>

                                <?php

                                $project_id = $project['id'] ?? 0;

                                $modal_id = $section['key'] . '-project-' . $project_id;

                                $image = $project['image'] ?? [];

                                $categories = $project['project_categories'] ?? [];

                                // Kategorie unabhängig von Gross- und Kleinschreibung prüfen

                                $normalised_categories = array_map(
                                    'strtolower',
                                    $categories
                                );

                                $is_motion = in_array(
                                    'motion',
                                    $normalised_categories,
                                    true
                                );

                                $youtube_url = trim(
                                    $project['youtube_url'] ?? ''
                                );

                                ?>

                                <!-- PROJEKTKARTE -->

                                <article class="project-card">

                                    <button
                                        class="project-card-button"
                                        type="button"
                                        data-project-modal-open="<?= esc_attr($modal_id) ?>"
                                        aria-label="<?= esc_attr('Projekt ' . ($project['title'] ?? '') . ' öffnen') ?>"
                                    >

                                        <div class="project-card-image-wrapper">

                                            <?php if (!empty($image['src'])) : ?>

                                                <img
                                                    class="project-card-image"
                                                    src="<?= esc_url($image['src']) ?>"
                                                    alt="<?= esc_attr($image['alt'] ?? $project['title']) ?>"
                                                    loading="lazy"
                                                >

                                            <?php endif; ?>

                                        </div>

                                        <div class="project-card-info">

                                            <h3 class="project-card-title">
                                                <?= esc_html($project['title'] ?? '') ?>
                                            </h3>

                                            <span class="project-card-year">
                                                <?= esc_html($project['year'] ?? '') ?>
                                            </span>

                                        </div>

                                    </button>

                                </article>


                                <!-- PROJEKT POP-UP -->

                                <div
                                    class="project-modal"
                                    id="<?= esc_attr($modal_id) ?>"
                                    data-project-modal
                                    aria-hidden="true"
                                >

                                    <div
                                        class="project-modal-overlay"
                                        data-project-modal-close
                                    ></div>


                                    <div
                                        class="project-modal-content"
                                        role="dialog"
                                        aria-modal="true"
                                        aria-labelledby="<?= esc_attr($modal_id . '-title') ?>"
                                    >

                                        <button
                                            class="project-modal-close"
                                            type="button"
                                            data-project-modal-close
                                            aria-label="Fenster schliessen"
                                        >
                                            &times;
                                        </button>


                                        <div class="project-modal-body">


                                            <?php if ($is_motion) : ?>

                                                <!-- MOTION: VIDEO MIT PLAY-BUTTON -->

                                                <?php if (!empty($youtube_url)) : ?>

                                                    <div class="project-modal-video-placeholder">

                                                        <button
                                                            class="project-video-play"
                                                            type="button"
                                                            data-project-video-play
                                                            data-youtube-url="<?= esc_url($youtube_url) ?>"
                                                            aria-label="Video abspielen"
                                                        >

                                                            <?php if (!empty($image['src'])) : ?>

                                                                <img
                                                                    src="<?= esc_url($image['src']) ?>"
                                                                    alt="<?= esc_attr($project['title'] ?? '') ?>"
                                                                >

                                                            <?php endif; ?>

                                                            <span class="project-video-play-icon" aria-hidden="true"></span>

                                                        </button>

                                                    </div>

                                                <?php else : ?>

                                                    <p class="project-empty-message">
                                                        Für dieses Projekt wurde noch kein YouTube-Link hinterlegt.
                                                    </p>

                                                <?php endif; ?>


                                            <?php else : ?>

                                                <!-- STILLS: GROSSES HAUPTBILD -->

                                                <?php if (!empty($image['src'])) : ?>

                                                    <div class="project-modal-main-image">

                                                        <img
                                                            src="<?= esc_url($image['src']) ?>"
                                                            alt="<?= esc_attr($image['alt'] ?? $project['title']) ?>"
                                                        >

                                                    </div>

                                                <?php endif; ?>

                                            <?php endif; ?>


                                            <!-- PROJEKTINFORMATIONEN -->

                                            <div class="project-modal-text">

                                                <div class="project-modal-meta">

                                                    <span>
                                                        <?= esc_html(implode(' / ', $categories)) ?>
                                                    </span>

                                                    <?php if (!empty($project['year'])) : ?>

                                                        <span>
                                                            <?= esc_html($project['year']) ?>
                                                        </span>

                                                    <?php endif; ?>

                                                </div>


                                                <h2
                                                    class="project-modal-title"
                                                    id="<?= esc_attr($modal_id . '-title') ?>"
                                                >
                                                    <?= esc_html($project['title'] ?? '') ?>
                                                </h2>


                                                <?php if (!empty($project['lead'])) : ?>

                                                    <p class="project-modal-lead">
                                                        <?= esc_html($project['lead']) ?>
                                                    </p>

                                                <?php endif; ?>


                                                <?php if (!empty($project['text'])) : ?>

                                                    <div class="project-modal-description">
                                                        <?= wp_kses_post($project['text']) ?>
                                                    </div>

                                                <?php endif; ?>

                                            </div>


                                            <?php if (!$is_motion && !empty($project['gallery'])) : ?>

                                                <!-- STILLS: BILDERGALERIE -->

                                                <div class="project-modal-gallery">

                                                    <?php foreach ($project['gallery'] as $gallery_image) : ?>

                                                        <?php if (!empty($gallery_image['src'])) : ?>

                                                            <img
                                                                src="<?= esc_url($gallery_image['src']) ?>"
                                                                alt="<?= esc_attr($gallery_image['alt'] ?? '') ?>"
                                                                loading="lazy"
                                                            >

                                                        <?php endif; ?>

                                                    <?php endforeach; ?>

                                                </div>

                                            <?php endif; ?>


                                        </div>

                                    </div>

                                </div>

                            <?php endforeach; ?>

                        </div>

                    </div>

                <?php else : ?>

                    <p class="project-empty-message">
                        Hier sind aktuell keine Projekte vorhanden.
                    </p>

                <?php endif; ?>

            </section>

        <?php endforeach; ?>

    </section>

</main>