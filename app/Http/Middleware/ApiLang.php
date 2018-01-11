<?php
/**
 * Created by PhpStorm.
 * User: Alex4Prog
 * Date: 25/04/2017
 * Time: 02:01 م
 */
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;

class ApiLang
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($request->has('lang') ){
            App::setLocale($request->input('lang'));
        }
        return $next($request);
    }
}
