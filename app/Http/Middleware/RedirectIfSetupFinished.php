<?php

namespace App\Http\Middleware;

use App\Settings\GeneralSetting;
use Closure;
use Illuminate\Http\Request;

class RedirectIfSetupFinished
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (! config('app.debug')) {
            try {
                \DB::connection()->getPdo();

                if (! \Schema::hasTable('settings')) {
                    return response(trans('A table was not found! You might have forgotten to run your database migrations.'));
                }
            } catch (\Exception $e) {
                return response(trans('There was an error connecting to the database. Please check your configuration.'));
            }
        }

        if (app(GeneralSetting::class)->setup_finished) {
            return redirect('/');
        }

        return $next($request);
    }
}
