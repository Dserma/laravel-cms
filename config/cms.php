<?php

  return [
    'menu' => [
      'posts' => [
        'type' => 'group',
        'top' => true,
        'title' => 'Posts',
        'icon' => 'fa-question',
        'subs' => [
          'categoria' => [
            'title' => 'Categorias',
            'icon' => 'fa-list',
          ],
          'post' => [
            'title' => 'Posts',
            'icon' => 'fa-question-circle',
          ],
        ],
      ],
      'user' => [
        'title' => 'Usuários Admin',
        'type' => 'model',
        'icon' => 'fa-users',
      ],
    ],
  ];
