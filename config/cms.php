<?php

  return [
    'menu' => [
      'banner' => [
        'title' => 'Banners da Home',
        'type' => 'model',
        'icon' => 'fa-image',
      ],
      'home' => [
        'title' => 'Textos da Home',
        'type' => 'model',
        'icon' => 'fa-edit',
      ],
      'depoimento' => [
        'title' => 'Depoimentos',
        'type' => 'model',
        'icon' => 'fa-bullhorn',
      ],
      // 'home' => [
      //   'title' => 'Home',
      //   'type' => 'model',
      //   'icon' => 'fa-home',
      // ],
      'ajuda' => [
        'type' => 'group',
        'top' => true,
        'title' => 'Ajudas',
        'icon' => 'fa-question',
        'subs' => [
          'categoriaajuda' => [
            'title' => 'Categorias',
            'icon' => 'fa-list',
          ],
          'ajuda' => [
            'title' => 'Tópicos de Ajuda',
            'icon' => 'fa-question-circle',
          ],
        ],
      ],
      'sobre' => [
        'type' => 'group',
        'top' => true,
        'title' => 'Sobre',
        'icon' => 'fa-qrcode',
        'subs' => [
          'sobrenos' => [
            'title' => 'Sobre Nós',
            'icon' => 'fa-list',
          ],
          'termo' => [
            'title' => 'Termos de Uso',
            'icon' => 'fa-question-circle',
          ],
          'politica' => [
            'title' => 'Política de Privacidade',
            'icon' => 'fa-question-circle',
          ],
        ],
      ],
      // 'blog' => [
      //   'type' => 'group',
      //   'top' => true,
      //   'title' => 'Blog',
      //   'icon' => 'fa-edit',
      //   'subs' => [
      //     'categoriapost' => [
      //       'title' => 'Categorias',
      //       'icon' => 'fa-list',
      //     ],
      //     'post' => [
      //       'title' => 'Posts',
      //       'icon' => 'fa-file-text',
      //     ],
      //   ],
      // ],
      'comofuncionaaluno' => [
        'title' => 'Alunos - Como Funciona',
        'type' => 'model',
        'icon' => 'fa-question',
      ],
      'vod' => [
        'type' => 'group',
        'top' => true,
        'title' => 'EAD',
        'icon' => 'fa-youtube-play',
        'subs' => [
          'plano' => [
            'title' => 'Planos de Assinaturas',
            'icon' => 'fa-usd',
          ],
          'cupom' => [
            'title' => 'Cupons de Desconto',
            'icon' => 'fa-usd',
          ],
          'obrigadocadastro' => [
            'title' => 'Agradecimento de Cadastro',
            'icon' => 'fa-edit',
          ],
          'confirmacaopagamento' => [
            'title' => 'Confirmação de Pagamento',
            'icon' => 'fa-edit',
          ],
          'categoriavod' => [
            'title' => 'Categorias',
            'icon' => 'fa-list',
          ],
          'nivelvod' => [
            'title' => 'Níveis',
            'icon' => 'fa-list',
          ],
          'generovod' => [
            'title' => 'Gêneros',
            'icon' => 'fa-list',
          ],
          'professorvod' => [
            'title' => 'Professores',
            'icon' => 'fa-list',
          ],
          'aulavod' => [
            'title' => 'Aulas',
            'icon' => 'fa-pencil-square-o',
          ],
          'cursovod' => [
            'title' => 'Cursos',
            'icon' => 'fa-cart-plus',
          ],
          'certificadovod' => [
            'title' => 'Certificados',
            'icon' => 'fa-certificate',
          ],
          'perguntavod' => [
            'title' => 'Perguntas',
            'icon' => 'fa-question',
          ],
          'banneread' => [
            'title' => 'Banner Para Alunos',
            'icon' => 'fa-image',
          ],
        ],
      ],
      'aovivo' => [
        'type' => 'group',
        'top' => true,
        'title' => 'Ao Vivo',
        'icon' => 'fa-television',
        'subs' => [
          'comofuncionaprofessor' => [
            'title' => 'Professores - Como Funciona',
            'type' => 'model',
            'icon' => 'fa-question',
          ],
          'termoprofessor' => [
            'title' => 'Termos de Uso do Professor',
            'icon' => 'fa-question-circle',
          ],
          'informacaofinanceira' => [
            'title' => 'Instruções do Professor',
            'icon' => 'fa-question-circle',
          ],
          'categoriaaovivo' => [
            'title' => 'Categorias',
            'icon' => 'fa-list',
          ],
          'professoraovivo' => [
            'title' => 'Professores',
            'icon' => 'fa-user-circle-o',
          ],
          'aulaaovivo' => [
            'title' => 'Aulas',
            'icon' => 'fa-play',
          ],
          'pacoteaulaaovivo' => [
            'title' => 'Pacotes de Aulas',
            'icon' => 'fa-play',
          ],
          'avaliacaoaovivo' => [
            'title' => 'Avaliações',
            'icon' => 'fa-question',
          ],
          'banneraovivo' => [
            'title' => 'Banner Para Alunos',
            'icon' => 'fa-image',
          ],
          'semlicenca' => [
            'title' => 'Relatório Licenças Zoom',
            'icon' => 'fa-file-text',
          ],
        ],
      ],
      'aluno' => [
        'title' => 'Alunos',
        'type' => 'model',
        'icon' => 'fa-graduation-cap',
      ],
      'configuracoes' => [
        'title' => 'Configurações',
        'type' => 'model',
        'icon' => 'fa-cog',
      ],
      'user' => [
        'title' => 'Usuários Admin',
        'type' => 'model',
        'icon' => 'fa-users',
      ],
    ],
  ];
