<?php
namespace App\Presenters\Professores;

use Illuminate\Support\Str;
use App\Presenters\Presenter;
use App\Models\Imagemprofessoraovivo;
use App\Repositories\Sistema\BaseRepository;
use App\Models\Disponibilidadeprofessoraovivo;

class ProfessorPresenter extends Presenter
{
    public function fullName()
    {
        return $this->nome . ' ' . $this->sobrenome;
    }

    public function imagem(Imagemprofessoraovivo $imagem)
    {
        return url('storage/app/public/professoraovivo/') . '/' . $this->id . '/' . $imagem->imagem;
    }

    public function dias(Disponibilidadeprofessoraovivo $d, $short = false)
    {
        $dias = [
            1 => 'Segunda',
            2 => 'Terça',
            3 => 'Quarta',
            4 => 'Quinta',
            5 => 'Sexta',
            6 => 'Sábado',
            0 => 'Domingo',
        ];
        if ($short == true) {
            $dias = [
                1 => 'Seg',
                2 => 'Ter',
                3 => 'Qua',
                4 => 'Qui',
                5 => 'Sex',
                6 => 'Sáb',
                0 => 'Dom',
            ];
        }
        $resp = [];
        foreach (explode(',', $d->dias) as $di) {
            $resp[] = $dias[$di];
        }

        return implode(', ', $resp);
    }

    public function horas(String $hora)
    {
        return Str::substr($hora, 0, 5);
    }

    public function embed()
    {
        $video = $this->video;
        $v = explode('v=', $video);

        return 'https://www.youtube.com/embed/' . end($v);
    }

    public function thumb()
    {
        $video = $this->video;
        $v = explode('v=', $video);

        return 'https://img.youtube.com/vi/' . end($v) . '/0.jpg';
    }

    public function estado(Int $id = null)
    {
        if ($id) {
            return BaseRepository::find('estado', $id)->letter;
        }
    }

    public function cidade(Int $id = null)
    {
        if ($id) {
            return BaseRepository::find('cidade', $id)->iso;
        }
    }

    public function valorBase()
    {
        return $this->aulas->sortBy('valor')->first();
    }

    public function checkDadosbancarios()
    {
        if ($this->tipo_conta == null || $this->banco == null || $this->agencia == null || $this->conta == null || $this->digito == null) {
            return false;
        }

        return true;
    }

    public function categoriasAulas()
    {
        $array = [];
        foreach ($this->aulas as $a) {
            $array[$a->categoria->id] = $a->categoria->nome;
        }

        return $array;
    }
}
