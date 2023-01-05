<?php

namespace App\Services\Sistema\Alunos;

use App\Models\Aluno;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use MailchimpMarketing\ApiClient;
use GuzzleHttp\Exception\ClientException;
use App\Repositories\Sistema\BaseRepository;
use Illuminate\Database\Eloquent\Collection;
use App\Repositories\Sistema\Alunos\AlunosRepository;

class AlunoService
{
    public static function downloadmateriais(Collection $materiais)
    {
        $resp = '';
        foreach ($materiais as $m) {
            $resp .= view('sistema.alunos.includes.material', ['m' => $m])->render();
        }

        return $resp;
    }

    public static function produtosCart(Collection $cart)
    {
        $resp = '';
        if (count($cart) > 0) {
            foreach ($cart as $c) {
                $resp .= view('sistema.aovivo.includes.produto-cart', ['c' => $c])->render();
            }
        } else {
            $resp = '<div class="alert alert-danger semibold">Nenhuma aula adicionada ao seu carrinho ainda!</div>';
        }

        return $resp;
    }

    public static function preferidos(Aluno $aluno, Request $request)
    {
        $resp = '';
        if ($request->tipo == 0) {
            foreach (AlunosRepository::getMeusCursosPreferidos($aluno) as $c) {
                $resp .= view('sistema.alunos.includes.curso-preferido', ['curso' => $c])->render();
            }
        }
        if ($request->tipo == 1) {
            foreach (AlunosRepository::getMinhasAulasPreferidas($aluno) as $a) {
                $modulo = BaseRepository::find('modulovod', $a->pivot->modulovod_id);
                $curso = $modulo->curso;
                $resp .= view('sistema.alunos.includes.aula-preferida', ['curso' => $curso, 'modulo' => $modulo, 'aula' => $a])->render();
            }
        }

        return $resp;
    }

    public static function mailChimp(Aluno $aluno)
    {
        $mailchimp = new ApiClient();

        $mailchimp->setConfig([
            'apiKey' => config('app.mailchimp.key'),
            'server' => config('app.mailchimp.server'),
        ]);

        $list_id = config('app.mailchimp.listId');

        try {
            $response = $mailchimp->lists->addListMember($list_id, [
                'email_address' => $aluno->email,
                'status' => 'subscribed',
                'tags' => ['aluno'],
                'merge_fields' => [
                    'FNAME' => $aluno->nome,
                    'LNAME' => $aluno->sobrenome,
                ],
            ]);
        } catch (ClientException $e) {
        }
    }

    public static function locaweb(Aluno $aluno)
    {
        $data = [
            'contact' => [
              'email' => $aluno->email,
              'list_ids' => ['1'],
              'custom_fields' => [
                'nome' => $aluno->nome,
              ],
            ],
          ];
        // pre(json_encode($data));
        $client = new Client([
            'headers' => ['Content-Type' => 'application/json', 'X-Auth-Token' => 'MVTMauPWCFsvUsMBmxr3DR5EEgW9D7RFyx46hiisYHEr'],
            'verify' => false,
          ]);

        try {
            $request = $client->post('https://emailmarketing.locaweb.com.br/api/v1/accounts/124829/contacts', ['body' => json_encode($data)]);
            $response = json_decode($request->getBody()->getContents());
        } catch (ClientException $e) {
            if ($e->hasResponse()) {
                // pre(json_decode($e->getResponse()->getBody()->getContents()));
            }
        }

        // $ch = curl_init();
        // curl_setopt($ch, CURLOPT_URL, 'https://emailmarketing.locaweb.com.br/api/v1/accounts/124829/contacts');
        // curl_setopt($ch, CURLOPT_POST, 1);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));  //Post Fields
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // $headers = [
        //         'X-Auth-Token: MVTMauPWCFsvUsMBmxr3DR5EEgW9D7RFyx46hiisYHEr',
        //         'Content-Type: application/json',
        //     ];

        // curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // $server_output = curl_exec($ch);
        // pre($server_output);

        // curl_close($ch);
    }
}
