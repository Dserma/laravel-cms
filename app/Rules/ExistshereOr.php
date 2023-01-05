<?php

namespace App\Rules;

use App\Models\Aluno;
use App\Models\Professoraovivo;
use Illuminate\Contracts\Validation\Rule;

class ExistshereOr implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (!Aluno::where($attribute, $value)->first()) {
            if (!Professoraovivo::where($attribute, $value)->first()) {
                return false;
            }
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'E-mail não encontrado.';
    }
}
