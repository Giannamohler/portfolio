
<?php
use Carbon_Fields\Container;
use Carbon_Fields\Field;

// -> Konfiguration der verschiedenen Module
Container::make('post_meta', 'Module')
    ->where('post_type', 'IN', ['page'])
    ->add_fields([
        Field::make('complex', 'modules', 'Module')

            // -> HERO
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

            // -> EXAMPLE
            ->add_fields('example', 'Beispiel', [
                Field::make('text', 'title', 'Titel')
                    ->set_required(),

                Field::make('image', 'image', 'Bild')
                    ->set_required(),
            ])

            // -> SETTINGS
            ->set_layout('tabbed-vertical')
    ]);

// -> Funktion, um die Module und die entsprechenden Templates auf der Seite zu laden
function render_modules(): void {

    $modules = carbon_get_the_post_meta('modules');

    if (empty($modules)) {
        return;
    }

    foreach ($modules as $module) {

        // -> Modifiziere die Daten des Moduls, falls nötig
        switch ($module['_type']) {

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

            case 'example':
                $module['image'] = get_media_by_id(
                    $module['image'],
                    'full'
                );
                break;

            // todo: add data modifications for modules here as a new case
        }

        // -> Laden des Templates basierend auf dem Modultyp
        get_template_part(
            'frontend/views/modules/' . $module['_type'],
            null,
            [
                'data' => $module
            ]
        );
    }
}
