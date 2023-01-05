<?php

namespace App\Repositories\Sistema\Pagamentos;

use App\Models\Aluno;
use App\Models\Usuario;
use Illuminate\Http\Request;
use PagarMe\Client as Pagarme;
use PagarMe\Exceptions\PagarMeException;
use App\Http\Requests\Sistema\Pagamentos\PagamentoRequest;

class PagarmeRepository
{
    public static function cc(Aluno $usuario, PagamentoRequest $request)
    {
        $pagarme = new Pagarme(config('app.pagarme.dev.key'));

        try {
            $assinatura = $pagarme->subscriptions()->create([
                'plan_id' => $usuario->plano->pagarme_plano_id,
                'payment_method' => 'credit_card',
                'card_number' => $request->cartao,
                'card_holder_name' => $request->titular,
                'card_expiration_date' => limpaNUmeros($request->validade),
                'card_cvv' => $request->cvv,
                'postback_url' => route('sistema.sua-conta.postback'),
                // 'postback_url' => 'https://webhook.site/d7cbde75-596d-40a5-86ed-7206a5335b79',
                'customer' => [
                    'email' => $usuario->email,
                    'name' => $usuario->nome,
                    'document_number' => $usuario->cpf,
                    'address' => [
                        'street' => $usuario->logradouro,
                        'street_number' => $usuario->numero,
                        'complementary' => $usuario->complemento,
                        'neighborhood' => $usuario->bairro,
                        'zipcode' => $usuario->cep,
                    ],
                    // 'phone' => [
                    //     'ddd' => '01',
                    //     'number' => '923456780',
                    // ],
                    // 'sex' => 'other',
                    // 'born_at' => '1970-01-01',
                ],
            ]);

            return $assinatura;
        } catch (PagarMeException $e) {
            return self::preparaErro($e->getMessage());
        }
    }

    public static function boleto(usuario $usuario, Request $request)
    {
        $pagarme = new Pagarme(config('app.pagarme.api_key'));
        // $paidBoleto = $pagarme->transactions()->simulateStatus([
        //     'id' => '9911274',
        //     'status' => 'paid',
        // ]);
        // pre($paidBoleto);

        try {
            $assinatura = $pagarme->subscriptions()->create([
                'plan_id' => $usuario->plano->plano_gateway,
                'payment_method' => 'boleto',
                'postback_url' => route('sistema.sua-conta.postback'),
                // 'postback_url' => 'https://webhook.site/d7cbde75-596d-40a5-86ed-7206a5335b79',
                'customer' => [
                    'email' => $usuario->email,
                    'name' => $usuario->nome,
                    'document_number' => $request->cpf,
                    'address' => [
                        'street' => $usuario->logradouro,
                        'street_number' => $usuario->numero,
                        'complementary' => $usuario->complemento,
                        'neighborhood' => $usuario->bairro,
                        'zipcode' => $usuario->cep,
                    ],
                    // 'phone' => [
                    //     'ddd' => '01',
                    //     'number' => '923456780',
                    // ],
                    // 'sex' => 'other',
                    // 'born_at' => '1970-01-01',
                ],
            ]);

            return $assinatura;
        } catch (PagarMeException $e) {
            return self::preparaErro($e->getMessage());
        }
    }

    public static function preparaErro(String $erro)
    {
        $erros = explode('MESSAGE:', $erro);

        return end($erros);
    }

    public static function cancelaAssinatura(String $assinatura)
    {
        $pagarme = new Pagarme(config('app.pagarme.api_key'));
        $canceledSubscription = $pagarme->subscriptions()->cancel([
            'id' => $assinatura,
        ]);
    }
}
