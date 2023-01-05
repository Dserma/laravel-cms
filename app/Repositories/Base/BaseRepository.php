<?php

namespace App\Repositories\Base;

use App\Services\Cms;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;
use App\Http\Requests\Backend\BaseRequest;
use Illuminate\Database\Eloquent\Collection as Col;

class BaseRepository
{
    public static function get(Model $model, String $action = null, Request $request)
    {
        $columns = $request->columns;
        $limit = $request->length;
        $start = $request->start;
        $order = $columns[$request->input('order.0.column')]['data'];
        $dir = $request->input('order.0.dir');
        $totalData = $model::count();
        $totalFiltered = $totalData;
        if (!$action) {
            if (empty($request->input('search.value'))) {
                if (isset($model->withAdmin) && $model->withAdmin != null) {
                    $data = $model::with($model->withAdmin)->offset($start)->limit($limit)->orderBy($order, $dir)->get();
                } else {
                    $data = $model->offset($start)->limit($limit)->orderBy($order, $dir)->get();
                }
            } else {
                $search = $request->input('search.value');
                $params = $model->searchAdmin;
                if (isset($model->withAdmin) && $model->withAdmin != null) {
                    $data = $model::with($model->withAdmin)
                        ->where(function ($query) use ($params, $search) {
                            foreach ($params as $k => $v) {
                                $query->orWhere($v, 'LIKE', "%{$search}%");
                            }

                            return $query;
                        })
                        ->offset($start)
                        ->limit($limit)
                        ->orderBy($order, $dir)
                        ->get();
                } else {
                    $data = $model::where(function ($query) use ($params, $search) {
                        foreach ($params as $k => $v) {
                            $query->orWhere($v, 'LIKE', "%{$search}%");
                        }

                        return $query;
                    })
                        ->offset($start)
                        ->limit($limit)
                        ->orderBy($order, $dir)
                        ->get();
                }

                $totalFiltered = $model::where(function ($query) use ($params, $search) {
                    foreach ($params as $k => $v) {
                        $query->orWhere($v, 'LIKE', "%{$search}%");
                    }

                    return $query;
                })
                                ->count();
            }
        } else {
            $actions = (object) $model->$action();
            $filter = (object) $actions->filter;
            $data = $model->where($filter->field, $filter->operator, $filter->value)->offset($start)->limit($limit)->orderBy($order, $dir)->get();
        }
        foreach ($data as $k => $d) {
            if ($model->hasOrder != true) {
                $d->order = 0;
            }
            foreach ($d->formulario as $field => $params) {
                $f = (object) $params;
                if (isset($f->class) && $f->class == 'data-input-mask') {
                    if ($d->$field != null) {
                        $d->$field = dateBdToApp2($d->$field);
                    }
                }
            }
            if ($model->hasForm == true) {
                $d->acoes = '<button class="btn btn-primary btn-editar-spa btn-sm" data-url="' . route('backend.editar', [class_basename($model),$d->id, $action]) . '" data-titulo="Editar ' . class_basename($model) . '" data-toggle="tooltip" title="Ver / Editar ' . class_basename($model) . '"><i class="fa fa-pencil-square-o"></i></button>';
            }
            if (!isset($model->delete) || $model->delete == true) {
                $d->acoes .= ' <button class="btn btn-danger btn-apagar btn-sm" data-url="' . route('backend.apagar', [class_basename($model),$d->id]) . '" data-toggle="tooltip" title="Excluir ' . class_basename($model) . '"><i class="fa fa-trash"></i></button>';
            }
            if ($model->update == false && (!isset($model->delete) || $model->delete == false)) {
                $d->acoes = '';
            }
            if (method_exists($model, 'getActions')) {
                foreach ($model->getActions() as $a) {
                    $act = (object) $a;
                    if ($act->type == 'button') {
                        $d->acoes .= ' <button class="btn btn-' . $act->color . ' ' . $act->class . ' btn-sm" data-url="' . route($act->route, [class_basename($model),$d->id]) . '" data-toggle="tooltip" title="' . $act->title . ' ' . class_basename($model) . '"><i class="fa fa-' . $act->icon . '"></i></button>';
                    } else {
                        $d->acoes .= ' <a class="btn btn-' . $act->color . ' ' . $act->class . ' btn-sm" href="' . route($act->route, [$d->id,$act->model]) . '" data-toggle="tooltip" title="' . $act->title . ' ' . class_basename($model) . '"><i class="fa fa-' . $act->icon . '"></i></a>';
                    }
                }
            }
        }

        $json_data = [
            'draw' => intval($request->input('draw')),
            'recordsTotal' => intval($totalData),
            'recordsFiltered' => intval($totalFiltered),
            'data' => $data,
        ];

        return response()->json($json_data);
    }

