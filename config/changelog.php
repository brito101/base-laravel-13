<?php

/*
| Changelog page (admin.changelog). Newest release first. A release lists
| its "changes" directly or, optionally, by area under "groups" (and may
| have a "title"). Texts are shown to the user, so they stay in pt-BR.
*/

return [

    'about' => [
        'description' => env('APP_DES'),
        'stack' => ['Laravel 13', 'PHP 8.4', 'MySQL', 'AdminLTE 4', 'Bootstrap 5', 'Vite'],
        'author' => 'Rodrigo Carvalho de Brito',
        'contact' => 'contato@rodrigobrito.dev.br',
    ],

    'releases' => [
        [
            'version' => '1.0.0',
            'date' => null,
            'changes' => [
                'Módulo de ACL com perfis e permissões',
                'Módulo de Usuários',
                'Duplo fator de autenticação (2FA)',
                'Autenticação via Azure SSO',
                'Changelog',
            ],
        ],
    ],

];
