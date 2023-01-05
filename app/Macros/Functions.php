<?php

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

function pre($expression, bool $json = true, bool $stop = true)
{
    echo '<pre>';
    if ($json) {
        print_r($expression);
    } else {
        var_dump($expression);
    }
    if ($stop) {
        die();
    }
}

function assets($file = null)
{
    return url('/') . "/resources/assets/{$file}";
}

function dateBdToApp($date)
{
    $old = new Datetime($date);
    if ($old) {
        return $old->format('d/m/Y');
    }
}

function dateToApp($date)
{
    if ($date) {
        $old = new Datetime($date);

        return $old->format('Y-m-d');
    }

    return null;
}

function dateToAppYear($date)
{
    if ($date) {
        $old = new Datetime($date);

        return $old->format('Y');
    }

    return null;
}

function monthInFull($date)
{
    if ($date) {
        $old = \Carbon\Carbon::createfromformat('m/Y', $date);

        return $old->translatedFormat('F \- Y');
    }

    return null;
}

function dateAppToBd($date)
{
    if ($date) {
        $old = \Carbon\Carbon::createfromformat('d/m/Y', $date);

        return $old->format('Y-m-d');
    }

    return null;
}

function dateBdToApp2($date)
{
    if ($date) {
        if ($old = \Carbon\Carbon::createfromformat('Y-m-d', $date)) {
            return $old->format('d/m/Y');
        }

        return $date;
    }

    return null;
}

function dateAppToBdYear($date)
{
    if ($date) {
        $old = \Carbon\Carbon::createfromformat('Y', $date);

        return $old->format('Y-m-d');
    }

    return null;
}

function dateInFull($date)
{
    if ($date) {
        $old = \Carbon\Carbon::createFromFormat('Y-m-d', $date);

        return $old->formatLocalized('%e de %B de %Y');
    }

    return null;
}

function endPlan($days)
{
    $today = \Carbon\Carbon::now();

    return $today->addDay($days)->format('d/m/Y');
}

function dateTimeBdToApp($date)
{
    $old = new Datetime($date);

    return $old->format('d/m/Y H:i:s');
}

function timeWithoutSeconds($time)
{
    return substr($time, 0, 5);
}

function currencyToBd($str)
{
    $s = preg_replace('/[^0-9,]/', '', $str);

    return preg_replace('/[,]/', '.', $s);
}

function currencyToAppDot($curr)
{
    if ($curr) {
        return number_format($curr, 2, '.', ',');
    }

    return null;
}

function currencyToAppNoDecimals($curr)
{
    if ($curr) {
        return number_format($curr, 0, '.', ',');
    }

    return null;
}

function currencyToApp($curr)
{
    return 'R$ ' . number_format($curr, 2, ',', '.');
}

function currencyToAppOnlyNumbersFront($curr)
{
    if ($curr) {
        return number_format($curr, 2, ',', '.');
    }

    return null;
}

function currencyToAppOnlyNumbers($curr)
{
    if ($curr) {
        return number_format($curr, 2, ',', '.');
    }

    return null;
}

function break_text($text, $limit)
{
    if (strlen($text) > $limit) {
        $pos = strpos($text, ' ', $limit);

        return substr($text, 0, $pos) . '...';
    }

    return $text;
}

function limpaNumeros($n)
{
    return preg_replace('/[^0-9]/', '', $n);
}

function limpaEspacos($n)
{
    return preg_replace('/[^A-Za-z]/', '', $n);
}

function preparaTelefone($n)
{
    $tel = preg_replace('/[^0-9]/', '', $n);
    $ddd = substr($tel, 0, 2);
    $numero = substr($tel, 2, 10);

    return [$ddd,$numero];
}

function cpfToApp($value)
{
    $cnpj_cpf = preg_replace("/\D/", '', $value);

    if (strlen($cnpj_cpf) === 11) {
        return preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", '$1.$2.$3-$4', $cnpj_cpf);
    }

    return preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/", '$1.$2.$3/$4-$5', $cnpj_cpf);
}

function getFirstName($name)
{
    $names = explode(' ', $name);

    return reset($names);
}

function multiKeyExists(array $arr, $key)
{
    if (array_key_exists($key, $arr)) {
        return true;
    }

    foreach ($arr as $element) {
        if (is_array($element)) {
            if (multiKeyExists($element, $key)) {
                return true;
            }
        }
    }

    return false;
}

