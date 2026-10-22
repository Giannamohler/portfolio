<?php

function get_project_by_id(int $id): array {
    //collect data
    $title = get_the_title($id);
    $image_id = carbon_get_post_meta($id, 'image');
    $image = get_media_by_id( id: $image_id);
    $lead = carbon_get_post_meta($id, 'lead');
    $description = carbon_get_post_meta($id, 'description');
    $text = carbon_get_post_meta($id, 'text');
    //return data
    return [
        'title' => $title,
        'image' => $image,
        'lead' => $lead,
        'description' => $description,
        'text' => $text,
    ];
}