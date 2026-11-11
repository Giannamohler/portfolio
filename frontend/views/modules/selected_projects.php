<?php

$data = $args['data'] ?? [];
$projects = $data['projects'] ?? [];

?>

<section data-module="selected-projects">

    <div class="projects-heading">

        <div class="projects-heading-text">

            <p class="subtitle">
                <?= esc_html($data['subtitle'] ?? '') ?>
            </p>

            <h2 class="title">
                <?= esc_html($data['title'] ?? '') ?>
            </h2>

        </div>

        <a
            class="projects-button"
            href="<?= esc_url($data['button_link'] ?? '#') ?>"
        >
            <?= esc_html($data['button_text'] ?? '') ?>
        </a>

    </div>


    <?php if (!empty($data['description'])) : ?>

        <p class="projects-description">
            <?= esc_html($data['description']) ?>
        </p>

    <?php endif; ?>


    <div class="projects-grid">

        <?php foreach ($projects as $index => $project) : ?>

            <?php

            $project_id = (int) ($project['id'] ?? 0);
            $modal_id = 'home-project-' . $project_id;

            $image = $project['image'] ?? [];
            $categories = $project['project_categories'] ?? [];
            $is_motion = in_array('motion', array_map('strtolower', $categories), true);
            $youtube_url = trim($project['youtube_url'] ?? '');

            ?>

            <article class="project-card project-card-<?= esc_attr($index + 1) ?>">

                <button
                    class="project-card-button project-card-link"
                    type="button"
                    data-project-modal-open="<?= esc_attr($modal_id) ?>"
                    aria-label="<?= esc_attr('Projekt ' . ($project['title'] ?? '') . ' öffnen') ?>"
                >

                    <div class="project-card-image">

                        <?php if (!empty($image['src'])) : ?>

                            <img
                                src="<?= esc_url($image['src']) ?>"
                                alt="<?= esc_attr($image['alt'] ?? $project['title'] ?? '') ?>"
                                loading="lazy"
                            >

                        <?php endif; ?>

                    </div>


                    <div class="project-card-title">

                        <h3><?= esc_html($project['title'] ?? '') ?></h3>

                        <span aria-hidden="true"></span>

                    </div>


                    <?php if (!empty($categories)) : ?>

                        <p class="project-card-categories">
                            <?= esc_html(implode(' · ', $categories)) ?>
                        </p>

                    <?php endif; ?>

                </button>

            </article>


            <!-- PROJEKT-POP-UP -->

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

                                        <span class="project-video-play-icon">
                                            &#9654;
                                        </span>

                                    </button>

                                </div>

                            <?php else : ?>

                                <p class="project-empty-message">
                                    Für dieses Projekt wurde noch kein YouTube-Link hinterlegt.
                                </p>

                            <?php endif; ?>


                        <?php else : ?>

                            <?php if (!empty($image['src'])) : ?>

                                <div class="project-modal-main-image">

                                    <img
                                        src="<?= esc_url($image['src']) ?>"
                                        alt="<?= esc_attr($image['alt'] ?? $project['title'] ?? '') ?>"
                                    >

                                </div>

                            <?php endif; ?>

                        <?php endif; ?>


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

</section>
