<?php

namespace App\Http\Requests\Backend;

use App\Services\Cms;
use Illuminate\Foundation\Http\FormRequest;

class BaseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function prepareForValidation()
    {
        foreach ($this->model->formulario as $field => $params) {
            $f = (object) $params;
            if (isset($f->class) && $f->class == 'dinheiro-input-mask' && (float) $this->$field > 0) {
                $this->merge([
                  $field => currencyToBd($this->$field),
                ]);
            }
        }
        foreach ($this->all() as $field => $value) {
            $file = explode('file_', $field);
            if (count($file) > 1) {
                $this->merge([
                    $file[1] => $this->$field,
                ]);
            }
        }
        // pre($this->all());
    }

    protected function passedValidation()
    {
        foreach ($this->model->formulario as $field => $params) {
            $f = (object) $params;
            if (isset($f->date) && $f->date == true) {
                $this->merge([
                  $field => dateAppToBd($this->$field),
                ]);
            }
            if (isset($f->class) && $f->class == 'data-input-mask' && $this->$field > 0) {
                $this->merge([
                  $field => dateAppToBd($this->$field),
                ]);
            }
            if ($f->type == 'repeater') {
                foreach ($f->fields as $k => $v) {
                    $name = $field . '_' . $k;
                    $array[$field][$k] = $this->$name;
                    $this->offsetUnset($name);
                }
                foreach ($array[$field] as $fi => $va) {
                    $x = 0;
                    foreach ($va as $text) {
                        $narray[$field][$x][$fi] = $text;
                        $x++;
                    }
                }
                $this->merge([
                  $field => json_encode($narray),
                ]);
            }
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $values = [];
        if (isset($this->action)) {
            $action = $this->action;
            $list = Cms::makeObject($this->model->$action());
            foreach ($list->form as $field => $params) {
                if (isset($params->validators) && $params->validators != null) {
                    $values[$field] = str_replace('$this->id', $this->id, $params->validators);
                }
            }
        }
        foreach ($this->model->formulario as $field => $params) {
            $f = (object) $params;
            if (isset($f->validators) && $f->validators != null) {
                $values[$field] = str_replace('$this->id', $this->id, $f->validators);
            }
            if ($f->type == 'repeater') {
                foreach ($f->fields as $k => $v) {
                    $fr = (object) $v;
                    if (isset($fr->validators) && $fr->validators != null) {
                        $values[$field . '_' . $k . '.*'] = str_replace('$this->id', $this->id, $fr->validators);
                    }
                }
            }
        }
        // pre($values);

        return $values;
    }
}
