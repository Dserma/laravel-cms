<?php

namespace App\Http\Controllers\Sistema\Auth;

use App\Models\Aluno;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Services\Sistema\SistemaService;
use App\Repositories\Sistema\BaseRepository;
use App\Http\Requests\Sistema\Login\NovaSenha;
use App\Repositories\Sistema\Alunos\AlunosRepository;
use App\Http\Requests\Sistema\Login\EsqueciSenhaRequest;
use App\Models\Professoraovivo;
use App\Repositories\Sistema\Professores\ProfessorRepository;

class AuthController extends Controller
{
    public function confirmaCadastroAluno(Aluno $aluno, Request $request)
    {
        $check = AlunosRepository::confirma($aluno, $request);
    }

    public function senha()
    {
        return view('sistema.recuperar-senha');
    }

    public function senhaPost(EsqueciSenhaRequest $request)
    {
        AlunosRepository::recuperarSenha($request);

        return SistemaService::jsonR(200, 1, 'Um e-mail com as instruções foi enviado para você!!', 0, 3);
    }

    public function novaSenha(Aluno $aluno, String $token)
    {
        if ($aluno) {
            if ($aluno->getRememberToken() === $token) {
                return view('sistema.nova-senha', [
                    'aluno' => $aluno,
                    'token' => $token,
                ]);
            }
        }

        return response()->redirectTo(route('sistema.index'));
    }

    public function novaSenhaProfessor(Professoraovivo $professor, String $token)
    {
        if ($professor) {
            if ($professor->getRememberToken() === $token) {
                return view('sistema.nova-senha', [
                    'professor' => $professor,
                    'token' => $token,
                ]);
            }
        }

        return response()->redirectTo(route('sistema.index'));
    }

    public function novaSenhaPost(NovaSenha $request)
    {
        $aluno = BaseRepository::find('aluno', $request->id);
        if ($aluno) {
            if ($aluno->remember_token === $request->token) {
                $aluno->senha = Hash::make($request->senha);
                $aluno->save();
                AlunosRepository::updateRememberToken($aluno);

                return SistemaService::jsonR(200, 1, 'Sua senha foi alterada com sucesso! Por favor, realize o login com a senha que acabou de criar.', route('sistema.auth'), 1);
            }

            return SistemaService::jsonR(200, 0, 'Este token não é válido!', 0, 2);
        }

        return SistemaService::jsonR(200, 0, 'Este usuário não existe!', 0, 2);
    }

    public function novaSenhaProfessorPost(NovaSenha $request)
    {
        $professor = BaseRepository::find('professoraovivo', $request->id);
        if ($professor) {
            if ($professor->remember_token === $request->token) {
                $professor->senha = Hash::make($request->senha);
                $professor->save();
                ProfessorRepository::updateRememberToken($professor);

                return SistemaService::jsonR(200, 1, 'Sua senha foi alterada com sucesso! Por favor, realize o login com a senha que acabou de criar.', route('sistema.auth'), 1);
            }

            return SistemaService::jsonR(200, 0, 'Este token não é válido!', 0, 2);
        }

        return SistemaService::jsonR(200, 0, 'Este usuário não existe!', 0, 2);
    }
}
