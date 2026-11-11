<?php

use Carbon_Fields\Container;
use Carbon_Fields\Field;

// Globale Einstellungen des Themes
Container::make('theme_options', 'Globales')
    ->add_fields([
        Field::make('image', 'logo', 'Logo')
            ->set_required(),

        Field::make('text', 'email', 'E-Mail-Adresse')
            ->set_required(),

        Field::make('text', 'address_street', 'Strasse und Hausnummer'),
        Field::make('text', 'address_postcode', 'PLZ'),
        Field::make('text', 'address_city', 'Ort'),
        Field::make('text', 'address_country', 'Land')
            ->set_default_value('Schweiz'),

        Field::make('complex', 'socials', 'Socials')
            ->add_fields([
                Field::make('text', 'title', 'Titel')->set_required(),
                Field::make('text', 'link', 'Link')->set_required(),
                Field::make('image', 'icon', 'Icon')->set_required(),
            ])
            ->set_layout('tabbed-vertical'),
    ]);
