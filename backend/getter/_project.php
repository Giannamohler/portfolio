<?php

function get_project_by_id (int $id): array {
    // -> collect data
    $title = get_the_title($id);
    $image_id = carbon_get_post_meta($id, 'image');
    $image = get_media_by_id(id: $image_id);
    $lead = carbon_get_post_meta($id, 'lead');
    $description = carbon_get_post_meta($id, 'description');
    $text = carbon_get_post_meta($id, 'text');
    // -> load project_category
    $project_categories = array_map(callback: function($item) {
        return $item->name;
    }, array: get_the_terms($id, 'project_category'));
    // -> return data
    return [
        'title' => $title,
        'image' => $image,
        'lead' => $lead,
        'description' => $description,
        'text' => $text,
        'project_categories' => $project_categories,
    ];
}