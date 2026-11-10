
<?php

use Carbon_Fields\Container;
use Carbon_Fields\Field;


// =========================================
// PROJEKT KONFIGURATION
// =========================================

Container::make('post_meta', 'Projekt')
    ->where('post_type', '=', 'project')
    ->add_fields([

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
        // BILDERGALERIE
        // =================================

        Field::make('complex', 'gallery', 'Bildergalerie')
            ->add_fields([
                Field::make('image', 'gallery_image', 'Bild')
                    ->set_required(),
            ])
            ->set_layout('grid')
            ->set_header_template('<%- $_index + 1 %>. Bild')
            ->set_help_text('Hier kannst du zusätzliche Bilder für das Projekt-Popup hochladen.'),

        // =================================
        // VIDEO
        // =================================

        Field::make('text', 'youtube_url', 'YouTube-Link')
            ->set_attribute('placeholder', 'https://www.youtube.com/watch?v=...')
            ->set_help_text('Optional. Für Film- und Videoprojekte kannst du hier einen YouTube-Link einfügen.'),

    ]);
