
<?php

use Carbon_Fields\Container;
use Carbon_Fields\Field;


// =========================================
// 1. MODULE KONFIGURATION
// =========================================

Container::make('post_meta', 'Module')
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
            // BEISPIEL
            // =================================

            ->add_fields('example', 'Beispiel', [

                Field::make('text', 'title', 'Titel')
                    ->set_required(),

                Field::make('image', 'image', 'Bild')
                    ->set_required(),

            ])


            // =================================
            // EINSTELLUNGEN
            // =================================

            ->set_layout('tabbed-vertical')

    ]);


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

                    $terms = get_the_terms(
                        $id,
                        'project_category'
                    );

                    $image_id = carbon_get_post_meta(
                        $id,
                        'image'
                    );

                    $module['projects'][] = [

                        'title' => get_the_title($id),

                        'image' => get_media_by_id(
                            $image_id,
                            'full'
                        ),

                        'description' => carbon_get_post_meta(
                            $id,
                            'description'
                        ),

                        'categories' => is_array($terms)
                            ? array_map(
                                fn($term) => $term->name,
                                $terms
                            )
                            : [],

                        'url' => get_permalink($id),

                    ];

                }

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
