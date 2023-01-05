<?php

namespace App\Repositories\Sistema\Pagamentos;

use Exception;
use Moip\Moip;
use Carbon\Carbon;
use Moip\Auth\OAuth;
use App\Models\Aluno;
use App\Models\Plano;
use GuzzleHttp\Client;
use Moip\Resource\Holder;
use Moip\Resource\Orders;
use Illuminate\Support\Str;
use Moip\Resource\Customer;
use App\Models\Pedidoaovivo;
use Illuminate\Support\Facades\Session;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Foundation\Http\FormRequest;
use App\Repositories\Sistema\BaseRepository;
use App\Http\Requests\Sistema\Pagamento\BoletoRequest;
use App\Http\Requests\Sistema\Pagamento\CartaoRequest;
use App\Http\Requests\Sistema\Professores\CadastroRequest;
use App\Models\Agendamentoaovivo;
use App\Repositories\Sistema\Professores\ProfessorRepository;

class MoipRepository
{
    private static $endpoints = [
        'novoAssinante' => 'customers?new_vault=true',
        'novaAssinatura' => 'subscriptions?new_customer=true',
        'pegaAssinatura' => 'subscriptions/code',
        'cancelaAssinatura' => 'subscriptions/code/suspend',
        'alteraAssinatura' => 'subscriptions/code/change_payment_method',
        'alteraPlanoAssinatura' => 'subscriptions/code',
        'alteraCC' => 'customers/code/billing_infos',
        'listaFaturas' => 'subscriptions/code/invoices',
    ];

    protected static function inicia()
    {
        return new Client([
            'auth' => [config('app.moip.prod.key'), config('app.moip.prod.secret')],
            'headers' => ['Content-Type' => 'application/json', 'Accept' => 'application/json'],
        ]);
    }

    public static function criaAssinatura(Aluno $aluno, FormRequest $request, Int $metodo)
    {
        $assinante = self::geraCustomer($aluno, $request, $metodo);
        $codeAssinatura = 'AssinaturaGuitarpedia_' . time();
        $assinatura = self::geraAssinatura($aluno, $metodo, $assinante, $codeAssinatura);
        $cliente = self::inicia();
        try {
            // pre(json_encode($assinatura));
            $request = $cliente->post(config('app.moip.prod.url') . self::$endpoints['novaAssinatura'], ['body' => json_encode($assinatura)]);
            $response = json_decode($request->getBody()->getContents());

            return $response;
        } catch (ClientException $e) {
            if ($e->hasResponse()) {
                return json_decode($e->getResponse()->getBody()->getContents());
            }
        }
    }

    protected static function geraCustomer(Aluno $aluno, FormRequest $request, Int $metodo)
    {
        $assinante = [
            'code' => 'AssinanteGuitarpedia_' . time(),
            'email' => $aluno->email,
            'fullname' => $aluno->fullName,
            'cpf' => limpaNumeros($request->cpf),
            'phone_area_code' => Str::substr(limpaNumeros($aluno->whatsapp), 0, 2),
            'phone_number' => Str::substr(limpaNumeros($aluno->whatsapp), 2, 9),
            'birthdate_day' => '01',
            'birthdate_month' => '01',
            'birthdate_year' => '1980',
            'address' =>
            [
                'street' => 'R. Silva Bueno',
                'number' => '599',
                'complement' => '',
                'district' => 'Ipiranga',
                'city' => 'São Paulo',
                'state' => 'SP',
                'country' => 'BRA',
                'zipcode' => '04207000',
            ],
        ];
        if ($metodo === 1) {
            $assinante['billing_info'] = [
                'credit_card' =>
                [
                    'holder_name' => $request->titular,
                    'number' => limpaNumeros($request->cartao),
                    'expiration_month' => Str::substr(limpaNumeros($request->validade), 0, 2),
                    'expiration_year' => Str::substr(limpaNumeros($request->validade), 2, 2),
                ],
            ];
        }

        return $assinante;
    }

