<?php

use Carbon_Fields\Container;
use Carbon_Fields\Field;


// =========================================
// 1. MODULE KONFIGURATION
// =========================================

Container::make('post_meta', 'Modul 1')
    ->where('post_type', 'IN', ['page'])
    ->add_fields([

        Field::make('complex', 'modules', 'Module')


            // =================================
            // HERO
            // =================================

            ->add_fields('hero', 'Hero', [

                Field::make('text', 'subtitle', 'Untertitel')
                    ->set_required(),

                Field::make('text', 'title', 'Titel')
                    ->set_required(),

                Field::make('textarea', 'description', 'Beschreibung')
                    ->set_required(),

                Field::make('image', 'portrait', 'Portraitbild')
                    ->set_required(),

                Field::make('image', 'secondary_image', 'Zweites Bild')
                    ->set_required(),

                Field::make('text', 'button_text', 'Button Text')
                    ->set_required(),

                Field::make('text', 'button_link', 'Button Link')
                    ->set_required(),

            ])


            // =================================
            // ÜBER MICH
            // =================================

            ->add_fields('about', 'Über mich', [

                Field::make('text', 'page_title', 'Seitentitel')
                    ->set_default_value('Über mich')
                    ->set_required(),

                Field::make('text', 'subtitle', 'Untertitel')
                    ->set_default_value('Gianna Mohler / Multimedia Production')
                    ->set_required(),

                Field::make('text', 'title', 'Haupttitel')
                    ->set_default_value('Hallo, ich bin Gianna.')
                    ->set_required(),

                Field::make('textarea', 'description', 'Beschreibung')
                    ->set_required(),

                Field::make('image', 'image', 'Portraitbild')
                    ->set_required(),

                Field::make('text', 'image_caption', 'Bildlegende'),

                Field::make('text', 'section_label', 'Beschriftung unter Text')
                    ->set_default_value('Über mich'),

                Field::make('text', 'button_text', 'Button Text')
                    ->set_default_value('Meine Projekte')
                    ->set_required(),

                Field::make('text', 'button_link', 'Button Link')
                    ->set_default_value('/projekte/')
                    ->set_required(),

            ])


            // =================================
            // AUSGEWÄHLTE PROJEKTE
            // =================================

            ->add_fields('selected_projects', 'Ausgewählte Projekte', [

                Field::make('text', 'subtitle', 'Untertitel')
                    ->set_default_value('Ein kleiner Einblick'),

                Field::make('text', 'title', 'Titel')
                    ->set_default_value('Ausgewählte Projekte')
                    ->set_required(),

                Field::make('textarea', 'description', 'Beschreibung'),

                Field::make('text', 'button_text', 'Button Text')
                    ->set_default_value('Alle Projekte')
                    ->set_required(),

                Field::make('text', 'button_link', 'Button Link')
                    ->set_default_value('/projekte/')
                    ->set_required(),

                Field::make('association', 'projects', 'Projekte auswählen')
                    ->set_types([
                        [
                            'type' => 'post',
                            'post_type' => 'project',
                        ],
                    ])
                    ->set_min(1)
                    ->set_max(3)
                    ->set_required(),

            ])


            // =================================
            // PROJEKTÜBERSICHT
            // =================================

            ->add_fields('project_overview', 'Projektübersicht', [

                Field::make('text', 'title', 'Seitentitel')
                    ->set_default_value('Selected Work')
                    ->set_required(),

                Field::make('text', 'stills_title', 'Titel Stills')
                    ->set_default_value('Stills')
                    ->set_required(),

                Field::make('text', 'motion_title', 'Titel Motion')
                    ->set_default_value('Motion')
                    ->set_required(),

            ])


            // =================================
            // BEISPIEL
            // =================================

            ->add_fields('example', 'Beispiel', [

                Field::make('text', 'title', 'Titel')
                    ->set_required(),

                Field::make('image', 'image', 'Bild')
                    ->set_required(),

            ])


            // =================================
            // RECHTLICHE SEITE
            // =================================

            ->add_fields('legal_page', 'Rechtliche Seite', [

                Field::make('select', 'legal_type', 'Seitentyp')
                    ->add_options([
                        'impressum' => 'Impressum',
                        'datenschutz' => 'Datenschutz',
                    ])
                    ->set_required(),

                Field::make('text', 'title', 'Seitentitel')
                    ->set_required(),

                Field::make('textarea', 'intro', 'Einleitung'),

                Field::make('complex', 'legal_sections', 'Textabschnitte')
                    ->add_fields([
                        Field::make('text', 'heading', 'Überschrift')
                            ->set_required(),
                        Field::make('rich_text', 'content', 'Text')
                            ->set_required(),
                    ])
                    ->set_layout('tabbed-vertical'),

            ])


            // =================================
            // EINSTELLUNGEN
            // =================================

            ->set_layout('tabbed-vertical')

    ])
    ->set_context('normal')
    ->set_priority('high');


