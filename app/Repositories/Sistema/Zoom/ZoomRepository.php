<?php
namespace App\Repositories\Sistema\Zoom;

use App\Models\Agendamentoaovivo;
use App\Repositories\Sistema\BaseRepository;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Support\Str;

class ZoomRepository
{
    public static function criaMeeting(Agendamentoaovivo $aa)
    {
        // $url = 'https://zoom.us/oauth/token?grant_type=authorization_code&code=' . config('app.zoom.token') . '&redirect_uri=http://voxdigital.sytes.net/guitarpedia-novo/zoom';
        // $clientRefresh = new Client([
        //   'auth' => [config('app.zoom.cliente_id'), config('app.zoom.cliente_secret')],
        //   'headers' => [
        //     'Content-Type' => 'application/json',
        //     'Accept' => 'application/json',
        //   ],
        // ]);
        // $requestR = $clientRefresh->post($url);
        // $responseR = $requestR->getBody()->getContents();
        // $configs = BaseRepository::find('configuracoes', 1);
        // $configs->zoom = $responseR;
        // $configs->save();
        $url = 'https://api.zoom.us/v2/';
        $configs = BaseRepository::find('configuracoes', 1);
        $client = new Client([
          'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . json_decode($configs->zoom)->access_token,
          ],
        ]);
        $params = '{
          "topic": "Aula: ' . $aa->aula->categoria->nome . '-' . $aa->aula->professor->fullName . '- Aluno: ' . $aa->aluno->fullName . '",
          "type": 2,
          "start_time": "' . $aa->data . 'T' . $aa->inicio . '",
          "duration": ' . $aa->aula->duracao . ',
          "timezone": "America/Sao_Paulo",
          "password": "' . Str::random(8) . '",
          "agenda": "Aula ao vivo Guitarpedia",
          "settings": {
            "host_video": false,
            "participant_video": false,
            "cn_meeting": false,
            "in_meeting": false,
            "join_before_host": true,
            "mute_upon_entry": true,
            "watermark": true,
            "use_pmi": false,
            "approval_type": 2,
            "registration_type": 3,
            "audio": "both",
            "auto_recording": "none",
            "registrants_email_notification": false
          }
        }';

        try {
            $request = $client->post($url . 'users/me/meetings', ['body' => $params]);
            $ag = BaseRepository::find('agendamentoaovivo', $aa->id);
            $ag->meeting = $request->getBody()->getContents();
            $ag->save();

            return true;
        } catch (Exception $e) {
            if ($e->getResponse()->getStatusCode() == 401) {
                // $url = 'https://zoom.us/oauth/token?grant_type=authorization_code&code=' . config('app.zoom.token') . '&redirect_uri=http://voxdigital.sytes.net/guitarpedia-novo/zoom';
                // $clientRefresh = new Client([
                //   'auth' => [config('app.zoom.cliente_id'), config('app.zoom.cliente_secret')],
                //   'headers' => [
                //     'Content-Type' => 'application/json',
                //     'Accept' => 'application/json',
                //   ],
                // ]);
                // $requestR = $clientRefresh->post($url);
                // $responseR = $requestR->getBody()->getContents();
                // $configs = BaseRepository::find('configuracoes', 1);
                // $configs->zoom = $responseR;
                // $configs->save();
                $url = 'https://zoom.us/oauth/token?grant_type=refresh_token&refresh_token=' . json_decode($configs->zoom)->refresh_token;
                $clientRefresh = new Client([
                  'auth' => [config('app.zoom.cliente_id'), config('app.zoom.cliente_secret')],
                  'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                  ],
                ]);

                try {
                    $requestR = $clientRefresh->post($url);
                    $responseR = $requestR->getBody()->getContents();
                    $configs = BaseRepository::find('configuracoes', 1);
                    $configs->zoom = $responseR;
                    $configs->save();
                    self::criaMeeting($aa);
                } catch (Exception $e) {
                    return false;
                }
            }
        }

        return false;
    }

    public static function encerraMeeting(Agendamentoaovivo $a)
    {
        $url = 'https://api.zoom.us/v2/';
        $configs = BaseRepository::find('configuracoes', 1);
        $client = new Client([
          'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . json_decode($configs->zoom)->access_token,
          ],
        ]);
        $params = ['action' => 'end'];

        try {
            $request = $client->put($url . 'meetings/' . json_decode($a->meeting)->id . '/status', ['body' => json_encode($params)]);
        } catch (Exception $e) {
            if ($e->getResponse()->getStatusCode() == 401) {
                $url = 'https://zoom.us/oauth/token?grant_type=refresh_token&refresh_token=' . json_decode($configs->zoom)->refresh_token;
                $clientRefresh = new Client([
                  'auth' => [config('app.zoom.cliente_id'), config('app.zoom.cliente_secret')],
                  'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                  ],
                ]);
                $requestR = $clientRefresh->post($url);
                $responseR = $requestR->getBody()->getContents();
                $configs = BaseRepository::find('configuracoes', 1);
                $configs->zoom = $responseR;
                $configs->save();
                self::encerraMeeting($a);
            }
        }
    }
}
