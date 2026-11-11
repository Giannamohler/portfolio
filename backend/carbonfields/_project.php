<?php

use Carbon_Fields\Container;
use Carbon_Fields\Field;


// =========================================
// 1. PROJEKT KONFIGURATION
// =========================================

Container::make('post_meta', 'Projekt')
    ->where('post_type', '=', 'project')
    ->add_fields([

        // =================================
        // PROJEKTART
        // =================================

        Field::make('select', 'project_type', 'Projektkategorie')
            ->add_options([
                'stills' => 'Stills',
                'motion' => 'Motion',
            ])
            ->set_required()
            ->set_help_text('Wähle aus, ob es sich um ein Stills- oder Motion-Projekt handelt.'),


        // =================================
        // GRUNDDATEN
        // =================================

        Field::make('image', 'image', 'Vorschaubild')
            ->set_required()
            ->set_help_text('Dieses Bild erscheint in der Projektübersicht.'),

        Field::make('text', 'year', 'Jahr')
            ->set_attribute('placeholder', 'z. B. 2026')
            ->set_help_text('Jahr, in dem das Projekt entstanden ist.'),

        Field::make('textarea', 'description', 'Beschreibung')
            ->set_required()
            ->set_help_text('Kurzer Beschreibungstext für die Projektübersicht.'),


        // =================================
        // PROJEKTDETAILS
        // =================================

        Field::make('textarea', 'lead', 'Lead')
            ->set_required()
            ->set_help_text('Kurze Einleitung im Projekt-Popup.'),

        Field::make('rich_text', 'text', 'Projektbeschreibung')
            ->set_required()
            ->set_help_text('Ausführliche Beschreibung des Projekts.'),


        // =================================
        // BILDERGALERIE: NUR STILLS
        // =================================

        Field::make('complex', 'gallery', 'Bildergalerie')
            ->add_fields([
                Field::make('image', 'gallery_image', 'Bild')
                    ->set_required(),
            ])
            ->set_layout('grid')
            ->set_header_template('<%- $_index + 1 %>. Bild')
            ->set_help_text('Hier kannst du zusätzliche Bilder für das Stills-Projekt hochladen.')
            ->set_conditional_logic([
                [
                    'field' => 'project_type',
                    'value' => 'stills',
                ],
            ]),


        // =================================
        // VIDEO: NUR MOTION
        // =================================

        Field::make('text', 'youtube_url', 'YouTube-Link')
            ->set_attribute('placeholder', 'https://www.youtube.com/watch?v=...')
            ->set_help_text('Hier den YouTube-Link zum Motion-Projekt einfügen.')
            ->set_conditional_logic([
                [
                    'field' => 'project_type',
                    'value' => 'motion',
                ],
            ]),

    ]);


// =========================================
// 2. PROJEKTKATEGORIE MIT TAXONOMIE SYNCHRONISIEREN
// =========================================

add_action('save_post_project', function ($post_id) {

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (wp_is_post_revision($post_id)) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    $project_type = carbon_get_post_meta(
        $post_id,
        'project_type'
    );

    if (!in_array($project_type, ['stills', 'motion'], true)) {
        return;
    }

    wp_set_object_terms(
        $post_id,
        $project_type,
        'project_category',
        false
    );

}, 20);