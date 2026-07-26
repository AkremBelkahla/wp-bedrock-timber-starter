<?php

use StudioAtlas\Blocks\Testimonials;

test('transforme un répéteur ACF de témoignages en tableau simple', function () {
    $layout = [
        'title' => 'Ils nous font confiance',
        'items' => [
            ['quote' => 'Excellent travail', 'author' => 'Marie D.', 'role' => 'Propriétaire'],
            ['quote' => 'Très professionnel', 'author' => 'Jean P.', 'role' => ''],
        ],
    ];

    $data = Testimonials::prepare($layout);

    expect($data['title'])->toBe('Ils nous font confiance')
        ->and($data['testimonials'])->toHaveCount(2)
        ->and($data['testimonials'][0])->toBe([
            'quote'  => 'Excellent travail',
            'author' => 'Marie D.',
            'role'   => 'Propriétaire',
        ]);
});

test('gère une liste de témoignages vide', function () {
    $data = Testimonials::prepare(['title' => 'Vide']);

    expect($data['testimonials'])->toBe([]);
});