    protected static function geraAssinatura(Aluno $aluno, Int $metodo, array $assinante, String $code)
    {
        if (!Session::has('cupomCode')) {
            return [
                'code' => $code,
                'amount' => $aluno->plano->valor * 100,
                'payment_method' => $metodo == 1 ? 'CREDIT_CARD' : 'BOLETO',
                'plan' => [
                    'code' => $aluno->plano->codigo_gateway,
                ],
                'customer' => $assinante,
            ];
        }

        return [
            'code' => $code,
            'amount' => $aluno->plano->valor * 100,
            'payment_method' => $metodo == 1 ? 'CREDIT_CARD' : 'BOLETO',
            'plan' => [
                'code' => $aluno->plano->codigo_gateway,
            ],
            'customer' => $assinante,
            'coupon' => [
                'code' => Session('cupomCode'),
            ],
        ];
    }

    public static function listaFaturas(Aluno $aluno)
    {
        $cliente = self::inicia();

        try {
            $request = $cliente->put(config('app.moip.prod.url') . Str::of(self::$endpoints['listaFaturas'])->replace('code', $aluno->assinatura_gateway_id), ['body' => '']);
            $response = json_decode($request->getBody()->getContents());
            pre($response);
            return $response;
        } catch (ClientException $e) {
            if ($e->hasResponse()) {
                return json_decode($e->getResponse()->getBody()->getContents());
            }
        }
    }

    public static function cancelarAssinatura(Aluno $aluno)
    {
        $cliente = self::inicia();

        try {
            $request = $cliente->put(config('app.moip.prod.url') . Str::of(self::$endpoints['cancelaAssinatura'])->replace('code', $aluno->assinatura_gateway_id), ['body' => '']);
            $response = json_decode($request->getBody()->getContents());

            return $response;
        } catch (ClientException $e) {
            if ($e->hasResponse()) {
                return json_decode($e->getResponse()->getBody()->getContents());
            }
        }
    }

    public static function alteraAssinatura(Aluno $aluno, FormRequest $request, Int $metodo)
    {
        $assinatura = $aluno->assinatura_gateway_id;
        $body['payment_method'] = $metodo == 1 ? 'CREDIT_CARD' : 'BOLETO';
        if ($metodo == 1) {
            self::criaCC($aluno, $request);
        }

        $cliente = self::inicia();

        try {
            $request = $cliente->put(config('app.moip.prod.url') . Str::of(self::$endpoints['alteraAssinatura'])->replace('code', $assinatura), ['body' => json_encode($body)]);
            $response = json_decode($request->getBody()->getContents());

            return $response;
        } catch (ClientException $e) {
            if ($e->hasResponse()) {
                $m = explode('"description":"', $e->getMessage());

                return end($m);
            }
        }
    }

    public static function alteraCupom(Aluno $aluno)
    {
        $assinatura = $aluno->assinatura_gateway_id;
        $body['coupon'] = ['code' => Session('cupomCode')];

        $cliente = self::inicia();

        try {
            $request = $cliente->put(config('app.moip.prod.url') . Str::of(self::$endpoints['pegaAssinatura'])->replace('code', $assinatura), ['body' => json_encode($body)]);
            $response = json_decode($request->getBody()->getContents());

            return $response;
        } catch (ClientException $e) {
            if ($e->hasResponse()) {
                $m = explode('"description":"', $e->getMessage());

                return end($m);
            }
        }
    }

    public static function alteraPlanoAssinatura(Aluno $aluno, Plano $plano)
    {
        $assinatura = $aluno->assinatura_gateway_id;
        $body['plan']['code'] = $plano->codigo_gateway;
        $valor = limpaNumeros(currencyToAppDot($plano->valor));
        $body['amount'] = $valor;
        $cliente = self::inicia();
        Session::forget('valorPlano');
        Session::save();
        // pre($body);

        try {
            $request = $cliente->put(config('app.moip.prod.url') . Str::of(self::$endpoints['alteraPlanoAssinatura'])->replace('code', $assinatura), ['body' => json_encode($body)]);
            $response = json_decode($request->getBody()->getContents());
            if (Session::has('cupomCode')) {
                self::alteraCupom($aluno);
            }

            return $response;
        } catch (ClientException $e) {
            if ($e->hasResponse()) {
                $m = explode('"description":"', $e->getMessage());

                return end($m);
            }
        }
    }

