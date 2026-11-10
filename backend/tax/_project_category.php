<?php

add_action('init', function () {

    register_taxonomy('project_category', ['project'], [
        'labels' => [
            'name' => 'Projektkategorien',
            'singular_name' => 'Projektkategorie',
        ],

        'hierarchical' => false,

        'public' => true,
        'show_ui' => true,
        'show_in_rest' => true,
        'show_admin_column' => true,

        'rewrite' => [
            'slug' => 'projektkategorie',
        ],
    ]);

});