/**
 * Studio Atlas — script front minimal (vanilla JS, aucune dépendance).
 * Amélioration progressive du formulaire de contact : le formulaire fonctionne
 * nativement sans JS (POST classique vers /contact) ; ce script intercepte la
 * soumission pour l'envoyer en fetch et afficher le résultat sans rechargement.
 */
(function () {
    'use strict';

    var form = document.querySelector('[data-contact-form]');

    if (!form) {
        return;
    }

    form.addEventListener('submit', function (event) {
        event.preventDefault();

        var feedback = form.querySelector('[data-contact-form-feedback]');
        var formData = new FormData(form);

        fetch(form.getAttribute('action'), {
            method: 'POST',
            body: formData,
            headers: { Accept: 'application/json' },
        })
            .then(function (response) {
                return response.json().then(function (data) {
                    return { ok: response.ok, data: data };
                });
            })
            .then(function (result) {
                if (!feedback) {
                    return;
                }

                feedback.textContent = result.data.message || '';
                feedback.classList.toggle('is-success', result.ok);
                feedback.classList.toggle('is-error', !result.ok);

                if (result.ok) {
                    form.reset();
                }
            })
            .catch(function () {
                if (feedback) {
                    feedback.textContent = 'Une erreur est survenue. Merci de réessayer.';
                    feedback.classList.add('is-error');
                }
            });
    });
})();
