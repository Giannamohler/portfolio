<?php

   use Carbon_Fields\Container;
   use Carbon_Fields\Field;
   Container::make('post_meta', 'Projekt')
       ->where('post_type', '=', 'project')
       ->add_fields([
           Field::make('image', 'image', 'Bild')->set_required(),
           Field::make('textarea', 'description', 'Beschreibung')->set_required()->set_help_text('Wird für den Teaser benötigt'),
           Field::make('textarea', 'lead', 'Lead')->set_required(),
           Field::make('rich_text', 'text', 'Text')->set_required(),
       ]);