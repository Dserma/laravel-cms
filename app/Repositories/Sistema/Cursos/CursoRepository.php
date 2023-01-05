<?php

namespace App\Repositories\Sistema\Cursos;

use Illuminate\Http\Request;
use Aws\Exception\AwsException;
use Aws\CloudFront\CloudFrontClient;
use App\Repositories\Sistema\BaseRepository;
use Illuminate\Database\Eloquent\Collection;

class CursoRepository
{
    public static function getModulos(Request $request)
    {
        $curso = BaseRepository::find('cursovod', $request->v);

        return BaseRepository::toSelectOther($curso->modulos, 'titulo', 'id');
    }

    public static function getAulas(Request $request)
    {
        $modulo = BaseRepository::find('modulovod', $request->v);

        return BaseRepository::toSelectOther($modulo->aulas, 'titulo', 'id');
    }

    public static function getMateriais(Request $request)
    {
        if ($request->c && !$request->m && !$request->a) {
            return self::materiaisCurso($request) ;
        }

        if ($request->c && $request->m && !$request->a) {
            return self::materiaisModulo($request) ;
        }

        if ($request->c && $request->m && $request->a) {
            return self::materiaisAula($request) ;
        }
    }

    protected static function materiaisCurso(Request $request)
    {
        $curso = BaseRepository::find('cursovod', $request->c);
        $aulas = new Collection();
        foreach ($curso->modulos as $modulo) {
            foreach ($modulo->aulas as $aula) {
                $aulas->push($aula);
            }
        }
        $parts = new Collection();
        $backs = new Collection();
        foreach ($aulas as $aula) {
            if ($aula->partituras()->exists()) {
                foreach ($aula->partituras as $part) {
                    $parts->push($part);
                }
            }
            if ($aula->backings()->exists()) {
                foreach ($aula->backings as $b) {
                    $backs->push($b);
                }
            }
        }

        return $parts->concat($backs);
    }

    protected static function materiaisModulo(Request $request)
    {
        $modulo = BaseRepository::find('modulovod', $request->m);
        $aulas = new Collection();
        foreach ($modulo->aulas as $aula) {
            $aulas->push($aula);
        }
        $parts = new Collection();
        $backs = new Collection();
        foreach ($aulas as $aula) {
            if ($aula->partituras()->exists()) {
                foreach ($aula->partituras as $part) {
                    $parts->push($part);
                }
            }
            if ($aula->backings()->exists()) {
                foreach ($aula->backings as $b) {
                    $backs->push($b);
                }
            }
        }

        return $parts->concat($backs);
    }

    protected static function materiaisAula(Request $request)
    {
        $modulo = BaseRepository::find('modulovod', $request->m);
        $aula = $modulo->aulas()->where('aulavod_id', $request->a)->first();

        return $aula->partituras->concat($aula->backings);
    }

    public static function signCookiePolicy($cloudFrontClient, $customPolicy,
    $privateKey, $keyPairId)
    {
        try {
            $result = $cloudFrontClient->getSignedCookie([
                'policy' => $customPolicy,
                'private_key' => $privateKey,
                'key_pair_id' => $keyPairId,
            ]);

            return $result;
        } catch (AwsException $e) {
            return ['Error' => $e->getAwsErrorMessage()];
        }
    }

    public static function signAPrivateDistribution(String $url)
    {
        $resourceKey = $url;
        $expires = time() + 900;
        $customPolicy = <<<POLICY
                {
                    "Statement": [
                        {
                            "Resource": "{$resourceKey}",
                            "Condition": {
                                "DateLessThan": {"AWS:EpochTime": {$expires}}
                            }
                        }
                    ]
                }
            POLICY;
        $privateKey = app_path() . '/aws/pk-APKAIOQSP645LECPJFOQ.pem';
        $keyPairId = 'APKAIOQSP645LECPJFOQ';

        $cloudFrontClient = new CloudFrontClient([
            'profile' => 'default',
            'version' => '2014-11-06',
            'region' => 'us-east-1',
        ]);

        $result = self::signCookiePolicy($cloudFrontClient, $customPolicy, $privateKey, $keyPairId);

        /* If successful, returns something like:
        CloudFront-Policy = eyJTdGF0...fX19XX0_
        CloudFront-Signature = RowqEQWZ...N8vetw__
        CloudFront-Key-Pair-Id = AAPKAJIKZATYYYEXAMPLE
        */
        foreach ($result as $key => $value) {
            setcookie($key, $value, 0, '/', '138.97.241.116', false, false);
        }
    }

    public static function awsCookies()
    {
        $cloudFront = new CloudFrontClient([
                'region' => 'us-east-1',
                'version' => '2014-11-06',
            ]);

        $expires = time() + 900;
        $customPolicy = <<<POLICY
            {
                "Statement": [
                    {
                        "Condition": {
                            "DateLessThan": {"AWS:EpochTime": {$expires}}
                        }
                    }
                ]
            }
            POLICY;
        $signedCookieCustomPolicy = $cloudFront->getSignedCookie([
                'policy' => $customPolicy,
                'private_key' => app_path() . '/aws/pk-APKAIOQSP645LECPJFOQ.pem',
                'key_pair_id' => 'APKAIOQSP645LECPJFOQ',
            ]);

        foreach ($signedCookieCustomPolicy as $name => $value) {
            setcookie($name, $value, 0, '/guitarpedia-novo', '138.97.241.116', false, false);
        }

        return true;
    }
}
