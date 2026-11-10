
<?php

// =========================================
// PROJEKT DATEN LADEN
// =========================================

function get_project_by_id(int $id): array {

    // Grunddaten
    $title = get_the_title($id);

    $image_id = carbon_get_post_meta($id, 'image');
    $image = get_media_by_id($image_id, 'full');

    $description = carbon_get_post_meta($id, 'description');
    $lead = carbon_get_post_meta($id, 'lead');
    $text = carbon_get_post_meta($id, 'text');

    // Jahr
    $year = carbon_get_post_meta($id, 'year');

    // YouTube-Link
    $youtube_url = carbon_get_post_meta($id, 'youtube_url');


    // =========================================
    // PROJEKTKATEGORIEN
    // =========================================

    $terms = get_the_terms($id, 'project_category');

    $project_categories = [];

    if (is_array($terms)) {
        $project_categories = array_map(
            fn($term) => $term->name,
            $terms
        );
    }


    // =========================================
    // BILDERGALERIE
    // =========================================

    $gallery_data = carbon_get_post_meta($id, 'gallery');

    $gallery = [];

    if (is_array($gallery_data)) {

        foreach ($gallery_data as $item) {

            $gallery_image_id = $item['gallery_image'] ?? null;

            if (!$gallery_image_id) {
                continue;
            }

            $gallery_image = get_media_by_id(
                $gallery_image_id,
                'full'
            );

            if ($gallery_image) {
                $gallery[] = $gallery_image;
            }

        }

    }


    // =========================================
    // RÜCKGABE ALLER PROJEKTDATEN
    // =========================================

    return [

        'id' => $id,

        'title' => $title,

        'image' => $image,

        'description' => $description,

        'lead' => $lead,

        'text' => $text,

        'year' => $year,

        'youtube_url' => $youtube_url,

        'gallery' => $gallery,

        'project_categories' => $project_categories,

        'url' => get_permalink($id),

    ];

}
