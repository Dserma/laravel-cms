<?php

namespace App\Repositories\Sistema;

use App\Models\Ajuda;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Database\Eloquent\Collection;

class BaseRepository
{
    public static function adicionar(String $model, FormRequest $request)
    {
        $model = 'App\Models\\' . ucfirst($model);
        $m = new $model();
        $obj = $model::create($request->all());
        if ($m->hasOrder == true) {
            $last = $m::orderBy('order', 'desc')
                ->when($m->orderKey != null, function ($q) use ($m, $request) {
                    return $q->where($m->orderKey, $request[$m->orderKey]);
                })->first();
            $order = $last->order + 1;
            $obj->order = $order;
            $obj->save();
        }

        return $obj;
    }

    public static function alterar(String $model, Request $request)
    {
        $model = 'App\Models\\' . ucfirst($model);
        $obj = $model::find($request->id);
        $obj->update($request->all());
        $obj->refresh();

        return $obj;
    }

    public static function all(String $model)
    {
        $model = 'App\Models\\' . ucfirst($model);

        return $model::all();
    }

    public static function order(String $model)
    {
        $model = 'App\Models\\' . ucfirst($model);

        return $model::orderBy('order')->get();
    }

    public static function rand(String $model, Int $limit)
    {
        $model = 'App\Models\\' . ucfirst($model);

        return $model::inRandomOrder()->get()->take($limit);
    }

    public static function find(String $model, Int $id)
    {
        $model = 'App\Models\\' . ucfirst($model);

        return $model::find($id);
    }

    public static function delete(String $model, Int $id)
    {
        $model = 'App\Models\\' . ucfirst($model);

        return $model::find($id)->delete();
    }

    public static function get(String $model, array $filter)
    {
        $model = 'App\Models\\' . ucfirst($model);

        return $model::where($filter)->get();
    }

    public static function getIn(String $model, String $field, array $values)
    {
        $model = 'App\Models\\' . ucfirst($model);

        return $model::whereIn($field, $values)->get();
    }

    public static function getNotIn(String $model, String $field, array $values)
    {
        $model = 'App\Models\\' . ucfirst($model);

        return $model::whereNotIn($field, $values)->get();
    }

    public static function toSelect(Collection $items) : array
    {
        return $items->pluck('nome', 'id')->toArray();
    }

    public static function toSelectOther(Collection $items, String $field, String $id) : array
    {
        return $items->pluck($field, $id)->toArray();
    }

    public static function upload(Model $model, Request $request)
    {
        $nameFile = null;
        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            $name = uniqid(date('HisYmd'));
            $extension = $request->file->extension();
            $nameFile = "{$name}.{$extension}";
            $upload = $request->file->storeAs(strtolower(class_basename($model)) . '/' . $model->id, $nameFile);
            $data = ['link' => url('/storage/app/public/' . strtolower(class_basename($model)) . '/' . $model->id . '/') . '/' . $nameFile];

            return response()->json($data);
        }
        $data = ['error' => 'Tamanho máximo excedido! Envie imagens de até 2MB.'];

        return response()->json($data);
    }

    public static function apagaImagemFisica(String $imagem)
    {
        if (Storage::exists($imagem)) {
            Storage::delete($imagem);
        }
    }

    public static function relations(Model $model, String $relation, FormRequest $request)
    {
        $model->$relation()->sync([]);
        $model->$relation()->sync($request->$relation);
    }

    public static function faqs(Request $request)
    {
        if ($request->categoria == null && $request->termo == null) {
            $faqs = self::all('ajuda');
        } else {
            $faqs = Ajuda::whereRaw('1 = 1')
                        ->when($request->categoria != null, function ($q) use ($request) {
                            return $q->where('categoriaajuda_id', $request->categoria);
                        })
                        ->when($request->termo != null, function ($q) use ($request) {
                            return $q->where('titulo', 'like', '%' . $request->termo . '%')
                            ->orWhere('conteudo', 'like', '%' . $request->termo . '%');
                        })->get();
        }

        return $faqs;
    }

    public static function getTexto(String $field, Model $model, String $nome)
    {
        $texto = self::find('configuracoes', 1)->$field;
        $texto = str_replace('[nome]', '<b>' . $model->$nome . '</b>', $texto);
        $texto = str_replace('[email]', $model->$nome, $texto);
        $texto = str_replace('[senha]', $model->$nome, $texto);
        $texto = str_replace('[plano]', $model->plano->nome, $texto);

        return $texto;
    }
}