function unique_multidim_array($array, $key)
{
    $temp_array = [];
    $i = 0;
    $key_array = [];

    foreach ($array as $val) {
        if (!in_array($val[$key], $key_array)) {
            $key_array[$i] = $val[$key];
            $temp_array[$i] = $val;
        }
        $i++;
    }

    return $temp_array;
}

function nlto($text, $tag)
{
    return '<' . $tag . '>' . str_replace(["\r\n", "\r", "\n"], '</' . $tag . '><' . $tag . '>', $text) . '</' . $tag . '>';
}

function nlToArray($text)
{
    $t = nl2br($text);
    $a = explode('<br />', $t);

    return $a;
}

function routeName()
{
    $previousRequest = app('request')->create(app('url')->previous());

    try {
        $routeName = app('router')->getRoutes()->match($previousRequest)->getName();
    } catch (NotFoundHttpException $exception) {
        return null;
    }

    return $routeName;
}

function yesNo(Int $value)
{
    return 0 == $value ? 'Não' : 'Sim';
}

function limitless(Int $value)
{
    return 0 == $value ? 'Ilimitado' : $value;
}

function moipValue(float $n)
{
    // pre($n);
    $ntf = explode(',', $n);
    if (!empty($ntf[1])) {
        if (strlen($ntf[0]) <= 2) {
            return $ntf[0] . $ntf[1] * 10 ;
        }
        if (strlen($ntf[0]) == 3) {
            return $ntf[0] . $ntf[1] * 10 ;
        }
    } else {
        return $n * 10 ;
    }
}

function valida_cartao($cartao, $cvc = false)
{
    $cartao = preg_replace('/[^0-9]/', '', $cartao);
    if ($cvc) {
        $cvc = preg_replace('/[^0-9]/', '', $cvc);
    }

    $cartoes = [
            'visa' => ['len' => [13,16],    'cvc' => 3],
            'mastercard' => ['len' => [16],       'cvc' => 3],
            'diners' => ['len' => [14,16],    'cvc' => 3],
            'elo' => ['len' => [16],       'cvc' => 3],
            'amex' => ['len' => [15],       'cvc' => 4],
            'discover' => ['len' => [16],       'cvc' => 4],
            'aura' => ['len' => [16],       'cvc' => 3],
            'jcb' => ['len' => [16],       'cvc' => 3],
            'hipercard' => ['len' => [13,16,19], 'cvc' => 3],
    ];

    switch ($cartao) {
        case (bool) preg_match('/^(636368|438935|504175|451416|636297)/', $cartao):
            $bandeira = 'elo';

        break;

        case (bool) preg_match('/^(606282)/', $cartao):
            $bandeira = 'hipercard';

        break;

        case (bool) preg_match('/^(5067|4576|4011)/', $cartao):
            $bandeira = 'elo';

        break;

        case (bool) preg_match('/^(3841)/', $cartao):
            $bandeira = 'hipercard';

        break;

        case (bool) preg_match('/^(6011)/', $cartao):
            $bandeira = 'discover';

        break;

        case (bool) preg_match('/^(622)/', $cartao):
            $bandeira = 'discover';

        break;

        case (bool) preg_match('/^(301|305)/', $cartao):
            $bandeira = 'diners';

        break;

        case (bool) preg_match('/^(34|37)/', $cartao):
            $bandeira = 'amex';

        break;

        case (bool) preg_match('/^(36,38)/', $cartao):
            $bandeira = 'diners';

        break;

        case (bool) preg_match('/^(64,65)/', $cartao):
            $bandeira = 'discover';

        break;

        case (bool) preg_match('/^(50)/', $cartao):
            $bandeira = 'aura';

        break;

        case (bool) preg_match('/^(35)/', $cartao):
            $bandeira = 'jcb';

        break;

        case (bool) preg_match('/^(60)/', $cartao):
            $bandeira = 'hipercard';

        break;

        case (bool) preg_match('/^(4)/', $cartao):
            $bandeira = 'visa';

        break;

        case (bool) preg_match('/^(5)/', $cartao):
            $bandeira = 'mastercard';

        break;
    }

    $dados_cartao = $cartoes[$bandeira];
    if (!is_array($dados_cartao)) {
        return [false, false, false];
    }

    $valid = true;
    $valid_cvc = false;

    if (!in_array(strlen($cartao), $dados_cartao['len'])) {
        $valid = false;
    }
    if ($cvc and strlen($cvc) <= $dados_cartao['cvc'] and strlen($cvc) != 0) {
        $valid_cvc = true;
    }

    return [$bandeira, $valid, $valid_cvc];
}
