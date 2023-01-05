<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use App\Repositories\Base\BaseRepository;

class Cms
{
    public static function makeMenu()
    {
        $out = '';
        foreach (config('cms.menu') as $k => $v) {
            $out .= view('backend.shared.links', ['class' => $k, 'params' => (object) $v])->render();
        }
        echo $out;
    }

    public static function makeFields(Model $model, String $action = null, Object $object = null)
    {
        $out = '';
        $rep = '';
        if ($action) {
            $f = self::getForm($model, $action);
            foreach ($f as $k => $v) {
                // $out .= view('backend.parts.hidden', ['field' => $k, 'model' => $model, 'params' => $v])->render();
            }
            // $v->value = $action;
            // $out .= view('backend.parts.hidden', ['field' => 'action', 'model' => $model, 'params' => $v])->render();
        }
        if ($model->hasForm == true) {
            foreach ($model->formulario as $field => $params) {
                $f = (object) $params;
                if ($f->type != 'repeater' && $f->type != 'info') {
                    if (isset($f->relation) && $f->relation != null) {
                        $r = $f->relation;
                    } else {
                        $r = null;
                    }
                    $out .= view('backend.parts.' . $f->type, ['field' => $field, 'model' => $model, 'params' => $f, 'relation' => $r,  'value' => $object->$field ?? null])->render();
                }
                if ($f->type == 'repeater') {
                    $values = json_decode($object->$field, false);
                    $z = 0;
                    $st = '';
                    if ($values) {
                        foreach ($values->$field as $k => $v) {
                            $st .= view('backend.parts.repeater-row', ['counter' => $z])->render();
                            foreach ($f->fields as $fi => $p) {
                                $fip = (object) $p;
                                $st .= view('backend.parts.' . $fip->type, ['field' => $field . '_' . $fi . '[]', 'model' => $model, 'params' => $fip, 'value' => $v->$fi ?? null])->render();
                            }
                            $rep = $st .= view('backend.parts.repeater-row-end', ['params' => $f, 'remove' => (int) $z])->render();
                            $z++;
                        }
                    } else {
                        $st .= view('backend.parts.repeater-row', ['counter' => $z])->render();
                        foreach ($f->fields as $fi => $p) {
                            $fip = (object) $p;
                            $st .= view('backend.parts.' . $fip->type, ['field' => $field . '_' . $fi . '[]', 'model' => $model, 'params' => $fip, 'value' => $v->$fi ?? null])->render();
                        }
                        $rep = $st .= view('backend.parts.repeater-row-end', ['params' => $f, 'remove' => (int) $z])->render();
                    }
                    $out .= view('backend.parts.' . $f->type, ['field' => $field, 'model' => $model, 'params' => $f, 'fields' => $rep, 'value' => null])->render();
                }
            }
        } else {
            $out = '';
        }
        echo $out;
    }

    public static function makeTable(Model $model)
    {
        $out = '';
        foreach ($model->listagem as $item => $valor) {
            if (!is_array($valor)) {
                if (is_int($item)) {
                    $item = $valor;
                }
                $out .= '<th>' . ucfirst($item) . '</th>';
            } else {
                if (empty($valor['title'])) {
                    $label = ucfirst($item);
                } else {
                    $label = ucfirst($valor['title']);
                }
                $out .= '<th>' . $label . '</th>';
            }
        }
        echo $out;
    }

    public static function makeData(Model $model)
    {
        $out = '';
        foreach ($model->listagem as $item => $valor) {
            if (!is_array($valor)) {
                $out .= '{ "data": "' . $valor . '" },';
            } else {
                $s = empty($valor['value']) ? $item : $valor['value'];
                $out .= '{ "data": "' . $s . '", "orderable":' . $valor['order'] . '},';
            }
        }
        echo $out;
    }

    public static function makeDefs(Model $model)
    {
        $out = '';
        if (is_array($model->defs)) {
            foreach ($model->defs as $item => $valor) {
                $out .= '{ "type": "' . $valor . '", targets: ' . $item . ' },';
            }
        }
        echo $out;
    }

    public static function getListToSelect(String $model, String $show, String $id = null)
    {
        return BaseRepository::toSelect($model, $show, $id);
    }

    public static function getRelatedField(String $model, String $show, Int $id)
    {
        return BaseRepository::relatedField($model, $show, $id);
    }

    public static function getMany(Model $model, String $attach)
    {
        return BaseRepository::getMany($model, $attach);
    }

    public static function getForm(Model $model, String $action)
    {
        $params = self::makeObject($model->$action());

        return $params->form;
    }

    public static function makeObject($array)
    {
        return json_decode(json_encode($array), false);
    }
}
