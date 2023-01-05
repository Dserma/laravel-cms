<?php

namespace App\Rules;

use App\Models\Aluno;
use App\Models\Professoraovivo;
use Illuminate\Contracts\Validation\Rule;

class EmailAlunoProfessor implements Rule
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
        $aluno = Aluno::where('email', $value)->first();
        if ($aluno) {
            return true;
        }
        $professor = Professoraovivo::where('email', $value)->first();
        if ($professor) {
            return true;
        }

        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'E-mail não encontrado!';
    }
}