    public static function criaCC(Aluno $aluno, FormRequest $request)
    {
        $cliente = self::inicia();
        $assinatura = self::getAssinatura($aluno);
        $assinante = $assinatura->customer->code;
        $body['credit_card'] =
            [
                'holder_name' => $request->titular,
                'number' => limpaNumeros($request->cartao),
                'expiration_month' => Str::substr(limpaNumeros($request->validade), 0, 2),
                'expiration_year' => Str::substr(limpaNumeros($request->validade), 2, 2),
            ];

        try {
            $request = $cliente->put(config('app.moip.prod.url') . Str::of(self::$endpoints['alteraCC'])->replace('code', $assinante), ['body' => json_encode($body)]);
            $response = json_decode($request->getBody()->getContents());

            return $response;
        } catch (ClientException $e) {
            if ($e->hasResponse()) {
                return json_decode($e->getResponse()->getBody()->getContents());
            }
        }
    }

    public static function getAssinatura(Aluno $aluno)
    {
        $cliente = self::inicia();

        try {
            $request = $cliente->get(config('app.moip.prod.url') . Str::of(self::$endpoints['pegaAssinatura'])->replace('code', $aluno->assinatura_gateway_id), ['body' => '']);
            $response = json_decode($request->getBody()->getContents());

            return $response;
        } catch (ClientException $e) {
            if ($e->hasResponse()) {
                return json_decode($e->getResponse()->getBody()->getContents());
            }
        }
    }

    public static function checkConta(CadastroRequest $request)
    {
        $professor = BaseRepository::find('professoraovivo', $request->id);
        if ($professor->gateway_account == null) {
            try {
                $moip = new Moip(new OAuth(config('app.moip.prod.accessToken')), Moip::ENDPOINT_PRODUCTION);
                $account = $moip->accounts()
                    ->setName($professor->nome)
                    ->setLastName($professor->sobrenome)
                    ->setEmail($professor->email)
                    // ->setIdentityDocument(
                    //     $professor->identity,
                    //     $professor->identity_issuer,
                    //     $professor->issue_date)
                    ->setBirthDate($professor->nascimento)
                    ->setTaxDocument($professor->cpf)
                    ->setType('MERCHANT')
                    ->setPhone(
                        Str::substr($professor->telefone, 1, 2),
                        Str::substr($professor->telefone, 5, 10),
                        55
                    )
                    // ->addAlternativePhone(
                    //     Str::substr($professor->whatsapp, 1, 2),
                    //     Str::substr($professor->whatsapp, 5, 10),
                    //     55)
                    ->addAddress(
                        $professor->logradouro,
                        $professor->numero,
                        $professor->bairro,
                        $professor->cidade->title,
                        $professor->estado->letter,
                        $professor->cep,
                        $professor->complemento,
                        'BRA'
                    )
                    ->setTransparentAccount(true)
                    ->create();
                $professor->gateway_account = $account->getId();
                $professor->access_token = $account->getAccessToken();
                $professor->update();
            } catch (Exception $e) {
                pre($e);
            }
        }
    }

    public static function pedidoAoVivo(Pedidoaovivo $pedido, FormRequest $request, Int $forma)
    {
        $p = [];
        foreach ($pedido->items as $item) {
            if (isset($p[$item->aula->professor->id])) {
                $p[$item->aula->professor->id] += $item->valor_total;
            } else {
                $p[$item->aula->professor->id] = $item->valor_total;
            }
        }

        $moip = new Moip(new OAuth(config('app.moip.prod.accessToken')), Moip::ENDPOINT_PRODUCTION);
        $customer = self::checkCustomer($moip, $pedido, $request);
        $order = self::checkOrder($moip, $customer, $pedido, $p);
        if ($forma == 1) {
            $holder = self::checkHolder($moip, $request, $pedido);
            $payment = self::checkCC($order, $holder, $request);
            if (is_object($payment)) {
                PedidosRepository::moipCodes($pedido, $order, $payment);
            }

            return $payment;
        }
        if ($forma == 2) {
            $payment = self::checkBoleto($order, $request);
            PedidosRepository::moipCodes($pedido, $order, $payment);

            return $payment;
        }
    }

