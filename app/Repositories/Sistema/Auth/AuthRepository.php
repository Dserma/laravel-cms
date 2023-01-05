<?php
  namespace App\Repositories\Sistema\Auth;

  use Illuminate\Support\Facades\Auth;
  use App\Http\Requests\Sistema\Login\LoginRequest;

  class AuthRepository
  {
      public static function login(LoginRequest $request)
      {
          $credentials = [
            'email' => $request->email,
            'password' => $request->senha,
          ];
          if (Auth::attempt($credentials)) {
              return 'a';
          }
          if (Auth::guard('professor')->attempt($credentials)) {
              return 'p';
          }

          return false;
      }
  }
