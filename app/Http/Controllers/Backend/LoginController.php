<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\Backend\Login\LoginRequest;

class LoginController extends BackController
{
    public function Form()
    {
        if (Auth::guard('backend')->check()) {
            return response()->redirectTo(route('backend.home'));
        }

        return view('backend.login');
    }

    public function Index(LoginRequest $request)
    {
        $this->fazLogin($request);
    }

    public function Sair()
    {
        Auth::guard('backend')->logout();
        // Session::flush();

        return response()->redirectTo(route('backend.index'));
    }

    protected function fazLogin(LoginRequest $request)
    {
        $credentials = [
          'usuario' => $request->usuario,
          'password' => $request->senha,
        ];
        if (Auth::guard('backend')->attempt($credentials)) {
            echo 'OK';
        } else {
            $this->sendFailedLoginResponse($request);
        }
    }

    protected function sendFailedLoginResponse(LoginRequest $request)
    {
        if (!User::where('usuario', $request->usuario)->where('senha', bcrypt($request->senha))->first()) {
            echo 'Senha incorreta!';
            exit;
        }
    }
}
