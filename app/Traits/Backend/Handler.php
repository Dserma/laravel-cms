<?php

namespace App\Traits\Backend;

use View;
use App\Services\Cms;
use Illuminate\Http\Request;

trait Handler
{
    protected $user;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = auth()->guard('backend')->user();
            View::share('user', $this->user);

            return $next($request);
        });
        View::share('titulo', '');
        View::share('cms', new Cms());
    }

    /**
     * Share with view
     *
     * @param Request $request
     * @return void
     */
    private function share(Request $request)
    {
    }
}
