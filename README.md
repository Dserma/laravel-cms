# LaravelCMS

LaravelCMS é um conjunto de ferramentas, dentro do Framework, que ajuda o desenvolvedor a criar um CMS ( painel administrativo ) de forma simples e muito rápida, gerando todo o HTML do crud, de cada model, automaticamente, através de alguns parâmetros escritos na própria model.
Abaixo, algumas vantagens:

- CRUDs simples, e até mesmo complexos, em questão de minutos;
- Possui o [AdminLTE2](https://adminlte.io/themes/AdminLTE/index2.html) como layout;
- Utiliza [DataTables](https://datatables.net/) na listagem dos registros;
- Os editores de conteúdos e upload de imagens únicas são com o [Froala Editor 2](https://froala.com/wysiwyg-editor/);
- Uploads de múltiplos arquivos feito com o [Krajee File Input](https://plugins.krajee.com/file-input);
- Alertas com o [SweetAlert2](https://sweetalert2.github.io/);
- Dispensa a criação de várias rotas para cada Model;
- Completamente customizável, por ser Open Source.

LaravelCMS foi criado para ajudar a comunidade a criar painéis administrativos com aparência profissional, de forma rápida e fácil, e pode ser customizado para se adaptar a qualquer situação.


# Índice
 - [Começando](#começando)
 - [Criando Menus](#criando-menus)
 - [Preparando Nossa Estrutura](#preparando-nossa-estrutura)

# Começando

Para iniciar um projeto com o LaravelCMS, basta clonar o repositório do mesmo, instalar as dependências do composer, e configurar o seu ambiente.

Uma vez que o ambiente esteja ok, edite o arquivo "database/seeds/UsersTableSeeder.php", alterando as credenciais do admin, e execute o comando `php artisan migrate --seed`, criando assim a tabela de usuários, e registrando o usuário admin master.

Após isso, basta acessar http://localhost/backend, com as credenciais adicionadas no seed, e pronto, já terá acesso ao seu primeiro painel administrativo LaravelCMS.

# Criando Menus

Como o LaravelCMS é feito para atender a uma grande gama de projetos, nós podemos customizar os menus laterais, que nossos usuários terão acesso. Podemos customizar:
- Criar múltiplas seções de menu, nomeando cada uma delas;
- Nomes dos menus;
- A ordenação deles;
- O ícone de cada item do menu;
- Se ele será do tipo **único** ou **árvore**;
- Seus subitens, caso seja do tipo **árvore**, também customizando cada aspecto dos subitens.

Para que isso seja possível, um arquivo chamado `config/cms.php`, que contém um `array` com todas as opções do nosso menu.

Veja o exemplo abaixo:

```php
return [
  'menu' => [
    'header1' => [ // Seção de menu, com o nome HOME
      'title' => 'HOME',
      'type' => 'header',
    ],
    'banner' => [ // Menu de ação simples, levando o usuário diretamente ao módulo Banners
      'title' => 'Banners',
      'type' => 'model',
      'icon' => 'fa-picture-o', // Ícone do menu, em fontawesome 4
    ],
    'eventos' => [
      'type' => 'group', // Indicação de um menu em árvore, que conterá subitens
      'top' => true,
      'title' => 'Eventos',
      'icon' => 'fa-calendar',
      'subs' => [ // Indicação dos subitens
        'categoriaevento' => [
          'title' => 'Categorias de Eventos',
          'icon' => 'fa-list-ul',
        ],
        'evento' => [
          'title' => 'Eventos',
          'type' => 'model',
          'icon' => 'fa-calendar',
        ],
      ],
    ],
  ],
];
```

Isso resultará neste menu:

![menu](http://refreshweb.com.br/images/menu.png)

Explicando cada item do array de menus:

```php
'banner' => [ // Nome exato da Model em questão
    'title' => 'Banners', // Título que aparecerá para o usuário
    'type' => 'model', // Pode ser do tipo 'model', 'group' ou 'header'
    'icon' => 'fa-picture-o', // Ícone do menu, em fontawesome 4
],
```

# Preparando nossa estrutura

Uma vez que nosso menu foi configurado, podemos começar a criar nossos CRUDs.
Para isso, devemos criar nossas models e migrations, ou podemos aproveitar as já criadas também.

Para esta documentação, vamos criar nossas models do zero.

Vamos criar um CRUD de um blog, com categorias, posts e galeria de imagem dos posts.

Iniciamos com a criação das models e suas respectivas migrations:

```
php artisan make:model Models/Categoria -m
php artisan make:model Models/Post -m
php artisan make:model Models/Tag -m
php artisan make:model Models/Galeria -m
```

Isso irá nos gerar as models `Categoria`, `Post`, `Tag` e `Galeria` dentro da pasta `app/Models`, junto com suas migrations.

Crie os campos que desejar em cada migration. 

Neste exemplo, nosso post pertencerá a apenas uma `Categoria`, mas poderá ter mais de uma `Tag`, então a migration do `Post` deverá referenciar o id da categoria, tendo a seguinte entrada: 

`$table->foreignId('categoria_id')->constrained();`.

Isso irá criar a Foreign Key da categoria em nossa tabela de posts.

Precisaremos também de uma migration a parte, para o relacionamento do tipo `ManyToMany`, entre os posts e as tags, uma vez que o post pode ter várias tags, e uma tag pode pertencer a vários posts.

```
php artisan make:migration create_post_tag_table --create=post_tag
```

Essa migration terá apenas as referências das duas tabelas em questão:

```php
$table->foreignId('post_id')->constrained()->onDelete('cascade');
$table->foreignId('tag_id')->constrained()->onDelete('cascade');
```
A migration da `Galeria` deve referenciar o id da model que será pai dela, neste caso, a `Post`.  Além disso, deverá conter o campo `arquivo`, que armazenará o caminho da nossa imagem:

`$table->foreignId('post_id')->constrained()->onDelete('cascade');`

`$table->string('arquivo');`

Rode suas migrations, e teremos nossa estrutura pronta para iniciarmos.


# Configurando as Models

Uma vez que o banco de dados está ok, precisamos configurar nossas models, para que trabalhem com o LaravelCMS.

Isso é feito através de algumas variáveis `públicas`, na própria model. São elas:
- $hasOrder(`bool`) => Indica se a listagem de itens desta model terá ordenação por Drag`n Drop
- $hasForm(`bool`) => Indica se a model terá formulários de Visualização/Edição
- $update(`bool`) => Habilita/Desabilita o botão de `Salvar`, no formulário de edição
- $serverSide(`bool`) => Define se os registros serão paginados pelo servidor, ou pelo front
- $searchAdmin(`array`) => Array com os atributos que serão buscados no banco, caso `$serverSide` esteja habilitado
- $withAdmin(`array`) => Array com as relações que serão carregadas junto com a model, apenas no painel administrativo
- $title(`string`) => Título do módulo, para o usuário
- $newButton(`String`) => Texto do botão de adição de um novo registro
- $listagem(`array`) => Atributos que serão mostrados na listagem dos registros do módulo,
- $formulario(`array`) => Todos os atributos que existirão nos formulários de Inclusão e Edição


Além destes supra citados, que são exclusivos do LaravelCMS, devemos ter os que são do próprio Laravel. Os que iremos utilizar são:

- $guarded(`array`) => Indica quais atributos não serão utilizados no mass storage
- $appends(`array`) => Define os 'novos' atributos que usaremos nas listagens, como uma data formatada, por exemplo

E claro, precisaremos criar os relacionamentos, caso existam.

Vamos agora configurar a model `Categoria`, a primeira e mais fácil.

```php
class Categoria extends Model
{
    protected $guarded = [];
    public $hasOrder = true;
    public $hasForm = true;
    public $update = true;
    public $serverSide = false;
    public $withAdmin = [];
    public $title = 'Categorias de Posts';
    public $newButton = 'Nova Categoria';

    public $listagem = [
        'nome',
    ];

    public $formulario = [
        'nome' => [
            'title' => 'Nome da Categoria:*',
            'type' => 'text',
            'width' => 12,
            'validators' => 'required|string|min:2|unique:categorias,nome,$this->id',
        ],
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
```
Essa configuração resultará nesta tela:

![modulo de categorias](http://refreshweb.com.br/images/firstmodule.png)

Essa tela, como os botões padrões de `Ver/Editar` e `Excluir`, bem como os botões de exportação da listagem, acima da mesma, são gerados **automaticamente** pelo LaravelCMS, apenas com estas linhas da model de `Categoria`.

E o formulário de inclusão/edição, ficará assim:

![formulario](http://refreshweb.com.br/images/formmodulo.png)

Após a inclusão/edição de algum registro, uma notificação do tipo `toaster` é exibida no canto superior direito, indicando o sucesso da ação, e a tabela de listagem é atualizada automaticamente, via ajax.

Na inclusão, o formulário é zerado e a modal continua aberta, para a inclusão contínua. Na edição, a modal é fechada após a gravação dos dados.

Quando o botão de `exclusão` é acionado, uma confirmação de ação é exibida ao usuário:

![confirmação](http://refreshweb.com.br/images/exclusao.png)

Caso o usuário clique no botão `Sim`, então o registro será apagado e a tabela atualizada via ajax.

# Entendendo Nossa Tela
Agora, vamos entender o que fizemos com os parâmetros `listagem` e `formulário`, quem compõem nossa tela.

## Listagem

No parâmetro `listagem`, podemos adicionar todos os atributos que desejarmos serem listados para o usuário.

Os campos `id` e `ações` são padrões do LaravelCMS, e sempre são exibidos.

O campo `#` apenas é exibido quando o parâmetro `hasOrder` for `true`, pois ele é o gatilho da ordenação Drag'n Drop.

Em cada item do `listagem` podemos passar apenas o nome do atributo, exatamente como está na tabela, e o LaravelCMS já exibe este mesmo nome no cabeçalho, capitalizado, ou podemos passar o texto que queremos no cabeçalho da tabela, e então o atributo que vamos exibir. Por exemplo:

 ```php
 public $listagem = [
    'Data' => 'dataFormatada', // Atributo criado via appends
    'Categoria' => 'categoria.nome' // Atributo nome da relação categoria
    'Nome do Post' => 'nome' // Atributo nome, porém com um título diferente na exibição
 ]
```

## Formulário

O parâmetro `formulario` diz ao LaravelCMS como ele deve montar cada campo do formulário de inclusão/edição.

Vamos analisar este exemplo:

```php
public $formulario = [
    'nome' => [ // Atributo da tabela. Será o name do input
        'title' => 'Nome da Categoria:*', // Título exibido ao usuário
        'type' => 'text', // Tipo do campo. Vamos ver todos mais abaixo.
        'width' => 12, // Tamanho do campo, em largura de colunas. 1 - 12
        'validators' => 'required|string|min:2|unique:categorias,nome,$this->id', // As validações que este campo terá
    ],
];
```    