    private static function checkCustomer(Moip $moip, Pedidoaovivo $pedido, FormRequest $request)
    {
        if ($pedido->aluno->gateway_account == null) {
            $customer = $moip->customers()
                ->setOwnId($pedido->aluno->id . '_' . Str::random(6))
                ->setFullname($pedido->aluno->fullName)
                ->setEmail($pedido->aluno->email)
                ->setTaxDocument(limpaNumeros($request->cpf))
                ->setBirthDate(Carbon::now()->subYear(18))
                ->setPhone(Str::substr(limpaNumeros($pedido->aluno->whatsapp), 0, 2), Str::substr(limpaNumeros($pedido->aluno->whatsapp), 2, 9))
                ->addAddress(
                    'BILLING',
                    'R. Silva Bueno',
                    '599',
                    '',
                    'Ipiranga',
                    'São Paulo',
                    'SP',
                    'BRA',
                    '04207000'
                );
            $customer = $customer->create();
            // pre($customer);
            $pedido->aluno->gateway_account = $customer->getId();
            unset($pedido->aluno->fullName);
            $pedido->aluno->update();

            return $customer;
        }

        $customer_id = $pedido->aluno->gateway_account;

        return $moip->customers()->get($customer_id);
    }

    private static function checkOrder(Moip $moip, Customer $customer, Pedidoaovivo $pedido, array $p)
    {
        $order = $moip->orders()->setOwnId($pedido->id . Str::random(8));
        foreach ($pedido->items as $item) {
            $order->addItem(ProfessorRepository::nomeAula($item->aula), 1, '', (int) limpaNumeros(currencyToAppDot($item->valor_total)));
        }
        $configs = BaseRepository::find('configuracoes', 1);
        $fixo = (float) $configs->valor_fixo;
        $taxa = (float) $configs->comissao_abaixo;
        $limiteComissao = $configs->limite_comissao;
        $total_site = 0;
        $total_site = 0;
        foreach ($p as $k => $v) {
            $aulasMes = Agendamentoaovivo::where('professoraovivo_id', $k)->where('status', '>', 0)->whereBetween('data', [date('Y-m') . '-01', date('Y-m-t')])->count();
            if ($aulasMes >= $limiteComissao) {
                $taxa = (float) $configs->comissao_acima;
            }
            $comissao = currencyToAppDot(($v / 100) * $taxa);
            $valor_site = currencyToAppDot($comissao + $fixo);
            $total_site += $valor_site;
            $valor_professor = moipValue($v - $valor_site);
            $conta = BaseRepository::find('Professoraovivo', $k)->gateway_account;
            $order->addReceiver($conta, 'SECONDARY', $valor_professor, null, false);
        }
        $order->addReceiver($configs->conta_gateway, 'PRIMARY', $total_site * 100, null, true);
        $order->setCustomer($customer);
        try {
            $order->create();
        } catch (Exception $e) {
            pre($e);
        }


        return $order;
    }

    private static function checkBoleto(Orders $order, BoletoRequest $request)
    {
        $logo_uri = assets('sistema/images/logos/logo-guitarpedia-dark.png');
        $expiration_date = Carbon::now()->addDays(3);
        $instruction_lines = ['INSTRUÇÃO 1', 'INSTRUÇÃO 2', 'INSTRUÇÃO 3'];
        $payment = $order->payments()
            ->setBoleto($expiration_date, $logo_uri, $instruction_lines);
        try {
            $payment->execute();
        } catch (Exception $e) {
            pre($e);
        }

        return $payment;
    }

    private static function checkHolder(Moip $moip, CartaoRequest $request, Pedidoaovivo $pedido)
    {
        $holder = $moip->holders()->setFullname($request->titular)
            // ->setBirthDate('1990-10-10')
            ->setTaxDocument(limpaNumeros($request->cpf), 'CPF')
            ->setPhone(Str::substr(limpaNumeros($pedido->aluno->whatsapp), 0, 2), Str::substr(limpaNumeros($pedido->aluno->whatsapp), 2, 9), 55);
        // ->setAddress('BILLING', 'Avenida Faria Lima', '2927', 'Itaim', 'Sao Paulo', 'SP', '01234000', 'Apt 101');

        return $holder;
    }

    public static function checkCC(Orders $order, Holder $holder, CartaoRequest $request)
    {
        $payment = $order->payments()->setCreditCard(Str::substr(limpaNumeros($request->validade), 0, 2), Str::substr(limpaNumeros($request->validade), 2, 2), $request->cartao, $request->cvv, $holder);

        try {
            $payment->execute();

            return $payment;
        } catch (Exception $e) {
            return $e->getErrors();
        }
    }

    public static function cancelaPedidoAovivo(Pedidoaovivo $pedido)
    {
    }
}
