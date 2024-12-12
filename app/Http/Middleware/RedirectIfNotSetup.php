<?php

namespace App\Http\Middleware;

use App\Settings\GeneralSetting;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfNotSetup
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!config('app.debug')) {
            try {
                \DB::connection()->getPdo();

                if (!\Schema::hasTable('settings')) {
                    return response(trans('A table was not found! You might have forgotten to run your database migrations.'));
                }
            } catch (\Exception $e) {
                return response(trans('There was an error connecting to the database. Please check your configuration.'));
            }
        }

        if (!app(GeneralSetting::class)->setup_finished) {
            return redirect()->route('setup');
        }

        return $next($request);
    }
}
