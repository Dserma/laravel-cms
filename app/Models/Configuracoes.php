<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Configuracoes extends Model
{
    protected $table = 'configuracoes';
    protected $guarded = [];

    public $hasOrder = false;
    public $hasForm = true;
    public $update = true;
    public $title = 'Configurações do site';
    public $type = 'page';
    public $formulario = [
        'separador-dados' => [
            'title' => 'Configurações do Site',
            'type' => 'fieldset',
            'comment' => 'Aqui você configura os dados de contato do site, que ficam no rodapé',
        ],
        'ligue' => [
            'title' => 'Telefone',
            'type' => 'text',
            'class' => 'telefone-input-mask',
            'width' => 4,
        ],
        'email' => [
            'title' => 'E-mail',
            'type' => 'email',
            'width' => 4,
        ],
        'whatsapp' => [
            'title' => 'Whatsapp',
            'type' => 'text',
            'class' => 'telefone-input-mask',
            'width' => 4,
        ],
        'endereco' => [
            'title' => 'Localização',
            'type' => 'textarea',
            'editor' => true,
            'width' => 12,
        ],
        'chegar' => [
            'title' => 'Link Como Chegar',
            'type' => 'url',
            'width' => 12,
        ],
        'separador-seo' => [
            'title' => 'SEO da Home',
            'type' => 'fieldset',
            'comment' => 'Aqui você configura os dados de SEO da Home',
        ],
        'titulo_home' => [
            'title' => 'Título da Home',
            'type' => 'text',
            'width' => 12,
            'validators' => 'nullable|min:5',
        ],
        'description_home' => [
            'title' => 'Description da Home',
            'type' => 'textarea',
            'editor' => false,
            'width' => 12,
            'limit' => 300,
            'validators' => 'nullable|min:2',
        ],
        'keywords_home' => [
            'title' => 'Palavras chave da Home',
            'type' => 'textarea',
            'editor' => false,
            'width' => 12,
            'limit' => 300,
            'validators' => 'nullable|min:2',
        ],
        'separador-seo-aovivo' => [
            'title' => 'SEO dos Professores Ao Vivo',
            'type' => 'fieldset',
            'comment' => 'Aqui você configura os dados de SEO da listagem dos Professores Ao Vivo',
        ],
        'titulo_aovivo' => [
            'title' => 'Título da Listagem',
            'type' => 'text',
            'width' => 12,
            'validators' => 'nullable|min:5',
        ],
        'description_aovivo' => [
            'title' => 'Description da Listagem',
            'type' => 'textarea',
            'editor' => false,
            'width' => 12,
            'limit' => 300,
            'validators' => 'nullable|min:2',
        ],
        'keywords_aovivo' => [
            'title' => 'Palavras chave da Listagem',
            'type' => 'textarea',
            'editor' => false,
            'width' => 12,
            'limit' => 300,
            'validators' => 'nullable|min:2',
        ],
        'separador-video' => [
            'title' => 'Vídeo da LP',
            'type' => 'fieldset',
            'comment' => 'Configure aqui oo vídeo da LP',
        ],
        'video_lp' => [
            'title' => 'Embed do vídeo',
            'type' => 'textarea',
            'editor' => false,
            'limit' => 0,
            'width' => 12,
        ],
        'separador-emails' => [
            'title' => 'Configurações de E-mails',
            'type' => 'fieldset',
            'comment' => 'Configure aqui os textos dos e-mails enviados pelo sistema. Você pode usar tags para formatar o texto, como por exemplo, <b>[nome], [senha], e etc...</b><br>Tags disponíveis: <b>[nome], [email], [senha]</b>',
        ],
        'email_cadastro' => [
            'title' => 'E-mail de Cadastro',
            'type' => 'textarea',
            'editor' => true,
            'width' => 12,
        ],
        'email_assinatura' => [
            'title' => 'E-mail para compra de assinatura EAD',
            'type' => 'textarea',
            'editor' => true,
            'width' => 12,
        ],
        'email_alteracao_plano' => [
            'title' => 'E-mail para Alteração de assinatura EAD',
            'type' => 'textarea',
            'editor' => true,
            'width' => 12,
        ],
        'email_suspende_plano' => [
            'title' => 'E-mail para Suspensão de assinatura EAD',
            'type' => 'textarea',
            'editor' => true,
            'width' => 12,
        ],
        'email_pagamento_ok' => [
            'title' => 'E-mail de Confirmação de Pagamento',
            'type' => 'textarea',
            'editor' => true,
            'width' => 12,
        ],
        'email_resposta_pergunta' => [
            'title' => 'E-mail de pergunta respondida',
            'type' => 'textarea',
            'editor' => true,
            'width' => 12,
        ],
        'email_pagamento_erro' => [
            'title' => 'E-mail de Erro de Pagamento',
            'type' => 'textarea',
            'editor' => true,
            'width' => 12,
        ],
        'email_alteracao_senha' => [
            'title' => 'E-mail de Alteração de Senha',
            'type' => 'textarea',
            'editor' => true,
            'width' => 12,
        ],
        'separador' => [
            'title' => 'Configurações do Wirecard',
            'type' => 'fieldset',
        ],
        'conta_gateway' => [
            'title' => 'Código da Conta do site no gateway',
            'type' => 'text',
            'width' => 3,
            'validators' => 'required|min:2',
        ],
        'valor_fixo' => [
            'title' => 'Valor da Taxa Fixa',
            'type' => 'text',
            'class' => 'dinheiro-input-mask',
            'width' => 3,
            'validators' => 'required|numeric|min:2',
        ],
        'comissao_abaixo' => [
            'title' => 'Valor da comissão (%)',
            'type' => 'text',
            'class' => 'dinheiro-input-mask',
            'width' => 3,
            'validators' => 'required|min:2',
        ],
        'limite_comissao' => [
            'title' => 'Número de Aulas/Mês para diminuir comissão',
            'type' => 'number',
            'min' => 1,
            'max' => 999,
            'step' => 1,
            'width' => 3,
            'validators' => 'nullable|min:1',
        ],
        'comissao_acima' => [
            'title' => 'Valor da Comissão após o limite de horas/aula (%)',
            'type' => 'text',
            'class' => 'dinheiro-input-mask',
            'width' => 3,
            'validators' => 'nullable|min:2',
        ],
        'separador-zoom' => [
            'title' => 'Configurações do Zoom',
            'type' => 'fieldset',
        ],
        'licencas_zoom' => [
            'title' => 'Número de licencas do Zoom',
            'type' => 'number',
            'width' => 3,
            'min' => 1,
            'max' => 99999,
            'step' => 1,
            'validators' => 'required|min:1',
        ],
  ];
}
