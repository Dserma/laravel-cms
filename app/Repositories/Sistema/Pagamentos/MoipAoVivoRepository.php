<?php

namespace App\Repositories\Sistema\Pagamentos;

use DateTime;
use Moip\Moip;
use DateInterval;
use Moip\Auth\OAuth;
use App\Models\Pedido;
use App\Models\Parcela;
use Moip\Auth\BasicAuth;
use Moip\Resource\Holder;
use Moip\Resource\Orders;
use App\Models\Professoraovivo;
use App\Http\Requests\Sistema\Pedidos\PedidoRequest;
use App\Repositories\Sistema\Professores\ProfessorRepository;

class MoipAoVivoRepository
{
    public static function Start()
    {
        return $moip = new Moip(new BasicAuth(config('app.moip-token-sand'), config('app.moip-key-sand')), Moip::ENDPOINT_SANDBOX);
        // return $moip = new Moip(new BasicAuth(config('app.moip-token'), config('app.moip-key')), Moip::ENDPOINT_PRODUCTION);
    }

    public static function makeOrder(Pedido $pedido, PedidoRequest $request)
    {
        $customer = self::makeCustomer($pedido, $request);
        $order = self::getOrder($pedido, $request, $customer);
        $holder = self::getHolder($request);
        $payment = self::getPayment($order, $request, $holder);
        PedidosRepository::setMoipCodes($pedido, $order, $payment);

        return $payment;
    }

    public static function makeCustomer(Pedido $pedido, PedidoRequest $request)
    {
        $telefone = preparaTelefone($pedido->aluno->telefone);
        $customer = self::Start()->customers()->setOwnId($pedido->aluno->id . now())
          ->setFullname($pedido->aluno->nome)
          ->setEmail($pedido->aluno->email)
          ->setBirthDate($pedido->aluno->data_nascimento)
          ->setTaxDocument($pedido->aluno->cpf)
          ->setPhone($telefone[0], $telefone[1])
          ->addAddress(
              'BILLING',
              $pedido->aluno->logradouro,
              $pedido->aluno->numero,
              $pedido->aluno->bairro,
              $pedido->aluno->cidade,
              $pedido->aluno->estado,
              $pedido->aluno->cep,
              $request->complemento,
              8
          )
          ->addAddress(
              'SHIPPING',
              $pedido->aluno->logradouro,
              $pedido->aluno->numero,
              $pedido->aluno->bairro,
              $pedido->aluno->cidade,
              $pedido->aluno->estado,
              $pedido->aluno->cep,
              $request->complemento,
              8
          )
          ->create();

        return $customer->getId();
    }

    public static function getOrder(Pedido $pedido, PedidoRequest $request, String $customer)
    {
        if ($request->forma == 0) {
            $parcela = Parcela::where('parcela', $request->parcelas)->first();
            if ($parcela->taxa > 0) {
                $taxa = ($pedido->valor / 100) * $parcela->taxa;
                $total = $pedido->valor + $taxa;
            } else {
                $total = $pedido->valor;
            }
        } else {
            $total = $pedido->valor;
        }

        if ((float) $total < 1) {
            $valor = str_replace(',', '', $total);
        } else {
            $valor = ($total * 100);
        }
        $order = self::Start()->orders()->setOwnId($pedido->id)
        ->addItem('Planejamento de estudos para o cargo ' . $pedido->cargo->nome, 1, 'Planejamento de estudos via Personal Time Organizer', (int) $valor)
        ->setCustomerId($customer)
        ->create();

        return $order;
    }

    public static function getHolder(PedidoRequest $request)
    {
        $telefone = preparaTelefone($request->telefone);
        $holder = self::Start()->holders()->setFullname($request->titular_cc)
          ->setBirthDate(dateAppToBd($request->nascimento))
          ->setTaxDocument(limpaNumeros($request->cpf_cc), 'CPF')
          ->setPhone($telefone[0], $telefone[1], 55)
          ->setAddress('BILLING', $request->logradouro, $request->numero, $request->bairro, $request->cidade, $request->estado, $request->cep, $request->complemento);

        return $holder;
    }

    public static function getPayment(Orders $order, PedidoRequest $request, Holder $holder)
    {
        if ($request->forma == 0) {
            return self::PaymentCC($order, $request, $holder);
        }

        return self::paymentBoleto($order);
    }

    public static function paymentCC(Orders $order, PedidoRequest $request, Holder $holder)
    {
        $payment = $order->payments()
          ->setCreditCardHash($request->hash, $holder)
          ->setInstallmentCount($request->parcelas)
          ->setStatementDescriptor('PTO')
          ->execute();

        return $payment;
    }

    public static function paymentBoleto(Orders $order)
    {
        $logo_uri = 'https://www.personaltimeorganizer.com.br/resources/images/logotipo.png';
        $expiration_date = new DateTime();
        $instruction_lines = ['INSTRUÇÃO 1', 'INSTRUÇÃO 2', 'INSTRUÇÃO 3'];
        $payment = $order->payments()
          ->setBoleto($expiration_date->add(new DateInterval('P15D')), $logo_uri, $instruction_lines)
          ->execute();

        return $payment;
    }

    public static function transferencia(Professoraovivo $professor)
    {
        ProfessorRepository::transferencia($professor);
        $moip = new Moip(new OAuth($professor->access_token), Moip::ENDPOINT_SANDBOX);

        try {
            $amount = limpaNumeros(ProfessorRepository::liberado($professor)) * 100;
            $bank_number = $professor->banco;
            $agency_number = $professor->agencia;
            $agency_check_number = $professor->agencia_digito;
            $account_number = $professor->conta;
            $account_check_number = $professor->digito;
            $holder_name = $professor->fullName;
            $tax_document = $professor->cpf;
            $transfer = $moip->transfers()
              ->setTransfers($amount, $bank_number, $agency_number, $agency_check_number, $account_number, $account_check_number)
              ->setHolder($holder_name, $tax_document)
              ->execute();
        } catch (Exception $e) {
            pre($e);
            printf($e->__toString());
        }
    }
}