// =========================================
// 2. MODULE LADEN UND DARSTELLEN
// =========================================

function render_modules(): void {

    $modules = carbon_get_the_post_meta('modules');

    if (empty($modules)) {
        return;
    }

    foreach ($modules as $module) {

        switch ($module['_type']) {


            // =================================
            // HERO
            // =================================

            case 'hero':

                $module['portrait'] = get_media_by_id(
                    $module['portrait'],
                    'full'
                );

                $module['secondary_image'] = get_media_by_id(
                    $module['secondary_image'],
                    'full'
                );

                break;


            // =================================
            // ÜBER MICH
            // =================================

            case 'about':

                $module['image'] = get_media_by_id(
                    $module['image'],
                    'full'
                );

                break;


            // =================================
            // AUSGEWÄHLTE PROJEKTE
            // =================================

            case 'selected_projects':

                $selected_projects = $module['projects'] ?? [];

                $module['projects'] = [];

                foreach ($selected_projects as $item) {

                    $id = (int) ($item['id'] ?? 0);

                    if (!$id) {
                        continue;
                    }

                    // Vollständige Projektdaten laden.
                    // Diese Daten werden auch für das Projekt-Popup benötigt.
                    $project_data = get_project_by_id($id);

                    $module['projects'][] = $project_data;

                }

                break;


            // =================================
            // PROJEKTÜBERSICHT
            // =================================

            case 'project_overview':

                $module['stills_projects'] = [];
                $module['motion_projects'] = [];

                $projects = get_posts([
                    'post_type' => 'project',
                    'post_status' => 'publish',
                    'posts_per_page' => -1,
                    'orderby' => [
                        'menu_order' => 'ASC',
                        'date' => 'DESC',
                    ],
                ]);

                foreach ($projects as $project) {

                    $project_id = $project->ID;

                    $project_data = get_project_by_id($project_id);

                    $terms = get_the_terms(
                        $project_id,
                        'project_category'
                    );

                    if (!is_array($terms)) {
                        continue;
                    }

                    $category_slugs = array_map(
                        fn($term) => $term->slug,
                        $terms
                    );

                    if (in_array('stills', $category_slugs, true)) {
                        $module['stills_projects'][] = $project_data;
                    }

                    if (in_array('motion', $category_slugs, true)) {
                        $module['motion_projects'][] = $project_data;
                    }

                }

                break;


            // =================================
            // RECHTLICHE SEITE
            // =================================

            case 'legal_page':

                $module['global_contact'] = [
                    'email' => carbon_get_theme_option('email'),
                    'street' => carbon_get_theme_option('address_street'),
                    'postcode' => carbon_get_theme_option('address_postcode'),
                    'city' => carbon_get_theme_option('address_city'),
                    'country' => carbon_get_theme_option('address_country'),
                ];

                break;


            // =================================
            // BEISPIEL
            // =================================

            case 'example':

                $module['image'] = get_media_by_id(
                    $module['image'],
                    'full'
                );

                break;

        }


        // =================================
        // PASSENDES TEMPLATE LADEN
        // =================================

        get_template_part(
            'frontend/views/modules/' . $module['_type'],
            null,
            [
                'data' => $module
            ]
        );

    }

}