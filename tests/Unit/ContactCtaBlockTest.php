<?php

use StudioAtlas\Blocks\ContactCta;

test('utilise les valeurs fournies par ACF', function () {
    $data = ContactCta::prepare([
        'title'     => 'Un projet en tête ?',
        'text'      => 'Parlons-en.',
        'cta_label' => 'Contactez-nous',
        'cta_url'   => 'https://example.com/contact',
    ]);

    expect($data)->toBe([
        'title'     => 'Un projet en tête ?',
        'text'      => 'Parlons-en.',
        'cta_label' => 'Contactez-nous',
        'cta_url'   => 'https://example.com/contact',
    ]);
});

test('retombe sur /contact quand aucune URL n\'est fournie', function () {
    $data = ContactCta::prepare(['title' => 'Contact']);

    expect($data['cta_url'])->toBe('https://studio-atlas.test/contact');
});