    public static function getNormal(Model $model, String $action = null)
    {
        if (!$action) {
            if (isset($model->withAdmin) && $model->withAdmin != null) {
                $data['data'] = $model::with($model->withAdmin)->get();
            } else {
                $data['data'] = $model::all();
            }
        } else {
            $actions = (object) $model->$action();
            $filter = (object) $actions->filter;
            $data['data'] = $model::where($filter->field, $filter->operator, $filter->value)->get();
        }
        foreach ($data['data'] as $d) {
            if ($model->hasOrder != true) {
                $d->order = 0;
            }
            $d->acoes = '';
            if ($model->hasForm == true) {
                $d->acoes .= '<button class="btn btn-primary btn-editar-spa btn-sm" data-url="' . route('backend.editar', [class_basename($model),$d->id, $action]) . '" data-titulo="Editar ' . class_basename($model) . '" data-toggle="tooltip" title="Ver / Editar ' . class_basename($model) . '"><i class="fa fa-pencil-square-o"></i></button>';
            }
            if (!isset($model->delete) || $model->delete == true) {
                $d->acoes .= ' <button class="btn btn-danger btn-apagar btn-sm" data-url="' . route('backend.apagar', [class_basename($model),$d->id]) . '" data-toggle="tooltip" title="Excluir ' . class_basename($model) . '"><i class="fa fa-trash"></i></button>';
            }
            if (method_exists($model, 'getActions')) {
                foreach ($model->getActions() as $a) {
                    $act = (object) $a;
                    if ($act->type == 'button') {
                        $d->acoes .= ' <button class="btn btn-' . $act->color . ' ' . $act->class . ' btn-sm" data-url="' . route($act->route, [class_basename($model),$d->id]) . '" data-toggle="tooltip" title="' . $act->title . ' ' . class_basename($model) . '"><i class="fa fa-' . $act->icon . '"></i></button>';
                    } else {
                        $d->acoes .= ' <a class="btn btn-' . $act->color . ' ' . $act->class . ' btn-sm" href="' . route($act->route, [$d->id]) . '" data-toggle="tooltip" title="' . $act->title . ' ' . class_basename($model) . '"><i class="fa fa-' . $act->icon . '"></i></a>';
                    }
                }
            }
        }

        return response()->json($data);
    }

    public static function getSub(Model $model, Model $pai, Int $id)
    {
        $data['data'] = $model::where(strtolower(class_basename($pai)) . '_id', $id)->get();
        foreach ($data['data'] as $d) {
            if ($model->hasOrder != true) {
                $d->order = 0;
            }
            if ($model->hasForm == true) {
                $d->acoes = '<button class="btn btn-primary btn-editar-spa btn-sm" data-url="' . route('backend.editar', [class_basename($model),$d->id]) . '" data-titulo="Editar ' . class_basename($model) . '" data-toggle="tooltip" title="Ver / Editar ' . class_basename($model) . '"><i class="fa fa-pencil-square-o"></i></button>';
            }
            if (!isset($model->delete) || $model->delete == true) {
                $d->acoes .= ' <button class="btn btn-danger btn-apagar btn-sm" data-url="' . route('backend.apagar', [class_basename($model),$d->id]) . '" data-toggle="tooltip" title="Excluir ' . class_basename($model) . '"><i class="fa fa-trash"></i></button>';
            }
            if ($model->update == false && (!isset($model->delete) || $model->delete == false)) {
                $d->acoes = '';
            }

            if (method_exists($model, 'getActions')) {
                foreach ($model->getActions() as $a) {
                    $act = (object) $a;
                    if ($act->type == 'button') {
                        $d->acoes .= ' <button class="btn btn-' . $act->color . ' ' . $act->class . ' btn-sm" data-url="' . route($act->route, [class_basename($model),$d->id]) . '" data-toggle="tooltip" title="' . $act->title . ' ' . class_basename($model) . '"><i class="fa fa-' . $act->icon . '"></i></button>';
                    } else {
                        $d->acoes .= ' <a class="btn btn-' . $act->color . ' ' . $act->class . ' btn-sm" href="' . route($act->route, [$d->id,$act->model]) . '" data-toggle="tooltip" title="' . $act->title . ' ' . class_basename($model) . '"><i class="fa fa-' . $act->icon . '"></i></a>';
                    }
                }
            }
        }

        return response()->json($data);
    }

    public static function adicionar(Model $model, BaseRequest $request)
    {
        $request = self::checkPassword($model, $request);
        if ($model->hasOrder == true) {
            $request['order'] = 0;
        }
        $object = $model::create($request->all());
        if ($model->hasOrder == true) {
            $last = $model::orderBy('order', 'desc')
                ->when($model->orderKey != null, function ($q) use ($model, $request) {
                    return $q->where($model->orderKey, $request[$model->orderKey]);
                })->first();
            $order = $last->order + 1;
            $object->order = $order;
            $object->save();
        }
        self::checkRelations($object, $request);
        self::checkFiles($object, $request);
    }

