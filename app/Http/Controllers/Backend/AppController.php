<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use App\Repositories\Base\BaseRepository;
use App\Http\Requests\Backend\BaseRequest;

class AppController extends BackController
{
    public function index()
    {
        if (Auth::guard('backend')->check()) {
            return response()->redirectTo(route('backend.home'));
        }

        return response()->redirectTo(route('backend.form'));
    }

    public function modulo(Model $model, String $action = null)
    {
        if (!isset($model->type) || $model->type == 'post') {
            $view = 'backend.modulo.index';
        }
        if ($model->type == 'page') {
            $view = 'backend.modulo.page';
            $object = BaseRepository::checkObject($model);
        }
        if ($model->type == 'gallery') {
            $view = 'backend.modulo.gallery';
            $object = BaseRepository::gallery($model);
        }

        return view($view, [
          'modelName' => class_basename($model),
          'model' => $model,
          'action' => $action,
          'object' => $object ?? $model,
        ]);
    }

    public function subModulo(Model $pai, Model $model)
    {
        if (!isset($model->type) || $model->type == 'post') {
            $view = 'backend.modulo.index-sub';
        } else {
            $view = 'backend.modulo.page';
            $object = BaseRepository::checkObject($model);
        }

        return view($view, [
          'modelName' => class_basename($model),
          'model' => $model,
          'pai' => $pai,
          'action' => '',
          'object' => $object ?? '',
        ]);
    }

    public function get(Model $model, String $action = null, Request $request)
    {
        if (!isset($model->serverSide) || $model->serverSide == true) {
            return BaseRepository::get($model, $action, $request);
        }

        return BaseRepository::getNormal($model, $action, $request);
    }

    public function getSub(Model $model, Model $pai, Int $id)
    {
        return BaseRepository::getSub($model, $pai, $id);
    }

    public function Inserir(Model $model, BaseRequest $request)
    {
        BaseRepository::adicionar($model, $request);
    }

    public function Objeto(Model $model, Int $id, String $action = null)
    {
        return BaseRepository::objeto($model, $id, $action);
    }

    public function Alterar(Model $model, BaseRequest $request)
    {
        BaseRepository::salvar($model, $request);
    }

    public function Apagar(Model $model, Int $id)
    {
        BaseRepository::apagar($model, $id);
        echo 'OK';
    }

    public function Reordenar(Model $model, Request $request)
    {
        BaseRepository::reordenar($model, $request);
    }

    public function upload(Model $model, Request $request)
    {
        foreach ($request->all() as $k => $v) {
            if ($v instanceof \Illuminate\Http\UploadedFile) {
                $field = $k;
            }
        }
        $nameFile = null;
        if ($request->hasFile('imagem') && $request->file('imagem')->isValid()) {
            $name = uniqid(date('HisYmd'));
            $extension = $request->imagem->extension();
            $nameFile = strtolower(class_basename($model)) . "/{$name}.{$extension}";
            $upload = $request->imagem->storeAs('backend/', $nameFile);
            if (!$upload) {
                return redirect()
              ->back()
              ->with('error', 'Falha ao fazer upload')
              ->withInput();
            }
            ['link' => url('storage/app/public/backend/') . $nameFile];
            $obj = new $model;
            $obj->imagem = $nameFile;
            $obj->save();

            return response()->json(['ok'], 200);
        }
    }

    public function apagarImage(Model $model, Request $request)
    {
        $dir = 'backend/' . class_basename($model) . '/';
        $imagem = $model::find($request->key);
        $arquivo = $dir . '/' . $imagem->imagem;
        Storage::delete($arquivo);
        $imagem->delete();
        $data = [];

        return response()->json($data);
    }
}
