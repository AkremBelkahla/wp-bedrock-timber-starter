<?php

use StudioAtlas\Forms\Validator;

test('valide un formulaire complet et correct', function () {
    $errors = Validator::validateContactForm([
        'name'    => 'Ada Lovelace',
        'email'   => 'ada@example.com',
        'message' => 'Bonjour, je souhaite un devis.',
    ]);

    expect($errors)->toBe([]);
});

test('rejette les champs requis manquants', function () {
    $errors = Validator::validateContactForm([]);

    expect($errors)
        ->toHaveKey('name')
        ->toHaveKey('email')
        ->toHaveKey('message');
});

test('rejette un email au format invalide', function () {
    $errors = Validator::validateContactForm([
        'name'    => 'Ada',
        'email'   => 'pas-un-email',
        'message' => 'Test',
    ]);

    expect($errors)->toHaveKey('email');
});

test('détecte une soumission honeypot', function () {
    $triggered = Validator::isHoneypotTriggered(['website' => 'http://spam.example']);

    expect($triggered)->toBeTrue();
});

test('ne déclenche pas le honeypot quand le champ est vide', function () {
    $triggered = Validator::isHoneypotTriggered(['website' => '']);

    expect($triggered)->toBeFalse();
});