    public static function objeto(Model $model, Int $id, String $action = null)
    {
        if (is_int($id)) {
            if (isset($model->withAdmin) && $model->withAdmin != null) {
                $object = $model::with($model->withAdmin)->where('id', $id)->first();
            } else {
                $object = $model::find($id);
            }
            foreach ($model->formulario as $field => $params) {
                $object->action = $action ?? null;
                $f = (object) $params;
                if (isset($f->class) && $f->class == 'dinheiro-input-mask') {
                    $object->$field = currencyToAppOnlyNumbers($object->$field);
                }
                if (isset($f->class) && $f->class == 'data-input-mask') {
                    if ($object->$field != null) {
                        $object->$field = dateBdToApp2($object->$field);
                    }
                }
                if ($f->type == 'manyTo') {
                    $relation = strtolower($field);
                    $load = $object->$relation()->orderBy($f->table . '.id')->get();
                    $object->{'rel_' . $relation} = self::toMany($load);
                }
                if ($f->type == 'file') {
                    $fi = 'file_' . $field;
                    $object->$fi = $f;
                    $object->$field = url('/') . '/public/storage/' . $object->$field;
                }
            }

            return $object;
        }
    }

    public static function salvar(Model $model, BaseRequest $request)
    {
        $object = $model::find($request->id);
        $request = self::checkPassword($model, $request);
        $object->update($request->except(['action']));
        self::checkRelations($object, $request);
        self::checkFiles($object, $request);
    }

    public static function checkRelations(Model $model, BaseRequest $request)
    {
        foreach ($model->formulario as $field => $params) {
            $f = (object) $params;
            if ($f->type == 'manyTo') {
                $attach = strtolower($field);
                $model->$attach()->sync([]);
                $model->$attach()->sync($request->$field);
            }
        }
    }

    private static function checkFiles(Model $model, BaseRequest $request)
    {
        foreach ($request->all() as $field => $value) {
            $f = explode('file_', $field);
            if (count($f) > 1) {
                self::uploadFile($model, $request, $f[1]);
            }
        }
    }

    private static function uploadFile(Model $model, BaseRequest $request, String $field)
    {
        if ($request->hasFile('file_' . $field) && $request->file('file_' . $field)->isValid()) {
            $path = $request->file('file_' . $field)->store('backend');
            $model->$field = $path;
            $model->save();
        }
    }

    public static function apagar(Model $model, Int $id)
    {
        if (is_int($id)) {
            $model::find($id)->delete();
        }
    }

    public static function toSelect(String $model, String $show, String $id = null)
    {
        $model = self::getModel($model);

        return $model::all()->pluck($show, $id ?? 'id')->toArray();
    }

    public static function relatedField(String $model, String $show, Int $id)
    {
        $model = self::getModel($model);
        // pre($model::find($id));
    }

    public static function toMany(Col $object)
    {
        $out = [];
        foreach ($object as $o) {
            $out[] = $o->id;
        }

        return $out;
    }

    public static function getMany(Model $model, String $attach)
    {
        return $model->$attach;
    }

    public static function getModel(String $model)
    {
        $class = 'App\Models\\' . ucfirst($model);

        return new $class();
    }

    public static function checkPassword(Model $model, BaseRequest $request)
    {
        $except[] = 'id';
        if ($request->action) {
            $action = $request->action;
            $list = Cms::makeObject($model->$action());
            foreach ($list->form as $field => $params) {
                $except[] = $field;
            }
            $except[] = 'action';
        }
        foreach ($request->all() as $field => $value) {
            $f = explode('file_', $field);
            if (count($f) > 1) {
                $except[] = $field;
            }
            $f = explode('_id', $field);
            if (count($f) > 1) {
                $except[] = $field;
            }
        }
        foreach ($request->except($except) as $k => $v) {
            $field = (object) $model->formulario[$k];
            if ($field->type != 'info') {
                if ($field->type == 'password' && isset($field->main)) {
                    if ($request->$k != '') {
                        $request[$k] = Hash::make($request->$k);
                        $request[$field->token] = Str::random($field->token_size);
                    } else {
                        unset($request[$k]);
                    }
                }
            }
        }

        return $request;
    }

    public static function checkObject(Model $model)
    {
        $record = $model::first();
        if (!$record) {
            $record = new $model();
            $record->save();
        }

        return $record;
    }

    public static function gallery(Model $model)
    {
        return $model::all();
    }

    public static function reordenar(Model $model, Request $request)
    {
        $obj = $model::where('id', $request->i)
            ->when($model->orderKey != null, function ($q) use ($model, $request) {
                return $q->where($model->orderKey, $request->k);
            })->first();
        if ($model->hasOrder == true) {
            $obj->order = $request->p;
            $obj->save();
        }
    }
}
